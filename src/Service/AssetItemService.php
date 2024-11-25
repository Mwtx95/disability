<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\DBAL\Connection;
use Exception;

final class AssetItemService
{
  public function __construct(private readonly Connection $conn)
  {
  }
  public function getAll(): array
  {
    return $this->conn->fetchAllAssociative(
      'SELECT ai.id, ai.assetId, ai.quantity, ai.price, ai.status, ai.locationId, ai.vendorId,
              a.name as assetName, l.name as locationName
       FROM AssetItem ai
       JOIN Asset a ON ai.assetId = a.id
       JOIN Location l ON ai.locationId = l.id
       ORDER BY ai.id ASC'
    );
  }


  public function getOne(string $id): array
  {
    $result = $this->conn->fetchAssociative(
      'SELECT ai.id, ai.assetId, ai.quantity, ai.price, ai.status, ai.locationId, ai.vendorId,
              a.name as assetName, l.name as locationName
       FROM AssetItem ai
       JOIN Asset a ON ai.assetId = a.id
       JOIN Location l ON ai.locationId = l.id
       WHERE ai.id = ?',
       [$id]
    );

    if (!$result) {
      throw new Exception('AssetItem not found');
    }
    return $result;
  }
  public function create($data): int|string
  {
    return $this->conn->insert('AssetItem', $data);
  }

  public function update(string $id, $data): int|string
  {
    return $this->conn->update('AssetItem', $data, ['id' => $id]);
  }

  public function delete(string $id): int|string
  {
    return $this->conn->delete('AssetItem', ['id' => $id]);
  }
}
