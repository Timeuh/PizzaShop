<?php

namespace pizzashop\auth\api\app\auth\providers;


use Exception;
use pizzashop\auth\api\domain\dto\CredentialsDTO;
use pizzashop\auth\api\domain\dto\TokenDTO;
use pizzashop\auth\api\domain\exception\AuthServiceInvalideDonneeException;
use pizzashop\auth\api\domain\service\AuthService;

class AuthProvider {

    private AuthService $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function register(string $user, string $pass): void {
        $c = new CredentialsDTO($user, $pass);
        try {
            $userDTO = $this->authService->signup($c);
        } catch (Exception $e) {
            throw new AuthServiceInvalideDonneeException($e);
        }
    }

    public function activate(string $token): void {
        $t = new TokenDTO($token);
        try {
            $this->authService->activate_signup($t);
        } catch (Exception $e) {
            throw new AuthServiceInvalideDonneeException();
        }
    }

}