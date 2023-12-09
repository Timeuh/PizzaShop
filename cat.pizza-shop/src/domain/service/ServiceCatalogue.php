<?php

namespace pizzashop\cat\domain\service;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use pizzashop\cat\domain\dto\ProduitDTO;
use pizzashop\cat\domain\entities\Produit;
use pizzashop\cat\domain\exception\ProduitNonTrouveeException;


class ServiceCatalogue implements IInfoProduit, IBrowserCatalogue {

    public function getProduit(int $num, int $taille): ProduitDTO {
        try {
            $produit = Produit::where('numero', $num)
                ->whereHas('tailles', function ($query) use ($taille) {
                    $query->where('taille_id', $taille);
                })
                ->with('categorie', 'tailles')
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ProduitNonTrouveeException($num);
        }
        return new ProduitDTO(
            $produit->id,
            $produit->numero,
            $produit->libelle,
            $produit->description,
            $produit->categorie->libelle,
            $produit->tailles[$taille-1]->libelle,
            $produit->tailles[$taille-1]->pivot->tarif,
        );
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
            $produitsDTO[] = new ProduitDTO(
                $produit->id,
                $produit->numero,
                $produit->libelle,
                $produit->description,
                "",
                "",
                0
            ); }
        return $produitsDTO;
    }

}