<?php

namespace pizzashop\auth\api\app\actions;

use pizzashop\auth\api\domain\dto\TokenDTO;
use pizzashop\auth\api\domain\exception\AuthServiceExpiredTokenException;
use pizzashop\auth\api\domain\exception\AuthServiceInvalideTokenException;
use pizzashop\auth\api\domain\service\AuthServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ValiderTokenJWTAction extends AbstractAction {

    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $s) {
        $this->authService = $s;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {

        try {
            $header = $request->getHeader('Authorization')[0];
            $token = str_replace('Bearer ', '', $header);
            $pUser = $this->authService->validate(new TokenDTO('', $token));
        } catch (AuthServiceExpiredTokenException $e) {
            return $response->withStatus(401)->withJson(['error' => 'Token expiré']);
        } catch (AuthServiceInvalideTokenException $e) {
            return $response->withStatus(401)->withJson(['error' => 'Token invalide']);
        }

        return $response->withStatus(200)->withJson($pUser);
    }
}