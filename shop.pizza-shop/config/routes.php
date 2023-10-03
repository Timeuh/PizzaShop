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
};