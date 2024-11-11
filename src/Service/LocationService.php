<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\DBAL\Connection;
use Exception;

final class LocationService
{
  public function __construct(private readonly Connection $conn) {}
  public function getAll(): array
  {
    return $this->conn->fetchAllAssociative(
      'SELECT l.id, l.name, l.type, p.name as parentLocation, l.description, l.isBlocked
       FROM Location l
       LEFT JOIN Location p ON l.parentLocation = p.id
       ORDER BY l.id ASC'
    );
  }


  public function getOne(string $id): array
  {
    $result = $this->conn->fetchAssociative(
      'SELECT l.id, l.name, l.type, p.name as parentLocation, l.description, l.isBlocked
       FROM Location l
       LEFT JOIN Location p ON l.parentLocation = p.id
       WHERE l.id = ?',
      [$id]
    );

    if (!$result) {
      throw new Exception('Location not found');
    }
    return $result;
  }
  public function create($data): int|string
  {
    return $this->conn->insert('Location', $data);
  }

  public function update(string $id, $data): int|string
  {
    return $this->conn->update('Location', $data, ['id' => $id]);
  }

  public function delete(string $id): int|string
  {
    return $this->conn->delete('Location', ['id' => $id]);
  }

  public function toggleBlock(string $id): int|string
  {
    $location = $this->getOne($id);
    return $this->conn->update(
      'Location',
      ['isBlocked' => (int)(!$location['isBlocked'])],
      ['id' => $id]
    );
  }
}
