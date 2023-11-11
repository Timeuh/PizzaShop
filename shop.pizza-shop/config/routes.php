<?php
declare(strict_types=1);

use pizzashop\shop\app\actions\AccederCommandeAction;
use pizzashop\shop\app\actions\CreerCommandeAction;
use pizzashop\shop\app\actions\ValiderCommandeAction;

return function( \Slim\App $app):void {

    $app->post('/commandes[/]', CreerCommandeAction::class)
        ->setName('creer_commande');

    $app->get('/commandes/{id_commande}[/]', AccederCommandeAction::class)
        ->setName('commande');

    $app->patch('/commandes/{id_commande}[/]', ValiderCommandeAction::class)
        ->setName('valider_commande');

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