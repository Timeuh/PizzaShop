<?php

namespace auth\app\auth;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException ;
use Firebase\JWT\BeforeValidException;


class JwtManager
{
    private $secret;

    public function createToken($user)
    {
        try {
            $secret = bin2hex(random_bytes(32));
        } catch (Exception $e) {
        }
        file_put_contents('auth.env', 'JWT_SECRET=' . $secret . PHP_EOL, FILE_APPEND);

        $payload = [
            "iss" => "pizza-shop.auth.db",
            "aud" => "api.pizza-shop",
            "iat" => time(),
            "exp" => time()+getenv('JWT_EXPIRATION'),
            "upr" => [
                "username" => $user->username,
                "mail" => $user->mail,
            ],
            "data" => [
                "uid" => $user->id,
                "lvl" => $user->access,
            ]
        ];

        $token = JWT::encode($payload,getenv('JWT_SECRET'), 'HS512');
        return $token;
    }

    public function validateToken($token)
    {
        try {
            $h = $rq->getHeader('Authorization')[0] ;
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
