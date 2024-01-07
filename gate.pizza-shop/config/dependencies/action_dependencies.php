<?php


use pizzashop\gate\app\actions\authentification\SignInAction;
use pizzashop\gate\app\actions\authentification\UserRefreshAction;
use pizzashop\gate\app\actions\authentification\ValiderTokenJWTAction;
use pizzashop\gate\app\actions\catalogue\GetProduitByCategorieAction;
use pizzashop\gate\app\actions\catalogue\GetProduitByIdAction;
use pizzashop\gate\app\actions\catalogue\GetProduitsAction;
use pizzashop\gate\app\actions\commande\AccederCommandeAction;
use pizzashop\gate\app\actions\commande\CreerCommandeAction;
use pizzashop\gate\app\actions\commande\ValiderCommandeAction;
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

    AccederCommandeAction::class => function (ContainerInterface $c){
        return new AccederCommandeAction($c->get('commande.client'));
    },

    CreerCommandeAction::class => function (ContainerInterface $c){
        return new CreerCommandeAction($c->get('commande.client'));
    },

    ValiderCommandeAction::class => function (ContainerInterface $c){
        return new ValiderCommandeAction($c->get('commande.client'));
    },

    SignInAction::class => function (ContainerInterface $c){
        return new SignInAction($c->get('auth.client'));
    },

    ValiderTokenJWTAction::class => function (ContainerInterface $c){
        return new ValiderTokenJWTAction($c->get('auth.client'));
    },

    UserRefreshAction::class => function (ContainerInterface $c){
        return new UserRefreshAction($c->get('auth.client'));
    },



];