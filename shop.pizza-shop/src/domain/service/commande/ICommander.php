<?php

namespace pizzashop\shop\domain\service\commande;

use pizzashop\shop\domain\dto\commande\CommandeDTO;

interface ICommander {
    public function creerCommande(CommandeDTO $commande): CommandeDTO;

    public function validerCommande(string $id): CommandeDTO;

    public function accederCommande(string $id): CommandeDTO;

}