<?php

use Illuminate\Database\Capsule\Manager as DB;
use Slim\Factory\AppFactory;

session_start();
$app = AppFactory::create();

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);
$app->setBasePath('');

// initialise Eloquent avec les fichiers de config
$db = new DB();
$db->addConnection(parse_ini_file('auth.db.ini'), 'auth');
$db->setAsGlobal();
$db->bootEloquent();

return $app;
