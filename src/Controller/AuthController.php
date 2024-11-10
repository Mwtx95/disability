<?php

declare(strict_types=1);

namespace App\Controller;

use App\CustomResponse as Response;
use App\Service\AuthService;
use Exception;
use Pimple\Psr11\Container;
use Psr\Http\Message\ServerRequestInterface as Request;

final class AuthController
{
    private AuthService $authService;

    public function __construct(private readonly Container $container)
    {
        $this->authService = $this->container->get('authService');
    }

    public function login(Request $request, Response $response): Response
    {
        try {
            $input = $request->getParsedBody();
            
            if (!isset($input['username']) || !isset($input['password'])) {
                throw new Exception('Username and password are required', 400);
            }

            $result = $this->authService->login($input['username'], $input['password']);
            return $response->withJson($result);
        } catch (Exception $e) {
            $status = $e->getCode() ?: 500;
            return $response->withJson(['error' => $e->getMessage()], $status);
        }
    }

    public function register(Request $request, Response $response): Response
    {
        try {
            $input = $request->getParsedBody();
            
            if (!isset($input['username']) || !isset($input['password']) || !isset($input['email'])) {
                throw new Exception('Username, password and email are required', 400);
            }

            $dto = [
                'username' => $input['username'],
                'password' => password_hash($input['password'], PASSWORD_DEFAULT),
                'email' => $input['email'],
                'isActive' => 1
            ];

            $result = $this->authService->register($dto);
            return $response->withJson($result, 201);
        } catch (Exception $e) {
            $duplicateErrorCode = 1062;
            if ($e->getCode() === $duplicateErrorCode) {
                return $response->withJson(['error' => 'Username or email already exists'], 409);
            }
            return $response->withJson(['error' => $e->getMessage()], 500);
        }
    }

    public function logout(Request $request, Response $response): Response
    {
        try {
            $input = $request->getParsedBody();
            $decoded = $input['decoded'];
            
            $result = $this->authService->logout($decoded->userId);
            return $response->withJson($result);
        } catch (Exception $e) {
            return $response->withJson(['error' => $e->getMessage()], 500);
        }
    }
} 