<?php

use pizzashop\shop\app\actions\AccederCommandeAction;
use Psr\Container\ContainerInterface;

return[
    AccederCommandeAction::class => function (ContainerInterface $c){
        return new AccederCommandeAction($c->get('commande.service'));
    }
];