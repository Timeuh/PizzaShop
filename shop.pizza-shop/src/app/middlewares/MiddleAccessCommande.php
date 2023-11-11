<?php

namespace pizzashop\shop\app\middlewares;

use pizzashop\shop\domain\exception\TokenInvalidException;
use pizzashop\shop\domain\service\authentification\ServiceAuth;
use pizzashop\shop\domain\service\commande\ServiceCommande;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use Slim\Routing\RouteContext;

class MiddleAccessCommande
{

    private ServiceCommande $serviceCommande;

    /**
     * @param ServiceAuth $serviceAuth
     */
    public function __construct(ServiceCommande $serviceCommande)
    {
        $this->serviceCommande = $serviceCommande;
    }


    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();
        $commandeId = $route->getArguments()['id_commande'];

        try {
            $commande = $this->serviceCommande->accederCommande($commandeId);
        }catch (\Exception $e){
            $responseMessage = array(
                "message" => "La commande n'existe pas",
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

        if ($commande->mail_client != $request->getAttribute('mail')){
            $responseMessage = array(
                "message" => "La commande ne vous appartient pas",
            );
            $response = new Response();
            $response->getBody()->write(json_encode($responseMessage));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }



        return $handler->handle($request);


    }

}