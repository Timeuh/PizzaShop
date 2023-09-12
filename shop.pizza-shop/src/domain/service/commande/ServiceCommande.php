<?php

namespace pizzashop\shop\domain\service\commande;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\entities\commande\Commande;
use pizzashop\shop\domain\exception\commandeNonTrouveeException;

class ServiceCommande implements ICommander {


    public function creercommande(CommandeDTO $commande): CommandeDTO {
        // TODO: Implement creercommande() method.
    }

    public function validerCommande(string $id): CommandeDTO {
        // TODO: Implement validerCommande() method.
    }

    public function accederCommande(string $id): CommandeDTO {
        try {
            $commande = Commande::findOrFail($id);
        } catch (ModelNotFoundException $e)  {
            throw new CommandeNonTrouveeException($id);
        }
        return $commande->toDTO();
    }
}