<?php
declare(strict_types=1);

use pizzashop\auth\api\app\actions\SignInAction;
use pizzashop\auth\api\app\actions\ValiderTokenJWTAction;

return function (\Slim\App $app): void {

    $app->get('/api/users/validate', ValiderTokenJWTAction::class)
        ->setName('validateTokenJWT');

    $app->post("/api/users/signin",SignInAction::class)->setName("signIn");


};