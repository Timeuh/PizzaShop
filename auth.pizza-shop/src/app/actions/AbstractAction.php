<?php

namespace pizzashop\auth\api\app\actions;

use pizzashop\auth\api\domain\service\AuthService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractAction {
    protected AuthService $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public abstract function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface;
}
