<?php

use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager as DB;
use Monolog\Logger;
use pizzashop\shop\domain\service\commande\ServiceCommande;
use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;

session_start();
// crée l'app et le moteur de templates

$builder = new ContainerBuilder();
$c = $builder->addDefinitions([

    'log.name' => 'commande.log',
    'log.file' => __DIR__.'/../src/console/commande.log',
    'log.level' => Logger::WARNING,

    'logger' => function (ContainerInterface $c) {
        $log = new Logger($c->get('log.name'));
        $log->pushHandler(new \Monolog\Handler\StreamHandler($c->get('log.file')));
        return $log;
    },

    'commande.service' => function (ContainerInterface $c) {
        return new ServiceCommande($c->get('logger'));
    },
])->build();


$app = AppFactory::createFromContainer($c);
$container = $app->getContainer();

// ajoute le routing et l'erreur middleware
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);
$app->setBasePath('');

// initialise Eloquent avec les fichiers de config
$db = new DB();
$db->addConnection(parse_ini_file('catalog.db.ini'), 'catalog');
$db->addConnection(parse_ini_file('commande.db.ini'), 'commande');
$db->setAsGlobal();
$db->bootEloquent();

return $app;
