<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\DBAL\Connection;
use Exception;

final class UserProfileService
{
  public function __construct(private readonly Connection $conn) {}
  public function getAll(): array
  {
    return $this->conn->fetchAllAssociative(
      'SELECT id, userId, roleId, locationId
       FROM UserProfile
       ORDER BY id ASC'
    );
  }


  public function getOne(string $id): array
  {
    $result = $this->conn->fetchAssociative(
      'SELECT id, userId, roleId, locationId 
       FROM UserProfile 
       WHERE id = ?',
      [$id]
    );

    if (!$result) {
      throw new Exception('UserProfile not found');
    }
    return $result;
  }
  public function create($data): int|string
  {
    return $this->conn->insert('UserProfile', $data);
  }

  public function update(string $id, $data): int|string
  {
    return $this->conn->update('UserProfile', $data, ['id' => $id]);
  }

  public function delete(string $id): int|string
  {
    return $this->conn->delete('UserProfile', ['id' => $id]);
  }
}
