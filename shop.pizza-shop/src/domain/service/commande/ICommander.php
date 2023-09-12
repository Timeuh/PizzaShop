<?php

namespace pizzashop\shop\domain\service\commande;

use pizzashop\shop\domain\dto\commande\CommandeDTO;

interface ICommander
{
    public function creercommande(CommandeDTO $commande): CommandeDTO;
    public function validerCommande(String $id): CommandeDTO;
    public function getCommande(String $id): CommandeDTO;

}