<?php

namespace pizzashop\cat\app\actions;

use Exception;
use pizzashop\cat\domain\exception\ProduitNonTrouveeException;
use pizzashop\cat\domain\service\IBrowserCatalogue;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class GetProduitByIdAction extends AbstractAction {

    private IBrowserCatalogue $serviceCatalogue;

    public function __construct(IBrowserCatalogue $s) {
        $this->serviceCatalogue = $s;
    }

    public function __invoke(Request $request, Response $response, $args): Response {

        $id = $args['id_produit'];
        try {
            $produit1 = $this->serviceCatalogue->getProduit($id,1);
            $produit2 = $this->serviceCatalogue->getProduit($id,2);
        } catch (ProduitNonTrouveeException $e) {
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
            'produit'=>[
                'id'=>$produit1->id,
                'numero'=>$produit1->numero_produit,
                'libelle'=>$produit1->libelle_produit,
                'description'=>$produit1->description_produit,
                'categorie'=>$produit1->libelle_categorie,
                'taille'=>[
                'normale'=>['tarif'=>$produit1->tarif],
                'grande'=>['tarif'=>$produit2->tarif]
                ]
            ]
        ];

        $response->getBody()->write(json_encode($data));
        return
            $response->withHeader('Content-Type', 'application/json')
                ->withStatus(200);


    }

}