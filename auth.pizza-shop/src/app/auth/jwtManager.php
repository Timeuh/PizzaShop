<?php

namespace auth\app\auth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException ;
use Firebase\JWT\BeforeValidException;


class JwtManager
{
    private $secret=getenv('JWT_SECRET');

    public function createToken($user)
    {

        $payload = [
            "iss" => "pizza-shop.auth.db",
            "aud" => "api.pizza-shop",
            "iat" => time(), 'exp'=>time()+3600,
            "uid" => $user->id,
            "lvl" => $user->access
        ];

        $token = JWT::encode($payload, $this->secret, 'HS512');
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
            $token = JWT::decode($tokenString, new Key(secret, 'HS512'));
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
