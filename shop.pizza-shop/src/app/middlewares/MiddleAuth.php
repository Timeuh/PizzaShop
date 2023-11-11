<?php

namespace pizzashop\shop\app\middlewares;

use pizzashop\shop\domain\exception\TokenInvalidException;
use pizzashop\shop\domain\service\authentification\ServiceAuth;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use Slim\Routing\RouteContext;

class MiddleAuth
{

    private ServiceAuth $serviceAuth;

    /**
     * @param ServiceAuth $serviceAuth
     */
    public function __construct(ServiceAuth $serviceAuth)
    {
        $this->serviceAuth = $serviceAuth;
    }


    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $headers = $request->getHeader('Authorization');

        if (count($headers) == 0){
            $responseMessage = array(
                "message" => "Le token est absent",
            );
            $response = new Response();
            $response->getBody()->write(json_encode($responseMessage));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }

        try{
            $mail = $this->serviceAuth->checkTokenJwt($headers);
        }catch (TokenInvalidException $e){
            $responseMessage = array(
                "message" => "Le token est invalide",
                "exception" => array(
                    "type" => $e::class,
                    "code" => $e->getCode(),
                    "message" => $e->getMessage(),
                    "file" => $e->getFile(),
                    "line" => $e->getLine()
                )
            );
            $response = new Response();
            $response->getBody()->write(json_encode($responseMessage));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }

        $request = $request->withAttribute('mail',$mail['email']);

        return $handler->handle($request);


    }

}