<?php

namespace pizzashop\auth\api\app\auth\providers;


use Exception;
use pizzashop\auth\api\app\domain\entities\Users;
use pizzashop\auth\api\domain\dto\CredentialsDTO;
use pizzashop\auth\api\domain\dto\TokenDTO;
use pizzashop\auth\api\domain\exception\AuthServiceInvalideDonneeException;
use pizzashop\auth\api\domain\exception\RefreshTokenInvalideException;
use pizzashop\auth\api\domain\service\AuthService;

class AuthProvider
{

    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function signIn(string $email, string $pass): void
    {
        $c = new CredentialsDTO($email, $pass);
        $this->authService->signin($c);
    }

    public function register(string $user, string $pass): void {
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
            Users::where('refresh_token', $token)->where('refresh_token_expiration_date', '>', time())->firstOrFail();
        } catch (Exception $e) {
            throw new RefreshTokenInvalideException();
        }
    }
}