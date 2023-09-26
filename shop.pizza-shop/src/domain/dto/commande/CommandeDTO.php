<?php

namespace pizzashop\shop\domain\dto\commande;

use DateTime;
use pizzashop\shop\domain\dto\DTO;

class CommandeDTO extends DTO {
    public string $id;
    public DateTime $date_commande;
    public int $type_livraison;
    public int $etat;
    public float $montant_total;
    public string $mail_client;
    public int $delai;
    public array $items;

    public function __construct(int $type_livraison, string $mail_client, array $items, float $montant_total, string $id = '', DateTime $date_commande = null,  int $etat = 1,  int $delai = 0) {
        $this->id = $id;
        $this->date_commande = $date_commande;
        $this->type_livraison = $type_livraison;
        $this->etat = $etat;
        $this->montant_total = $montant_total;
        $this->mail_client = $mail_client;
        $this->items = $items;
        $this->delai = $delai;
    }
}