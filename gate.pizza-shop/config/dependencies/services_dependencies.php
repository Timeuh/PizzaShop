<?php


use pizzashop\gate\client\ClientApi;
use Psr\Container\ContainerInterface;

return [

    'catalogue.client' => function (ContainerInterface $c) {
        return new ClientApi(['base_uri' => 'http://api.catalogue.pizza-shop', 'timeout' => 5.0]);
    },
];
