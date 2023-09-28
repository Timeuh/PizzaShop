<?php

namespace pizzashop\shop\app\actions;

use pizzashop\shop\domain\exception\commandeNonTrouveeException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use pizzashop\shop\domain\service\commande\ServiceCommande;
use Monolog\Logger as Logger;


class AccederCommandeAction extends AbstractAction {


    public function __invoke(Request $request, Response $response, $args): Response {

        $serviceCommande = $this->container->get('commande.service');

        try {
            $id_commande = $args['id_commande'];
            $commande = $serviceCommande->accederCommande($id_commande);
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
            'commande' => [
                'id' => $commande->id,
                'date_commande' => $commande->date_commande->format('Y-m-d H:i:s'),
                'type_livraison' => $commande->type_livraison,
                'etat' => $commande->etat,
                'montant_total' => $commande->montant_total,
                'mail_client' => $commande->mail_client,
                'delai' => $commande->delai,
                'items' => [],
                'links' => [
                    'self' => [
                        'href' => '/commandes/' .$commande->id,
                    ],
                    'valider' => [
                        'href' => '/commandes/' .$commande->id,
                    ],
                ],
            ],
        ];
        foreach ($items as $item) {
            $data['commande']['items'][] = [
                'id' => $item['id'],
                'numero' => $item['numero'],
                'libelle' => $item['libelle'],
                'libelle_taille' => $item['libelle_taille'],
                'taille' => $item['taille'],
                'quantite' => $item['quantite'],
                'tarif' => $item['tarif'],
            ];
        }





        $response->getBody()->write(json_encode($data));
        return
            $response->withHeader('Content-Type', 'application/json')
                ->withStatus(200);


    }

}