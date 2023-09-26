<?php

namespace pizzashop\shop\app\actions;

use Error;
use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\exception\ServiceCommandeInvalideDonneeException;
use pizzashop\shop\domain\exception\ValidationCommandeException;
use pizzashop\shop\domain\service\commande\ServiceCommande;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CreerCommandeAction {
    public function __invoke(Request $request, Response $response, $args) : Response {
        $body = $request->getParsedBody();

        $logger = new Logger('commandes');
        $logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/commandes.log', Level::Debug));
        $serviceCommande = new ServiceCommande($logger);

        $commande = new CommandeDTO($body['type_livraison'], $body['mail_client'], $body['items']);

        try {
            $commandeCreee = $serviceCommande->creerCommande($commande);
            $response->getBody()->write(json_encode($commandeCreee));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
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