<?php

namespace pizzashop\auth\api\domain\dto;

class TokenDTO extends DTO {
    public string $refreshToken;
    public string $activationToken;
    public string $jwt;

    /**
     * @param string $refreshToken
     * @param string $jwt
     * @param string $activationToken
     */
    public function __construct(string $refreshToken = '', string $jwt = '', string $activationToken = '') {
        $this->refreshToken = $refreshToken;
        $this->jwt = $jwt;
        $this->activationToken = $activationToken;
    }
}