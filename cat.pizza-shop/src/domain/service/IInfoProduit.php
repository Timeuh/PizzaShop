<?php

namespace pizzashop\cat\domain\service;

use pizzashop\cat\domain\dto\ProduitDTO;

interface IInfoProduit {

    public function getProduit(int $num, int $taille): ProduitDTO;

}