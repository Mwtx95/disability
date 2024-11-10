<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\DBAL\Connection;
use Exception;

final class UserService
{
  public function __construct(private readonly Connection $conn)
  {
  }
  public function getAll(): array
  {
    return $this->conn->fetchAllAssociative(
      'SELECT id, username, password, email, refreshToken, isActive
       FROM User
       ORDER BY id ASC'
    );
  }


  public function getOne(string $id): array
  {
    $result = $this->conn->fetchAssociative(
      'SELECT id, username, password, email, refreshToken, isActive 
       FROM User 
       WHERE id = ?',
       [$id]
    );

    if (!$result) {
      throw new Exception('User not found');
    }
    return $result;
  }
  public function create($data): int|string
  {
    return $this->conn->insert('User', $data);
  }

  public function update(string $id, $data): int|string
  {
    return $this->conn->update('User', $data, ['id' => $id]);
  }

  public function delete(string $id): int|string
  {
    return $this->conn->delete('User', ['id' => $id]);
  }
}
