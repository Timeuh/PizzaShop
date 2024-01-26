<?php

namespace pizzashop\gate\app\actions\catalogue;

use pizzashop\gate\app\actions\AbstractAction;
use pizzashop\gate\client\ClientApi;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class GetCatalogue extends AbstractAction {

    private ClientApi $client;

    public function __construct(ClientApi $c) {
        $this->client = $c;
    }

    public function __invoke(Request $request, Response $response, $args): Response {
        $data = $this->client->get($request->getUri()->getPath(),$request->getQueryParams());
        $response->getBody()->write($data);
        return $response->withHeader('Content-Type', 'application/json');
    }

}