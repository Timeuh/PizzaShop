<?php


use pizzashop\gate\client\ClientApi;
use Psr\Container\ContainerInterface;

return [

    'catalogue.client' => function (ContainerInterface $c) {
        return new ClientApi(['base_uri' => 'http://api.catalogue.pizza-shop', 'timeout' => 5.0]);
    },

    'commande.client' => function (ContainerInterface $c) {
        return new ClientApi(['base_uri' => 'http://api.commande.pizza-shop', 'timeout' => 5.0]);
    },

    'auth.client' => function (ContainerInterface $c) {
        return new ClientApi(['base_uri' => 'http://api.auth.pizza-shop', 'timeout' => 5.0]);
    },
];
