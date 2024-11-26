<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\DBAL\Connection;
use Exception;

final class AssetService
{
  public function __construct(private readonly Connection $conn) {}
  public function getAll(): array
  {
    return $this->conn->fetchAllAssociative(
      'SELECT at.id, at.name, at.description, ct.name as categoryName, at.createdAt, at.updatedAt
       FROM Asset at
       LEFT JOIN Category ct ON at.categoryId = ct.id
       ORDER BY at.id ASC'
    );
  }

  public function getOne(string $id): array
  {
    $result = $this->conn->fetchAssociative(
      'SELECT at.id, at.name, at.description, ct.name as categoryName, at.createdAt, at.updatedAt
       FROM Asset at
       LEFT JOIN Category ct ON at.categoryId = ct.id
       WHERE at.id = ?',
      [$id]
    );

    if (!$result) {
      throw new Exception('Asset not found');
    }
    return $result;
  }

  public function getByCategory(string $categoryId): array
  {
    return $this->conn->fetchAllAssociative(
      'SELECT at.id, at.name, at.description, ct.name as categoryName, at.createdAt, at.updatedAt
       FROM Asset at
       LEFT JOIN Category ct ON at.categoryId = ct.id
       WHERE ct.id = ?
       ORDER BY at.id ASC',
      [$categoryId]
    );
  }

  public function create($data): int|string
  {
    return $this->conn->insert('Asset', $data);
  }

  public function update(string $id, $data): int|string
  {
    return $this->conn->update('Asset', $data, ['id' => $id]);
  }

  public function delete(string $id): int|string
  {
    return $this->conn->delete('Asset', ['id' => $id]);
  }

  public function transfer(string $id, string $locationId): void
  {
    $this->update($id, [
      'locationId' => $locationId,
      'updatedAt' => (new \DateTime())->format('Y-m-d H:i:s')
    ]);
  }
}
