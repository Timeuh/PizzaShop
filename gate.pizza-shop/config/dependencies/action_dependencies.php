<?php


use pizzashop\gate\app\actions\catalogue\GetProduitByCategorieAction;
use pizzashop\gate\app\actions\catalogue\GetProduitByIdAction;
use pizzashop\gate\app\actions\catalogue\GetProduitsAction;
use Psr\Container\ContainerInterface;

return[

    GetProduitByCategorieAction::class => function (ContainerInterface $c){
        return new GetProduitByCategorieAction($c->get('catalogue.client'));
    },

    GetProduitByIdAction::class => function (ContainerInterface $c){
        return new GetProduitByIdAction($c->get('catalogue.client'));
    },

    GetProduitsAction::class => function (ContainerInterface $c){
        return new GetProduitsAction($c->get('catalogue.client'));
    },

];