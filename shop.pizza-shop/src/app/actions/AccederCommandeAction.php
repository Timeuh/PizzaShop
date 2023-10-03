<?php

namespace pizzashop\shop\app\actions;

use pizzashop\shop\domain\exception\CommandeNonTrouveeException;
use pizzashop\shop\domain\service\commande\ICommander;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class AccederCommandeAction extends AbstractAction {

    private ICommander $serviceCommande;

    public function __construct(ICommander $s) {
        $this->serviceCommande = $s;
    }

    public function __invoke(Request $request, Response $response, $args): Response {

        try {
            $id_commande = $args['id_commande'];
            $commande = $this->serviceCommande->accederCommande($id_commande);
        } catch (CommandeNonTrouveeException $e) {
            $responseMessage = array(
                "message" => "404 Not Found",
                "exception" => array(
                    "type" => $e::class,
                    "code" => $e->getCode(),
                    "message" => $e->getMessage(),
                    "file" => $e->getFile(),
                    "line" => $e->getLine()
                ));

            $response->getBody()->write(json_encode($responseMessage));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $items = $commande->items;
        $data = [
            'type' => 'resource',
            'commande' => $commande,
            'links' => [
                'self' => [
                    'href' => '/commandes/' . $commande->id,
                ],
                'valider' => [
                    'href' => '/commandes/' . $commande->id,
                ],
            ],
        ];


        $response->getBody()->write(json_encode($data));
        return
            $response->withHeader('Content-Type', 'application/json')
                ->withStatus(200);


    }

}