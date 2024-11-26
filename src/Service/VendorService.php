<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\DBAL\Connection;
use Exception;

final class VendorService
{
  public function __construct(private readonly Connection $conn)
  {
  }
  public function getAll(): array
  {
    return $this->conn->fetchAllAssociative(
      'SELECT id, name, contactPerson, email, phoneNumber, status, description
       FROM Vendor
       ORDER BY id ASC'
    );
  }


  public function getOne(string $id): array
  {
    $result = $this->conn->fetchAssociative(
      'SELECT id, name, contactPerson, email, phoneNumber, status, description 
       FROM Vendor 
       WHERE id = ?',
       [$id]
    );

    if (!$result) {
      throw new Exception('Vendor not found');
    }
    return $result;
  }
  public function create($data): int|string
  {
    return $this->conn->insert('Vendor', $data);
  }

  public function update(string $id, $data): int|string
  {
    return $this->conn->update('Vendor', $data, ['id' => $id]);
  }

  public function delete(string $id): int|string
  {
    return $this->conn->delete('Vendor', ['id' => $id]);
  }
}
