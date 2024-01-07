<?php

namespace pizzashop\shop\domain\service\catalogue;

use pizzashop\shop\domain\dto\ProduitDTO;

interface IBrowserCatalogue {

    public function getProduit(int $num, int $taille): ProduitDTO;
    public function getProduitsParCategorie($categorie): array;
    public function getAllProduct(): array;





}