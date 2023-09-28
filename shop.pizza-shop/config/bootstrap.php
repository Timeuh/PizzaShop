<?php

use Illuminate\Database\Capsule\Manager as DB;
use Slim\Factory\AppFactory;
use DI\ContainerBuilder;

session_start();
// crée l'app et le moteur de templates

$builder = new ContainerBuilder();
$c=$builder->build();



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
