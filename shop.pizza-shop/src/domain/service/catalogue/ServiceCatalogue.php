<?php

namespace pizzashop\shop\domain\service\catalogue;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use pizzashop\shop\domain\dto\catalogue\ProduitDTO;
use pizzashop\shop\domain\entities\catalogue\Produit;
use pizzashop\shop\domain\exception\ProduitNonTrouveeException;


class ServiceCatalogue implements IInfoProduit, IBrowserCatalogue{

public function getProduit(int $num, int $taille): ProduitDTO {
    try{
        $produit = Produit::where('id', $num)->andWhere('taille', $taille)->firstOrFail();
    } catch (ModelNotFoundException $e) {
        throw new ProduitNonTrouveeException($num);
    }
    return new ProduitDTO($produit->id, $produit->nom, $produit->description, $produit->prix, $produit->taille);

}
    public function getProduitsParCategorie($categorie): array {
        try {
            $produits = Produit::where('categorie', $categorie)->get();
        } catch (ModelNotFoundException $e) {
            throw new Exception("Aucun produit trouvé");
        }
        $produitsDTO = [];
        foreach ($produits as $produit) {
            $produitsDTO[] = new ProduitDTO($produit->id, $produit->nom, $produit->description, $produit->prix, $produit->taille);
        }
        return $produitsDTO;

    }

    public function getAllProduct(): array {
        try {
            $produits = Produit::all();
        } catch (ModelNotFoundException $e) {
            throw new Exception("Aucun produit trouvé");
        }
        $produitsDTO = [];
        foreach ($produits as $produit) {
            $produitsDTO[] = new ProduitDTO($produit->id, $produit->nom, $produit->description, $produit->prix, $produit->taille);
        }
        return $produitsDTO;
    }

}