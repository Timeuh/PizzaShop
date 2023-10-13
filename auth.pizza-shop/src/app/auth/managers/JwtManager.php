<?php

namespace pizzashop\auth\api\app\auth\managers;

use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;


class JwtManager {
    public function create(array $user) : string {
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

    public function validateToken($token) {
        try {
            $h = $rq->getHeader('Authorization')[0];
            if (empty($h)) {
                return false; // Aucun header "Authorization" trouvé
            }

            $tokenString = sscanf($h[0], "Bearer %s")[0];
            $token = JWT::decode($tokenString, new Key(getenv('JWT_SECRET'), 'HS512'));
            return $token;
        } catch (ExpiredException $e) {
            return false; // Token expiré
        } catch (SignatureInvalidException $e) {
            return false; // Signature invalide
        } catch (BeforeValidException $e) {
            return false; // Token pas encore valide
        } catch (\UnexpectedValueException $e) {
            return false; // Valeur du token inattendue
        }
    }
}
