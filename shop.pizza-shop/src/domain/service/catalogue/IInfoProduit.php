<?php

namespace pizzashop\shop\domain\service\catalogue;

use pizzashop\shop\domain\dto\catalogue\ProduitDTO;
use pizzashop\shop\domain\service\catalogue\ServiceCatalogue;

class IInfoProduit implements ServiceCatalogue {

    public function getProduit(int $num, int $taille): ProduitDTO {
        //TODO: Implement getProduit() method.
    }

}