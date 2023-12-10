<?php


use pizzashop\gate\app\actions\catalogue\GetProduitByCategorieAction;
use Psr\Container\ContainerInterface;

return[

    GetProduitByCategorieAction::class => function (ContainerInterface $c){
        return new GetProduitByCategorieAction($c->get('catalogue.client'));
    },

];