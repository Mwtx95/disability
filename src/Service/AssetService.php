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
      'SELECT at.id, at.name, at.description, ct.name as categoryName, at.status, l.name as locationName, at.createdAt, at.updatedAt
       FROM Asset at
       LEFT JOIN Category ct ON at.categoryId = ct.id
       LEFT JOIN Location l ON at.locationId = l.id
       ORDER BY at.id ASC'
    );
  }

  public function getOne(string $id): array
  {
    $result = $this->conn->fetchAssociative(
      'SELECT at.id, at.name, at.description, ct.name as categoryName, at.status, l.name as locationName, at.createdAt, at.updatedAt
       FROM Asset at
       LEFT JOIN Category ct ON at.categoryId = ct.id
       LEFT JOIN Location l ON at.locationId = l.id
       WHERE at.id = ?',
      [$id]
    );

    if (!$result) {
      throw new Exception('Asset not found');
    }
    return $result;
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
}
