<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\DBAL\Connection;
use Exception;

final class CategoryService
{
  public function __construct(private readonly Connection $conn) {}
  public function getAll(): array
  {
    return $this->conn->fetchAllAssociative(
      'SELECT id, name, description, isBlocked
       FROM Category
       ORDER BY id ASC'
    );
  }

  public function getAllWithExtraInfo(): array
  {
    $categories = $this->conn->fetchAllAssociative(
      'SELECT c.id, c.name, c.description, c.isBlocked,
              COUNT(DISTINCT CASE WHEN ai.status = "AVAILABLE" THEN ai.id END) as availableCount,
              COUNT(DISTINCT CASE WHEN ai.status = "MAINTENANCE" THEN ai.id END) as maintenanceCount,
              COUNT(DISTINCT CASE WHEN ai.status = "BROKEN" THEN ai.id END) as brokenCount,
              COUNT(DISTINCT CASE WHEN ai.status = "ASSIGNED" THEN ai.id END) as assignedCount
       FROM Category c
       LEFT JOIN Asset a ON c.id = a.categoryId
       LEFT JOIN AssetItem ai ON a.id = ai.assetId
       GROUP BY c.id, c.name, c.description, c.isBlocked
       ORDER BY c.id ASC'
    );

    return $categories;
  }

  public function getOne(string $id): array
  {
    $result = $this->conn->fetchAssociative(
      'SELECT id, name, description, isBlocked
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

  public function toggleBlock(string $id): int|string
  {
    $category = $this->getOne($id);
    return $this->conn->update(
      'Category',
      ['isBlocked' => (int)(!$category['isBlocked'])],
      ['id' => $id]
    );
  }
}
