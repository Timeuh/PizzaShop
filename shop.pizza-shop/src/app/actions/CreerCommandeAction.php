<?php

namespace pizzashop\shop\app\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CreerCommandeAction {
    public function __invoke(Request $request, Response $response, $args) : Response {
        $body = $request->getParsedBody();
        $response->getBody()->write(json_encode($body));


        return $response->withHeader('Content-Type', 'application/json');
    }
}