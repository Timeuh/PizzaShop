<?php

use Psr\Container\ContainerInterface;
use pizzashop\auth\api\app\actions\SignInAction;
use pizzashop\auth\api\app\actions\ValiderTokenJWTAction;

return [
    SignInAction::class => function (ContainerInterface $c) {
        return new SignInAction($c->get('authenticate.service'));
    },
    ValiderTokenJWTAction::class => function (ContainerInterface $c) {
        return new ValiderTokenJWTAction($c->get('authenticate.service'));
    },
];