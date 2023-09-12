<?php

namespace pizzashop\shop\domain\service\commande;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\entities\commande\Commande;
use pizzashop\shop\domain\exception\commandeNonTrouveeException;
use pizzashop\shop\domain\exception\MauvaisEtatCommandeException;

class ServiceCommande implements ICommander {

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
        // TODO: Implement validerCommande() method.
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
            throw new CommandeNonTrouveeException($id);
        }
        return $commande->toDTO();
    }
}