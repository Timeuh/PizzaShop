<?php

namespace pizzashop\auth\api\app\actions;

use pizzashop\auth\api\app\actions\AbstractAction;
use pizzashop\auth\api\domain\exception\AuthServiceExpiredTokenException;
use pizzashop\auth\api\domain\exception\AuthServiceInvalideTokenException;
use pizzashop\auth\api\domain\service\AuthService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ValiderTokenJWTAction extends AbstractAction {

    public function __construct(AuthService $authService) {
        parent::__construct($authService);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {

        try {
            $header = $request->getHeader('Authorization')[0];
            $token = str_replace('Bearer ', '', $header);
            $pUser = $this->authService->validate($token);
        } catch (AuthServiceExpiredTokenException $e) {
            return $response->withStatus(401)->withJson(['error' => 'Token expiré']);
        } catch (AuthServiceInvalideTokenException $e) {
            return $response->withStatus(401)->withJson(['error' => 'Token invalide']);
        }

        return $response->withStatus(200)->withJson($pUser);
    }
}