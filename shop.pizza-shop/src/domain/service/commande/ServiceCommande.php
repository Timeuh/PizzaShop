<?php

namespace pizzashop\shop\domain\service\commande;

use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\entities\commande\Commande;

class ServiceCommande implements ICommander {

    public function convertirToCommandeDTO(CommandeDTO $commandeDTO): Commande {
        $commande = new Commande();
        $commande->id = $commandeDTO->id;
        $commande->date_commande = $commandeDTO->date_commande;
        $commande->type_livraison = $commandeDTO->type_livraison;
        $commande->etat = $commandeDTO->etat;
        $commande->montant_total = $commandeDTO->montant_total;
        $commande->id_client = $commandeDTO->id_client;
        return $commande;
    }

    public function convertirFromCommandeDTO(Commande $commande): CommandeDTO {
        return new CommandeDTO(
            $commande->id,
            $commande->date_commande,
            $commande->type_livraison,
            $commande->etat,
            $commande->montant_total,
            $commande->id_client
        );
    }

    public function creercommande(CommandeDTO $commande): void {
        // TODO: Implement creercommande() method.
    }

    public function validerCommande(string $id): void {
        // TODO: Implement validerCommande() method.
    }

    public function getCommande(string $id): CommandeDTO {
        // TODO: Implement getCommande() method.
    }
}