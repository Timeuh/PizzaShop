<?php
declare(strict_types=1);

use pizzashop\auth\api\app\actions\SignInAction;

return function( \Slim\App $app):void {

    $app->post("/api/users/signin",SignInAction::class)->setName("signIn");


};