<?php

declare(strict_types=1);

namespace App\Controller;

use App\CustomResponse as Response;
use App\Helper;
use App\Service\OfficeService;
use Exception;
use Pimple\Psr11\Container;
use Psr\Http\Message\ServerRequestInterface as Request;

final class OfficeController
{
  private OfficeService $officeService;

  public function __construct(private readonly Container $container)
  {
    $this->officeService = $this->container->get('officeService');
  }

  public function getAll(Request $request, Response $response, array $args): Response
  {
    try {
      $result = $this->officeService->getAll();
      return $response->withJson($result);
    } catch (Exception $e) {
      return $response->withJson(['error' => $e->getMessage()], 500);
    }
  }

  public function getOne(Request $request, Response $response, array $args): Response
  {
    try {
      $result = $this->officeService->getOne((string) $args['id']);
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
          'name' => $input['name'] ,
      ];

      $dto = array_filter($dto, fn($value) => $value !== null);

      $this->officeService->create($dto);
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
      ];

      $dto = array_filter($dto, fn($value) => $value !== null);

      $this->officeService->update((string) $args['id'], $dto);
      return $response->withStatus(204);
    } catch (Exception $e) {
      return $response->withJson(['error' => $e->getMessage()], 500);
    }
  }

  public function delete(Request $request, Response $response, array $args): Response
  {
   try {
     $result = $this->officeService->delete((string) $args['id']);
     return $response->withJson($result);
   } catch (Exception $e) {
     return $response->withJson(['error' => $e->getMessage()], 400);
   }
  }

}