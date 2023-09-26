<?php

namespace pizzashop\shop\app\actions;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use pizzashop\shop\domain\service\commande\ICommander;
use pizzashop\shop\domain\exception\commandeNonTrouveeException;
use pizzashop\shop\domain\exception\MauvaisEtatCommandeException;
use Psr\Log\LoggerInterface;

class ValiderCommandeAction
{
    private ICommander $commander;
    private LoggerInterface $logger;

    public function __construct(ICommander $commander, LoggerInterface $logger)
    {
        $this->commander = $commander;
        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        // Récupérer l'ID de la commande depuis les paramètres de l'URL
        $idCommande = $args['id_commande'];

        // Récupérer le corps de la requête JSON
        $requestData = $request->getParsedBody();

        // Vérifier si la commande existe en utilisant le service de commande
        try {
            $commande = $this->commander->accederCommande($idCommande);
        } catch (commandeNonTrouveeException $e) {
            // La commande n'existe pas, renvoyer une réponse 404
            return $response->withJson(['error' => 'Commande introuvable'], 404);
        }

        // Vérifier si le champ "etat" est présent dans le corps de la requête
        if (isset($requestData['etat']) && $requestData['etat'] === 'validee') {
            try {
                // Valider la commande en utilisant le service de commande
                $commandeValidee = $this->commander->validerCommande($idCommande);
            } catch (MauvaisEtatCommandeException $e) {
                // La commande est déjà validée, renvoyer une réponse 400
                return $response->withJson(['error' => 'Cette commande est déjà validée'], 400);
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
