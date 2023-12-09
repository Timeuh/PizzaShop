<?php

namespace pizzashop\cat\app\actions;

use pizzashop\cat\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetProduitsAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // TODO: Implement __invoke() method.
    }
}