<?php

namespace pizzashop\cat\domain\service;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use pizzashop\cat\domain\dto\ProduitDTO;
use pizzashop\cat\domain\entities\Categorie;
use pizzashop\cat\domain\entities\Produit;
use pizzashop\cat\domain\exception\CategorieNonTrouveeException;
use pizzashop\cat\domain\exception\ProduitNonTrouveeException;


class ServiceCatalogue implements IInfoProduit, IBrowserCatalogue {

    public function getProduit(int $id, int $taille): ProduitDTO {
        try {
            $produit = Produit::findOrFail($id)
                ->whereHas('tailles', function ($query) use ($taille) {
                    $query->where('taille_id', $taille);
                })
                ->with('categorie', 'tailles')
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ProduitNonTrouveeException($id);
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

    public function getProduitsParCategorie($categorie,?string $key): array {
        try {
            $cat = Categorie::findOrFail($categorie);
            $produits = Produit::where('categorie_id', $categorie);

            if ($key != null) {
                $produits->where(function ($query) use ($key) {
                    $query->whereRaw('LOWER(libelle) like ?', ['%' . strtolower($key) . '%'])
                        ->orWhereRaw('LOWER(description) like ?', ['%' . strtolower($key) . '%']);
                });
            }

            $produits = $produits->get();

        } catch (ModelNotFoundException $e) {
            throw new CategorieNonTrouveeException($categorie);
        }
        if (!$produits){
            return ['Aucun produit'];
        }else {
            $produitsDTO = [];
        }
        foreach ($produits as $produit) {
            $produitsDTO[] = new ProduitDTO(
                $produit->id,
                $produit->numero,
                $produit->libelle,
                $produit->description,
                "",
                "",
                0
            );
        }
        return ['cat'=>$cat,"produits"=>$produitsDTO];

    }

    public function getAllProduct(?string $key): array {
        try {
            if ($key!=null){
                $produits = Produit::whereRaw('LOWER(libelle) like ?', ['%' . strtolower($key) . '%'])
                    ->orWhereRaw('LOWER(description) like ?', ['%' . strtolower($key) . '%'])->get();

            }else{
                $produits = Produit::all();
            }
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