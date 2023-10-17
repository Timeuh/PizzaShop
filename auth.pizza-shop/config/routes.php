<?php
declare(strict_types=1);

use pizzashop\auth\api\app\actions\SignInAction;
use pizzashop\auth\api\app\actions\UserRefreshAction;

return function( \Slim\App $app):void {
    $app->post("/api/users/signin",SignInAction::class)->setName("signIn");
    $app->post('/api/users/refresh', UserRefreshAction::class)->setName('refreshUser');
};