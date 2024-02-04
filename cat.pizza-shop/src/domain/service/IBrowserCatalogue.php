<?php

namespace pizzashop\cat\domain\service;


use pizzashop\cat\domain\dto\ProduitDTO;

interface IBrowserCatalogue {

    public function getProduit(int $num, int $taille): ProduitDTO;
    public function getProduitsParCategorie($categorie,?string $key): array;
    public function getAllProduct(?string $key): array;





}