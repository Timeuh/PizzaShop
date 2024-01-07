<?php
declare(strict_types=1);


use pizzashop\gate\app\actions\authentification\UserRefreshAction;
use pizzashop\gate\app\actions\authentification\ValiderTokenJWTAction;
use pizzashop\gate\app\actions\catalogue\GetProduitsAction;
use pizzashop\gate\app\actions\catalogue\GetProduitByCategorieAction;
use pizzashop\gate\app\actions\catalogue\GetProduitByIdAction;
use pizzashop\gate\app\actions\commande\AccederCommandeAction;
use pizzashop\gate\app\actions\authentification\SignInAction;
use pizzashop\gate\app\actions\commande\CreerCommandeAction;
use pizzashop\gate\app\actions\commande\ValiderCommandeAction;

return function(\Slim\App $app):void {

    //COMMANDE
    $app->post('/commandes[/]', CreerCommandeAction::class)
        ->setName('creer_commande');

    $app->get('/commandes/{id_commande}[/]', AccederCommandeAction::class)
        ->setName('commande');

    $app->patch('/commandes/{id_commande}[/]', ValiderCommandeAction::class)
        ->setName('valider_commande');


    //CATALOGUE
    $app->get('/produits[/]', GetProduitsAction::class)
        ->setName('list_produits');

    $app->get('/produits/{id_produit}[/]', GetProduitByIdAction::class)
        ->setName('produit');

    $app->get('/categories/{id_categorie}/produits[/]', GetProduitByCategorieAction::class)
        ->setName('cat_produits');


    //AUTH
    $app->post("/api/users/signin",SignInAction::class)
        ->setName("signIn");

    $app->post('/api/users/refresh', UserRefreshAction::class)
        ->setName('refreshUser');

    $app->get('/api/users/validate', ValiderTokenJWTAction::class)
        ->setName('validateTokenJWT');


    //CORS
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