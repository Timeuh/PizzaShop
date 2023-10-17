<?php

namespace pizzashop\auth\api\app\auth\providers;


use DateTime;
use Exception;
use pizzashop\auth\api\app\domain\entities\Users;
use pizzashop\auth\api\domain\dto\CredentialsDTO;
use pizzashop\auth\api\domain\dto\TokenDTO;
use pizzashop\auth\api\domain\exception\AuthServiceInvalideDonneeException;
use pizzashop\auth\api\domain\exception\CredentialsException;
use pizzashop\auth\api\domain\exception\RefreshTokenInvalideException;
use pizzashop\auth\api\domain\service\AuthService;
class AuthProvider
{
    private Users $currentAuthenticatedUser;

    public function checkCredentials(string $email, string $pass): void
    {
        try {
            $user = Users::where('email', $email)->firstOfFail();

            if (!password_verify($pass, $user->password)) {
                throw new CredentialsException();
            }
        }catch (Exception $e){
            throw new CredentialsException();
        }
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

    public function getAuthenticatedUser(): array
    {
        return [
            'username' => $this->currentAuthenticatedUser->username,
            'email' => $this->currentAuthenticatedUser->email,
            'refresh_token' => $this->currentAuthenticatedUser->refresh_token,
        ];
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
            $now = new DateTime();

            if ($tokenExpDate < $now) {
                throw new RefreshTokenInvalideException();
            }
        } catch (Exception $e) {
            throw new RefreshTokenInvalideException();
        }
    }
}