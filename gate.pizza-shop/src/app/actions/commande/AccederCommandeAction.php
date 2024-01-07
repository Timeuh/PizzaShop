<?php

namespace pizzashop\gate\app\actions\commande;

use pizzashop\gate\app\actions\AbstractAction;
use pizzashop\gate\client\ClientApi;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class AccederCommandeAction extends AbstractAction {

    private ClientApi $client;

    public function __construct(ClientApi $c) {
        $this->client = $c;
    }

    public function __invoke(Request $request, Response $response, $args): Response {
        $data = $this->client->get('/commandes/'.$args['id_commande'],null,['Authorization'=>$request->getHeader('Authorization')]);
        $response->getBody()->write($data);
        return $response->withHeader('Content-Type', 'application/json');
    }

}