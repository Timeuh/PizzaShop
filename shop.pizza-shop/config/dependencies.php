<?php

use DI\ContainerBuilder;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Container\ContainerInterface;
use pizzashop\shop\domain\service\commande\ServiceCommande;
use pizzashop\shop\app\actions\AccederCommandeAction;

$builder = new ContainerBuilder();
$c = $builder->addDefinitions([

    'log.name' => 'commande.log',
    'log.file' => __DIR__.'/../src/console/commande.log',
    'log.level' => Logger::WARNING,

    'logger' => function (ContainerInterface $c) {
        $log = new Logger($c->get('log.name'));
        $log->pushHandler(new StreamHandler($c->get('log.file')));
        return $log;
    },

    'commande.service' => function (ContainerInterface $c) {
        return new ServiceCommande($c->get('logger'));
    },

    AccederCommandeAction::class => function (ContainerInterface $c){
        return new AccederCommandeAction($c->get('commande.service'));
    }
])->build();

return $c;
