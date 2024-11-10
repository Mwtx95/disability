<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\DBAL\Connection;
use Exception;

final class CategoryService
{
  public function __construct(private readonly Connection $conn)
  {
  }
  public function getAll(): array
  {
    return $this->conn->fetchAllAssociative(
      'SELECT id, name
       FROM Category
       ORDER BY id ASC'
    );
  }


  public function getOne(string $id): array
  {
    $result = $this->conn->fetchAssociative(
      'SELECT id, name 
       FROM Category 
       WHERE id = ?',
       [$id]
    );

    if (!$result) {
      throw new Exception('Category not found');
    }
    return $result;
  }
  public function create($data): int|string
  {
    return $this->conn->insert('Category', $data);
  }

  public function update(string $id, $data): int|string
  {
    return $this->conn->update('Category', $data, ['id' => $id]);
  }

  public function delete(string $id): int|string
  {
    return $this->conn->delete('Category', ['id' => $id]);
  }
}
