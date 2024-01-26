<?php

namespace pizzashop\cat\app\actions;

use Exception;
use pizzashop\cat\domain\service\IBrowserCatalogue;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class GetProduitsAction extends AbstractAction {

    private IBrowserCatalogue $serviceCatalogue;

    public function __construct(IBrowserCatalogue $s) {
        $this->serviceCatalogue = $s;
    }

    public function __invoke(Request $request, Response $response, $args): Response {

        $queryParams = $request->getQueryParams();
        $key = isset($queryParams['s']) ? $queryParams['s'] : null;
        try {
            $produits = $this->serviceCatalogue->getAllProduct($key);
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

        if ($produits == null) {
            $responseMessage = array(
                "message" => "404 Not Found",
                "exception" => array(
                    "type" => "Exception",
                    "code" => 0,
                    "message" => "Aucun produit trouvé",
                ));

            $response->getBody()->write(json_encode($responseMessage));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $data = [
            'type' => 'resource',
            ];
        foreach ($produits as $p){
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