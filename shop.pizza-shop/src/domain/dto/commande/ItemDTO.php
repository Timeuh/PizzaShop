<?php

namespace pizzashop\shop\domain\dto\commande;

use pizzashop\shop\domain\dto\DTO;

class ItemDTO extends DTO
{
    public int $id;
    public int $numero;
    public string $libelle;
    public int $taille;
    public string $libelle_taille;
    public int $quantite;
    public float $tarif;

    public function __construct(int $id, int $numero, string $libelle, int $taille, string $libelle_taille, int $quantite, float $tarif)
    {
        $this->id = $id;
        $this->numero = $numero;
        $this->libelle = $libelle;
        $this->libelle_taille = $libelle_taille;
        $this->taille = $taille;
        $this->quantite = $quantite;
        $this->tarif = $tarif;
    }
}