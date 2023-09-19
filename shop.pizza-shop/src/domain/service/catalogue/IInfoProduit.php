<?php

namespace pizzashop\shop\domain\service\catalogue;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use pizzashop\shop\domain\dto\catalogue\ProduitDTO;
use pizzashop\shop\domain\entities\catalogue\Produit;
use pizzashop\shop\domain\exception\ProduitNonTrouveeException;
use pizzashop\shop\domain\service\catalogue\ServiceCatalogue;

class IInfoProduit implements ServiceCatalogue {

    public function getProduit(int $num, int $taille): ProduitDTO {
        try{
            $produit = Produit::where('id', $num)->andWhere('taille', $taille)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ProduitNonTrouveeException($num);
        }
        return new ProduitDTO($produit->id, $produit->nom, $produit->description, $produit->prix, $produit->taille);

    }

}