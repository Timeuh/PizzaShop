<?php

namespace pizzashop\shop\domain\dto;

class ItemDTO extends DTO {
    public int $id;
    public int $numero;
    public string $libelle;
    public int $taille;
    public string $libelle_taille;
    public int $quantite;
    public float $tarif;
    public string $commande_id;

    public function __construct(int $id, int $numero, string $libelle, int $taille, string $libelle_taille, int $quantite, float $tarif, string $commande_id) {
        $this->id = $id;
        $this->numero = $numero;
        $this->libelle = $libelle;
        $this->libelle_taille = $libelle_taille;
        $this->taille = $taille;
        $this->quantite = $quantite;
        $this->tarif = $tarif;
        $this->commande_id = $commande_id;
    }
}