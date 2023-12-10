<?php

namespace pizzashop\shop\domain\service\catalogue;

use pizzashop\shop\domain\dto\ProduitDTO;

interface IInfoProduit {

    public function getProduit(int $num, int $taille): ProduitDTO;

}