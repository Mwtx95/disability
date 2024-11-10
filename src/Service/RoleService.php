<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\DBAL\Connection;
use Exception;

final class RoleService
{
  public function __construct(private readonly Connection $conn)
  {
  }
  public function getAll(): array
  {
    return $this->conn->fetchAllAssociative(
      'SELECT id, name
       FROM Role
       ORDER BY id ASC'
    );
  }


  public function getOne(string $id): array
  {
    $result = $this->conn->fetchAssociative(
      'SELECT id, name 
       FROM Role 
       WHERE id = ?',
       [$id]
    );

    if (!$result) {
      throw new Exception('Role not found');
    }
    return $result;
  }
  public function create($data): int|string
  {
    return $this->conn->insert('Role', $data);
  }

  public function update(string $id, $data): int|string
  {
    return $this->conn->update('Role', $data, ['id' => $id]);
  }

  public function delete(string $id): int|string
  {
    return $this->conn->delete('Role', ['id' => $id]);
  }
}
