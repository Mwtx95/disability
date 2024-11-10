<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\DBAL\Connection;
use Exception;
use Firebase\JWT\JWT;

final class AuthService
{
    public function __construct(private readonly Connection $conn)
    {
    }

    public function login(string $username, string $password): array
    {
        $user = $this->conn->fetchAssociative(
            'SELECT id, username, password, isActive 
             FROM User 
             WHERE username = ?',
            [$username]
        );

        if (!$user) {
            throw new Exception('User not found', 404);
        }

        if (!password_verify($password, $user['password'])) {
            throw new Exception('Invalid password', 401);
        }

        if (!$user['isActive']) {
            throw new Exception('User is not active', 403);
        }

        $token = $this->generateToken($user['id']);
        $refreshToken = $this->generateRefreshToken();

        $this->conn->update('User', 
            ['refreshToken' => $refreshToken],
            ['id' => $user['id']]
        );

        return [
            'token' => $token,
            'refreshToken' => $refreshToken,
            'userId' => $user['id']
        ];
    }

    public function register(array $data): array
    {
        $this->conn->insert('User', $data);
        $userId = $this->conn->lastInsertId();

        return [
            'userId' => $userId,
            'message' => 'User registered successfully'
        ];
    }

    public function logout(int $userId): array
    {
        $this->conn->update('User',
            ['refreshToken' => null],
            ['id' => $userId]
        );

        return ['message' => 'Logged out successfully'];
    }

    private function generateToken(int $userId): string
    {
        $payload = [
            'userId' => $userId,
            'iat' => time(),
            'exp' => time() + (60 * 60) // Token expires in 1 hour
        ];

        return JWT::encode(
            $payload,
            '7w8&^7af9*!o%j#)b$#k*p2w#q9@s1z&3n1!&y^vq36znm7!%h',
            'HS256'
        );
    }

    private function generateRefreshToken(): string
    {
        return bin2hex(random_bytes(32));
    }
} 