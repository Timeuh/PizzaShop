<?php

namespace pizzashop\shop\domain\service\catalogue;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use pizzashop\shop\domain\dto\catalogue\ProduitDTO;
use pizzashop\shop\domain\entities\catalogue\Produit;
use pizzashop\shop\domain\exception\ProduitNonTrouveeException;
use pizzashop\shop\domain\service\catalogue\ServiceCatalogue;

interface IInfoProduit {

    public function getProduit(int $num, int $taille): ProduitDTO;

}