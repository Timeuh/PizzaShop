<?php

use pizzashop\auth\api\app\auth\managers\JwtManager;
use pizzashop\auth\api\app\auth\providers\AuthProvider;
use pizzashop\auth\api\domain\service\AuthService;
use Psr\Container\ContainerInterface;

return[

    'jwt.manager' => function (ContainerInterface $c) {
        return new JwtManager();
    },

    'authenticate.provider' => function (ContainerInterface $c) {
        return new AuthProvider();
    },

    'authenticate.service' => function (ContainerInterface $c) {
        return new AuthService($c->get('jwt.manager'),$c->get('authenticate.provider'));
    },
];