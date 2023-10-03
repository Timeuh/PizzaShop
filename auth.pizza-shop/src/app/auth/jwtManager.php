<?php

namespace auth\app\auth;

class JwtManager
{
    private $authProvider;

    public function __construct(AuthProvider $authProvider)
    {
        $this->authProvider = $authProvider;
    }

    public function authenticate($userProfile)
    {
        $token = $this->authProvider->createToken($userProfile);
        return $token;
    }

    public function validateToken($token)
    {
        return $this->authProvider->validateToken($token);
    }
}
