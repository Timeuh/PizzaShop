<?php


use pizzashop\cat\app\actions\GetProduitsAction;
use Psr\Container\ContainerInterface;

return[

    GetProduitsAction::class => function (ContainerInterface $c){
        return new GetProduitsAction($c->get('catalogue.service'));
    },

];