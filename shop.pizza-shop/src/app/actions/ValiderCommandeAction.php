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

        $etatCommande = $commande->etat;

        // Vérifier si le champ "etat" est présent dans le corps de la requête
        if ($etatCommande) {
            // Récupérer l'état actuel de la commande

            if ($etatCommande == 2) {
                $messageEtatCommande = 'validée';
            } elseif ($etatCommande == 3) {
                $messageEtatCommande = 'payée';
            } elseif ($etatCommande == 4) {
                $messageEtatCommande = 'livrée';
            } else {
                $messageEtatCommande = 'créée';
            }

            if ($etatCommande == 1) {
                // L'état actuel de la commande est égal à 1
                try {
                    // Valider la commande en utilisant le service de commande
                    $commandeValidee = $serviceCommande->validerCommande($idCommande);
                    // En cas de succès, retourner une réponse formatée
                    $responseJson = [
                        'message' => 'Commande validée avec succès',
                        'id_commande' => $idCommande,
                        'etat' => 'etat : ' . $commandeValidee->etat,
                    ];

                    $response->getBody()->write(json_encode($responseJson));
                    return $response->withHeader('Content-Type', 'application/json');
                } catch (MauvaisEtatCommandeException $e) {
                    $responseMessage = array(
                        "message" => "400 Bad Request",
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
            } else {
                // L'état actuel de la commande n'est pas égal à 1
                $response->getBody()->write(json_encode(['error' => 'Impossible de valider la commande car l\'état actuel est : ' . $messageEtatCommande . ' au lieu de créée']));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
        } else {
            // Le champ "etat" est manquant
            $response->getBody()->write(json_encode(['error' => 'Problème serveur']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
}