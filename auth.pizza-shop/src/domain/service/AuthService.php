<?php

namespace pizzashop\auth\api\domain\service;

use DateTime;
use Exception;
use pizzashop\auth\api\app\auth\managers\JwtManager;
use pizzashop\auth\api\app\auth\providers\AuthProvider;
use pizzashop\auth\api\app\domain\entities\Users;
use pizzashop\auth\api\domain\dto\CredentialsDTO;
use pizzashop\auth\api\domain\dto\TokenDTO;
use pizzashop\auth\api\domain\dto\UserDTO;
use pizzashop\auth\api\domain\exception\RefreshUtilisateurException;

class AuthService implements AuthServiceInterface {
    private JwtManager $jwtManager;
    private AuthProvider $authProvider;

    public function __construct(JwtManager $jwtManager, AuthProvider $authProvider) {
        $this->jwtManager = $jwtManager;
        $this->authProvider = $authProvider;
    }

    /**
     * @inheritDoc
     */
    public function signup(CredentialsDTO $credentialsDTO): UserDTO {
        // TODO: Implement signup() method.
    }

    /**
     * @inheritDoc
     */
    public function signin(CredentialsDTO $credentialsDTO): TokenDTO {
        // TODO: Implement signin() method.
    }

    /**
     * @inheritDoc
     */
    public function validate(TokenDTO $tokenDTO): UserDTO {
        // TODO: Implement validate() method.
    }

    /**
     * @inheritDoc
     */
    public function refresh(TokenDTO $tokenDTO): TokenDTO {
        $this->authProvider->checkToken($tokenDTO->refreshToken);
        try {
            $user = Users::where('refresh_token', $tokenDTO->refreshToken)->firstOrFail();

            $newRefreshToken = bin2hex(random_bytes(32));
            $now = new DateTime();
            $refreshTokenExpDate = $now->modify('+1 hour');

            $user->refresh_token = $newRefreshToken;
            $user->refresh_token_expiration_date = $refreshTokenExpDate->format('Y-m-d H:i:s');
            $user->save();

            $token = $this->jwtManager->create(['username' => $user->username, 'email' => $user->email]);
            return new TokenDTO($newRefreshToken, $token);
        } catch (Exception $e) {
            throw new RefreshUtilisateurException();
        }
    }

    /**
     * @inheritDoc
     */
    public function activate_signup(TokenDTO $tokenDTO): void {
        // TODO: Implement activate_signup() method.
    }

    /**
     * @inheritDoc
     */
    public function reset_password(TokenDTO $tokenDTO, CredentialsDTO $credentialsDTO): void {
        // TODO: Implement reset_password() method.
    }
}