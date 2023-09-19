<?php

namespace pizzashop\shop\domain\service\commande;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\entities\commande\Commande;
use pizzashop\shop\domain\entities\commande\EtatCommande;
use pizzashop\shop\domain\exception\commandeNonTrouveeException;
use pizzashop\shop\domain\exception\MauvaisEtatCommandeException;
use Psr\Log\LoggerInterface;

class ServiceCommande implements ICommander {
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }

    /**
     * Crée une commande dans la base de données
     *
     * @param CommandeDTO $commande le DTO de la commande à créer
     * @return CommandeDTO le DTO de la commande créée
     */
    public function creerCommande(CommandeDTO $commande): CommandeDTO {
        // TODO: Implement creercommande() method.
    }

    /**
     * Fait passer une commande à l'état "validée"
     *
     * @param string $id id de la commande à valider
     * @return CommandeDTO un DTO de la commande validée
     * @throws CommandeNonTrouveeException si la commande n'est pas trouvée
     * @throws MauvaisEtatCommandeException si la commande est déjà validée ou plus
     */
    public function validerCommande(string $id): CommandeDTO {
        try {
            $commande = Commande::findOrFail($id);

            if ($commande->etat >= EtatCommande::ETAT_VALIDE) {
                $this->logger->error('Erreur de validation : impossible de valider la commande '.$id.
                  ' : Cette commande est déjà validée.');
                throw new MauvaisEtatCommandeException($id);
            }

            $commande->update(['etat' => EtatCommande::ETAT_VALIDE]);
            $this->logger->info('Etat Commande : la commande '.$id.' est désormais validée.');
        } catch (ModelNotFoundException $e)  {
            $this->logger->error('Aucune Commande Erreur : il n\'y a pas de commande avec l\'id '.$id.
                '.');
            throw new CommandeNonTrouveeException($id);
        }
        return $commande->toDTO();
    }

    /**
     * Récupère une commande dans la base de données
     *
     * @param string $id id de la commande recherchée
     * @return CommandeDTO un DTO de la commande recherchée
     * @throws CommandeNonTrouveeException si la commande n'est pas trouvée
     */
    public function accederCommande(string $id): CommandeDTO {
        try {
            $commande = Commande::findOrFail($id);
        } catch (ModelNotFoundException $e)  {
            $this->logger->error('Aucune Commande Erreur : il n\'y a pas de commande avec l\'id '.$id.'.');
            throw new CommandeNonTrouveeException($id);
        }
        $this->logger->info('Commande : récupération de la commande id '.$id.'.');
        return $commande->toDTO();
    }
}