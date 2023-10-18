<?php

namespace pizzashop\auth\api\app\auth\providers;


use DateTime;
use DateTimeZone;
use Exception;
use pizzashop\auth\api\app\auth\managers\JwtManager;
use pizzashop\auth\api\domain\dto\CredentialsDTO;
use pizzashop\auth\api\domain\dto\TokenDTO;
use pizzashop\auth\api\domain\entities\Users;
use pizzashop\auth\api\domain\exception\AuthServiceInvalideDonneeException;
use pizzashop\auth\api\domain\exception\CredentialsException;
use pizzashop\auth\api\domain\exception\RefreshTokenInvalideException;
use pizzashop\auth\api\domain\exception\RefreshUtilisateurException;

class AuthProvider
{
    public function checkCredentials(string $email, string $pass): void
    {
        $user = Users::where('email', $email)->first();
        if ($user == null) {
            throw new CredentialsException();
        }

        if (!password_verify($pass, $user->password)) {
            throw new CredentialsException();
        }
    }

    public function register(string $user, string $pass): void
    {
        try {
            $credentialsDTO = new CredentialsDTO();
            $credentialsDTO->email = $user;
            $credentialsDTO->password = $pass;

            $this->authService->signup($credentialsDTO);
        } catch (Exception $e) {
            throw new AuthServiceInvalideDonneeException();
        }
    }

    public function activate(string $token): void
    {
        $t = new TokenDTO($token);
        try {
            $this->authService->activate_signup($t);
        } catch (Exception $e) {
            throw new AuthServiceInvalideDonneeException();
        }
    }

    /**
     * Vérifie si un token est présent dans la bd pour un utilisateur
     *
     * @param string $token le token à vérifier
     * @return void
     * @throws RefreshTokenInvalideException si le token est introuvable en bd ou dépassé
     */
    public function checkToken(string $token)
    {
        try {
            $user = Users::where('refresh_token', $token)->firstOrFail();
            $tokenExpDate = new DateTime($user->refresh_token_expiration_date);
            $now = new DateTime('now', new DateTimeZone('Europe/Paris'));

            if ($tokenExpDate->getTimestamp() < $now->getTimestamp()) {
                throw new RefreshTokenInvalideException();
            }
        } catch (Exception $e) {
            throw new RefreshTokenInvalideException();
        }
    }

    public function regenToken(TokenDTO $tokenDTO, JwtManager $jwtManager): TokenDTO {
        try {
            $user = Users::where('refresh_token', $tokenDTO->refreshToken)->firstOrFail();

            $newRefreshToken = bin2hex(random_bytes(32));
            $now = new DateTime('now', new DateTimeZone('Europe/Paris'));
            $refreshTokenExpDate = $now->modify('+1 hour');

            $user->refresh_token = $newRefreshToken;
            $user->refresh_token_expiration_date = $refreshTokenExpDate->format('Y-m-d H:i:s');
            $user->save();

            $token = $jwtManager->create(['username' => $user->username, 'email' => $user->email]);
            return new TokenDTO($newRefreshToken, $token);
        } catch (Exception $e) {
            throw new RefreshUtilisateurException();
        }
    }

}