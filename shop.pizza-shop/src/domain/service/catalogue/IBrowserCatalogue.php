<?php

namespace pizzashop\shop\domain\service\catalogue;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use mysql_xdevapi\Exception;
use pizzashop\shop\domain\dto\catalogue\ProduitDTO;
use pizzashop\shop\domain\entities\catalogue\Produit;
use pizzashop\shop\domain\exception\ProduitNonTrouveeException;
use pizzashop\shop\domain\service\catalogue\ServiceCatalogue;

interface IBrowserCatalogue {

    public function getProduit(int $num, int $taille): ProduitDTO;
    public function getProduitsParCategorie($categorie): array;
    public function getAllProduct(): array;





}