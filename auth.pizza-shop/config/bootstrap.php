<?php

use Illuminate\Database\Capsule\Manager as DB;
use pizzashop\auth\api\domain\exception\JwtSecretEcritureException;
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

if  (!getenv('JWT_SECRET')) {
    try {
        $secret = bin2hex(random_bytes(32));
    } catch (\Exception $e) {
        throw new JwtSecretEcritureException();
    }
    file_put_contents('auth.env', 'JWT_SECRET=' . $secret . PHP_EOL, FILE_APPEND);
}

return $app;
