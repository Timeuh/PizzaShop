<?php

namespace pizzashop\shop\domain\service\commande;

use pizzashop\shop\domain\dto\commande\CommandeDTO;

interface ICommander
{
    public function creercommande(CommandeDTO $commande): void;
    public function validerCommande(String $id): void;
    public function getCommande(String $id): CommandeDTO;

}