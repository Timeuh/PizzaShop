<?php

namespace pizzashop\auth\api\app\auth\managers;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use pizzashop\auth\api\domain\exception\JwtException;
use stdClass;
use UnexpectedValueException;


class JwtManager {
    public function create(array $user): string {
        $payload = [
            'iss' => "pizza-shop.auth.db",
            'iat' => time(),
            'exp' => time() + $_ENV['JWT_EXPIRATION'],
            'upr' => [
                'username' => $user['username'],
                'email' => $user['email'],
            ],
        ];

        return JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS512');
    }

    public function validate(string $token): stdClass {
        try {
            return JWT::decode($token, new Key($_ENV('JWT_SECRET'), 'HS512'));
        } catch (ExpiredException $e) {
            throw new JwtException('expired');
        } catch (SignatureInvalidException $e) {
            throw new JwtException('signature');
        } catch (UnexpectedValueException $e) {
            throw new JwtException('invalid');
        }
    }
}
