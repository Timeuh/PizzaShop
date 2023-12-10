<?php


use pizzashop\cat\app\actions\GetProduitByCategorieAction;
use pizzashop\cat\app\actions\GetProduitByIdAction;
use pizzashop\cat\app\actions\GetProduitsAction;
use Psr\Container\ContainerInterface;

return[

    GetProduitsAction::class => function (ContainerInterface $c){
        return new GetProduitsAction($c->get('catalogue.service'));
    },

    GetProduitByIdAction::class => function (ContainerInterface $c){
        return new GetProduitByIdAction($c->get('catalogue.service'));
    },

    GetProduitByCategorieAction::class => function (ContainerInterface $c){
        return new GetProduitByCategorieAction($c->get('catalogue.service'));
    },

];