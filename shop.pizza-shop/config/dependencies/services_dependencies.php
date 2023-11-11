<?php

use GuzzleHttp\Client;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use pizzashop\shop\domain\service\authentification\ServiceAuth;
use pizzashop\shop\domain\service\catalogue\ServiceCatalogue;
use pizzashop\shop\domain\service\commande\ServiceCommande;
use Psr\Container\ContainerInterface;

return [

    'logger' => function (ContainerInterface $c) {
        $log = new Logger($c->get('log.name'));
        $log->pushHandler(new StreamHandler($c->get('log.file')));
        return $log;
    },

    'catalogue.service' => function (ContainerInterface $c) {
        return new ServiceCatalogue();//pas de logger pour l'instant
    },

    'commande.service' => function (ContainerInterface $c) {
        return new ServiceCommande($c->get('logger'), $c->get('catalogue.service'));
    },

    'auth.service' => function (ContainerInterface $c) {
        return new ServiceAuth(new Client(['base_uri' => 'http://api.pizza-auth', 'timeout' => 5.0]));
    },];