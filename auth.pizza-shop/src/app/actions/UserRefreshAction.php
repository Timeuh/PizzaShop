<?php

namespace pizzashop\auth\api\app\actions;

use pizzashop\auth\api\domain\dto\TokenDTO;
use pizzashop\auth\api\domain\exception\RefreshTokenInvalideException;
use pizzashop\auth\api\domain\exception\RefreshUtilisateurException;
use pizzashop\auth\api\domain\service\AuthService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserRefreshAction extends AbstractAction {
    private AuthService $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $header = $request->getHeader('Authorization')[0];
        $refreshToken = str_replace('Bearer ', '', $header);

        try {
            $reAuth = $this->authService->refresh(new TokenDTO($refreshToken));
            $responseMessage = array(
                "code" => 200,
                "jwt" => $reAuth->jwt,
                "refreshToken" => $reAuth->refreshToken
            );

            $response->getBody()->write(json_encode($responseMessage));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (RefreshUtilisateurException | RefreshTokenInvalideException $e) {
            $responseMessage = array(
                "message" => "401 Refresh token error",
                "exception" => array(
                    "type" => $e::class,
                    "code" => $e->getCode(),
                    "message" => $e->getMessage(),
                    "file" => $e->getFile(),
                    "line" => $e->getLine()
                )
            );

            $response->getBody()->write(json_encode($responseMessage));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }
    }
}