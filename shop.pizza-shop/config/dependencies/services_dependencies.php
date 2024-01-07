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
        return new ServiceCatalogue(new Client(['base_uri' => 'http://api.catalogue.pizza-shop', 'timeout' => 5.0]));
    },

    'commande.service' => function (ContainerInterface $c) {
        return new ServiceCommande($c->get('logger'), $c->get('catalogue.service'));
    },

    'auth.service' => function (ContainerInterface $c) {
        return new ServiceAuth(new Client(['base_uri' => 'http://api.auth.pizza-shop', 'timeout' => 5.0]));
    },];