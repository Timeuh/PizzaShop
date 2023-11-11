<?php

namespace pizzashop\shop\app\middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MiddleAuth
{

    public function __invoke(Request $request, Response $response, $args): Response
    {

    }

}