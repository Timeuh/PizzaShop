<?php


use pizzashop\cat\domain\service\ServiceCatalogue;
use Psr\Container\ContainerInterface;

return [

    'catalogue.service' => function (ContainerInterface $c) {
        return new ServiceCatalogue();//pas de logger pour l'instant
    },

];