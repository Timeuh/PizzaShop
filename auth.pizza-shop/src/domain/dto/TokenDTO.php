<?php

namespace pizzashop\auth\api\domain\dto;

use Firebase\JWT\JWT;

class TokenDTO extends DTO {
    public string $refreshToken;
    public JWT $jwt;

    /**
     * @param string $refreshToken
     * @param JWT $jwt
     */
    public function __construct(string $refreshToken = '', JWT $jwt = null) {
        $this->refreshToken = $refreshToken;
        $this->jwt = $jwt;
    }
}