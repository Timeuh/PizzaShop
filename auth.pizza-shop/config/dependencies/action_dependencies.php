<?php

use pizzashop\auth\api\app\actions\SignInAction;
use pizzashop\auth\api\app\actions\ValiderTokenJWTAction;
use pizzashop\auth\api\app\actions\UserRefreshAction;
use Psr\Container\ContainerInterface;

return [
    SignInAction::class => function (ContainerInterface $c) {
        return new SignInAction($c->get('authenticate.service'));
    },
  
    ValiderTokenJWTAction::class => function (ContainerInterface $c) {
        return new ValiderTokenJWTAction($c->get('authenticate.service'));
    },

    UserRefreshAction::class => function (ContainerInterface $c){
        return new UserRefreshAction($c->get('authenticate.service'));
    },
];