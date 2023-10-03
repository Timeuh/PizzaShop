<?php

use pizzashop\shop\app\actions\AccederCommandeAction;
use Psr\Container\ContainerInterface;
use pizzashop\shop\app\actions\ValiderCommandeAction;
use pizzashop\shop\app\actions\CreerCommandeAction;

return[

    AccederCommandeAction::class => function (ContainerInterface $c){
        return new AccederCommandeAction($c->get('commande.service'));
    },

    ValiderCommandeAction::class => function (ContainerInterface $c){
        return new ValiderCommandeAction($c->get('commande.service'));
    },

    CreerCommandeAction::class => function (ContainerInterface $c){
        return new CreerCommandeAction($c->get('commande.service'));
    }

];