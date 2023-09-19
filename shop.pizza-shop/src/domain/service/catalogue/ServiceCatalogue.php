<?php

namespace pizzashop\shop\domain\service\catalogue;

interface ServiceCatalogue {

    public function getProduit(int $num, int $taille): ProduitDTO;
    public function getProduitsParCategorie($categorie): array;
    public function getAllProduct(): array;

}