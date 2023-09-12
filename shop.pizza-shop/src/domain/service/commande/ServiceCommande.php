<?php

namespace pizzashop\shop\domain\service\commande;

use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\service\commande\ICommander;

class ServiceCommande implements ICommander
{

    public function creercommande(CommandeDTO $commande): void
    {
        // TODO: Implement creercommande() method.
    }

    public function validerCommande(string $id): void
    {
        // TODO: Implement validerCommande() method.
    }

    public function getCommande(string $id): CommandeDTO
    {
        // TODO: Implement getCommande() method.
    }
}