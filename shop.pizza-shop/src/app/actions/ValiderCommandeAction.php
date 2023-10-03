<?php

namespace pizzashop\shop\app\actions;

use pizzashop\shop\domain\exception\commandeNonTrouveeException;
use pizzashop\shop\domain\exception\MauvaisEtatCommandeException;
use pizzashop\shop\domain\service\commande\ServiceCommande;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ValiderCommandeAction
{
    public function __invoke(Request $request, Response $response, $args)
    {
        $logger = new \Monolog\Logger('commandes');
        $logger->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . '/../logs/commandes.log', \Monolog\Level::Debug));
        $serviceCommande = new ServiceCommande($logger);

        // Récupérer l'ID de la commande depuis les paramètres de l'URL
        $idCommande = $args['id_commande'];

        // Récupérer le corps de la requête JSON
        $requestData = $request->getParsedBody();

        // Vérifier si la commande existe en utilisant le service de commande
        try {
            $commande = $serviceCommande->accederCommande($idCommande);
        } catch (CommandeNonTrouveeException $e) {
            $responseMessage = array(
                "message" => "404 Not Found",
                "exception" => array(
                    "type" => $e::class,
                    "code" => $e->getCode(),
                    "message" => $e->getMessage(),
                    "file" => $e->getFile(),
                    "line" => $e->getLine()
                ));

            $response->getBody()->write(json_encode($responseMessage));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        // Vérifier si le champ "etat" est présent dans le corps de la requête
        if (isset($requestData['etat']) && $requestData['etat'] === 'validee') {
            try {
                // Valider la commande en utilisant le service de commande
                $commandeValidee = $serviceCommande->validerCommande($idCommande);
            } catch (MauvaisEtatCommandeException $e) {
                $responseMessage = array(
                    "message" => "400 la requête est déjà validée",
                    "exception" => array(
                        "type" => $e::class,
                        "code" => $e->getCode(),
                        "message" => $e->getMessage(),
                        "file" => $e->getFile(),
                        "line" => $e->getLine()
                    ));

                $response->getBody()->write(json_encode($responseMessage));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }

            // En cas de succès, retourner une réponse formatée
            $responseJson = [
                'message' => 'Commande validée avec succès',
                'id_commande' => $idCommande,
                'etat' => 'validee'
            ];

            return $response->withJson($responseJson);
        } else {
            // La requête est invalide
            if (!isset($requestData['etat'])) {
                // Le champ "etat" est manquant
                return $response->withJson(['error' => 'Le champ "etat" est requis'], 400);
            } else {
                // La transition demandée n'est pas correcte
                return $response->withJson(['error' => 'Transition demandée incorrecte'], 400);
            }
        }
    }
}
