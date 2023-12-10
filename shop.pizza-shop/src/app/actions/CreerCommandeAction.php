<?php

namespace pizzashop\shop\app\actions;

use Error;
use Exception;
use pizzashop\shop\domain\dto\CommandeDTO;
use pizzashop\shop\domain\exception\ServiceCommandeInvalideDonneeException;
use pizzashop\shop\domain\exception\ValidationCommandeException;
use pizzashop\shop\domain\service\commande\ICommander;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CreerCommandeAction extends AbstractAction {

    private ICommander $serviceCommande;

    public function __construct(ICommander $s)
    {
        $this->serviceCommande = $s;
    }


    public function __invoke(Request $request, Response $response, $args) : Response {
        $body = $request->getParsedBody();

        $commande = new CommandeDTO($body['type_livraison'], $request->getAttribute('mail'), $body['items']);

        try {
            $commandeCree = $this->serviceCommande->creerCommande($commande);
            $response->getBody()->write(json_encode($commandeCree));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json')
                ->withHeader('Location','/commandes/'.$commandeCree->id);
        } catch (ServiceCommandeInvalideDonneeException | ValidationCommandeException $e) {
            $responseMessage = array(
                "message" => "400 Bad Request",
                "exception" => array(
                    "type" => $e::class,
                    "code" => $e->getCode(),
                    "message" => $e->getMessage(),
                    "file" => $e->getFile(),
                    "line" => $e->getLine()
                )
            );
            $response->getBody()->write(json_encode($responseMessage));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        } catch (Exception | Error $e) {
            $responseMessage = array(
                "message" => "500 Server Error",
                "exception" => array(
                    "type" => $e::class,
                    "code" => $e->getCode(),
                    "message" => $e->getMessage(),
                    "file" => $e->getFile(),
                    "line" => $e->getLine()
                )
            );
            $response->getBody()->write(json_encode($responseMessage));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
}