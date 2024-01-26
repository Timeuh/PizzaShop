<?php

namespace pizzashop\cat\app\actions;

use Exception;
use pizzashop\cat\domain\service\IBrowserCatalogue;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class GetProduitByCategorieAction extends AbstractAction {

    private IBrowserCatalogue $serviceCatalogue;

    public function __construct(IBrowserCatalogue $s) {
        $this->serviceCatalogue = $s;
    }

    public function __invoke(Request $request, Response $response, $args): Response {

        $id = $args['id_categorie'];
        $queryParams = $request->getQueryParams();
        $key = isset($queryParams['s']) ? $queryParams['s'] : null;
        try {
            $produits = $this->serviceCatalogue->getProduitsParCategorie($id,$key);
        } catch (Exception $e) {
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

        $data = [
            'type' => 'resource',
            'categorie' => $produits['cat']->libelle,
        ];
        foreach ($produits['produits'] as $p){
            $data['Produits'][] = [
                'Produit'=>[
                    'id'=>$p->id,
                    'numero'=>$p->numero_produit,
                    'libelle'=>$p->libelle_produit,
                    'description'=>$p->description_produit
                ],
                'links' => [
                    'self' => [
                        'href' => '/produit/' . $p->id,
                    ],
                ],
            ];
        }

        $response->getBody()->write(json_encode($data));
        return
            $response->withHeader('Content-Type', 'application/json')
                ->withStatus(200);


    }

}