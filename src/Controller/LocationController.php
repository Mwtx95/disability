<?php

declare(strict_types=1);

namespace App\Controller;

use App\CustomResponse as Response;
use App\Helper;
use App\Service\LocationService;
use Exception;
use Pimple\Psr11\Container;
use Psr\Http\Message\ServerRequestInterface as Request;

final class LocationController
{
  private LocationService $locationService;

  public function __construct(private readonly Container $container)
  {
    $this->locationService = $this->container->get('locationService');
  }

  public function getAll(Request $request, Response $response, array $args): Response
  {
    try {
      $result = $this->locationService->getAll();
      return $response->withJson($result);
    } catch (Exception $e) {
      return $response->withJson(['error' => $e->getMessage()], 500);
    }
  }

  public function getOne(Request $request, Response $response, array $args): Response
  {
    try {
      $result = $this->locationService->getOne((string) $args['id']);
      return $response->withJson($result);
    } catch (Exception $e) {
      return $response->withJson(['error' => $e->getMessage()], 404);
    }
  }

  public function create(Request $request, Response $response, array $args): Response
  {
    try {
      $input = $request->getParsedBody();

      $dto = [
        'name' => $input['name'],
        'type' => $input['type'],
        'parentLocation' => $input['parentLocation'] ?: null,
        'description' => $input['description'] ?: null,
        'isBlocked' => 0,
      ];

      $dto = array_filter($dto, fn($value) => $value !== null);

      $this->locationService->create($dto);
      return $response->withStatus(201);
    } catch (Exception $e) {
      $duplicateErrorCode = 1062;
      $foreignErrorCode = 1452;

      if ($e->getCode() === $duplicateErrorCode) {
        return $response->withJson(['error' => 'The data you try to insert already exists'], 409);
      } else if ($e->getCode() === $foreignErrorCode) {
        $error = Helper::getForeignKeyErrorMessage($e->getMessage());
        return $response->withJson(['error' => $error], 404);
      } else {
        return $response->withJson(['error' => $e->getMessage()], 500);
      }
    }
  }

  public function update(Request $request, Response $response, array $args): Response
  {
    try {
      $input = $request->getParsedBody();

      $dto = [
        'name' => $input['name'] ?: null,
        'type' => $input['type'] ?: null,
        'parentLocation' => $input['parentLocation'] ?: null,
        'description' => $input['description'] ?: null,
      ];

      $dto = array_filter($dto, fn($value) => $value !== null);

      $this->locationService->update((string) $args['id'], $dto);
      return $response->withStatus(204);
    } catch (Exception $e) {
      return $response->withJson(['error' => $e->getMessage()], 500);
    }
  }

  public function delete(Request $request, Response $response, array $args): Response
  {
    try {
      $result = $this->locationService->delete((string) $args['id']);
      return $response->withJson($result);
    } catch (Exception $e) {
      return $response->withJson(['error' => $e->getMessage()], 400);
    }
  }

  public function toggleBlock(Request $request, Response $response, array $args): Response
  {
    try {
      $this->locationService->toggleBlock((string) $args['id']);
      return $response->withStatus(204);
    } catch (Exception $e) {
      return $response->withJson(['error' => $e->getMessage()], 404);
    }
  }
}
