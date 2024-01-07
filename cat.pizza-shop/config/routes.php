<?php
declare(strict_types=1);

use pizzashop\cat\app\actions\GetProduitByCategorieAction;
use pizzashop\cat\app\actions\GetProduitByIdAction;
use pizzashop\cat\app\actions\GetProduitsAction;

return function( \Slim\App $app):void {

    $app->get('/produits[/]', GetProduitsAction::class)
        ->setName('list_produits');

    $app->get('/produits/{id_produit}[/]', GetProduitByIdAction::class)
        ->setName('produit');

    $app->get('/categories/{id_categorie}/produits[/]', GetProduitByCategorieAction::class)
        ->setName('cat_produits');


    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response; // Renvoie une réponse HTTP vide
    });

    $app->add(function ($request, $handler) {
        $response = $handler->handle($request);
        if (!$request->hasHeader('Origin')) {
            $origin = '*';
        } else {
            $origin = $request->getHeader('Origin');
        }
        return $response
            ->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
            ->withHeader('Access-Control-Allow-Credentials', 'true');
    });
};