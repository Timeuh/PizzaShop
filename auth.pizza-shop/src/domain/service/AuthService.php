<?php

namespace pizzashop\auth\api\domain\service;

use pizzashop\auth\api\domain\dto\CredentialsDTO;
use pizzashop\auth\api\domain\dto\TokenDTO;
use pizzashop\auth\api\domain\dto\UserDTO;

class AuthService implements AuthServiceInterface {

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
        // TODO: Implement refresh() method.
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