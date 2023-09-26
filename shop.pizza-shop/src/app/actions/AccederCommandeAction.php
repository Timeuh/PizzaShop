<?php

namespace pizzashop\shop\app\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AccederCommandeAction {

    public function __invoke(Request $request, Response $response, $args): Response {
        $id_commande = $args['id_commande'];
$commande = \pizzashop\shop\domain\models\Commande::find($id_commande);
if (!$commande) {
    $response->getBody()->write(json_encode(['error' => 'Commande introuvable']));
    return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
}
$produits = $commande->produits;
$data = [
    'type' => 'resource',
    'commande' => [
        'id' => $commande->id,
        'date' => $commande->date,
        'statut' => $commande->statut,
        'produits' => [],
    ],
];
foreach ($produits as $produit) {
    $data['commande']['produits'][] = [
        'id' => $produit->id,
        'libelle' => $produit->libelle,
        'description' => $produit->description,
        'tarif' => $produit->tarif,
        'quantite' => $produit->quantite,
    ];
}

$response->getBody()->write(json_encode($data));
return
    $response->withHeader('Content-Type','application/json')
        ->withStatus(200);


    }

}