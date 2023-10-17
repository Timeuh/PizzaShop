<?php

use Psr\Container\ContainerInterface;
use pizzashop\auth\api\app\actions\SignInAction;

return[
    SignInAction::class => function (ContainerInterface $c){
        return new SignInAction($c->get('authenticate.service'));
    },
];