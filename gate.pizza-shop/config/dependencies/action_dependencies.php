<?php


use pizzashop\gate\app\actions\authentification\MethodAuthentificationAction;
use pizzashop\gate\app\actions\authentification\SignInAction;
use pizzashop\gate\app\actions\authentification\UserRefreshAction;
use pizzashop\gate\app\actions\authentification\ValiderTokenJWTAction;
use pizzashop\gate\app\actions\catalogue\GetCatalogue;
use pizzashop\gate\app\actions\catalogue\GetProduitByCategorieAction;
use pizzashop\gate\app\actions\catalogue\GetProduitByIdAction;
use pizzashop\gate\app\actions\catalogue\GetProduitsAction;
use pizzashop\gate\app\actions\commande\AccederCommandeAction;
use pizzashop\gate\app\actions\commande\CreerCommandeAction;
use pizzashop\gate\app\actions\commande\ValiderCommandeAction;
use Psr\Container\ContainerInterface;

return[

    GetCatalogue::class => function (ContainerInterface $c){
        return new GetCatalogue($c->get('catalogue.client'));
    },

    MethodAuthentificationAction::class => function (ContainerInterface $c){
        return new MethodAuthentificationAction($c->get('auth.client'));
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



];