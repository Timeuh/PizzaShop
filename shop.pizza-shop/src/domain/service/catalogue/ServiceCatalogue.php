<?php

namespace pizzashop\shop\domain\service\catalogue;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use pizzashop\shop\domain\dto\ProduitDTO;
use pizzashop\shop\domain\exception\ProduitNonTrouveeException;


class ServiceCatalogue implements IInfoProduit, IBrowserCatalogue {

    private Client $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getProduit(int $num, int $taille): ProduitDTO {

        try {
            $check = $this->client->get('/produits/'.$num);
            $produitJson = json_decode($check->getBody(), true);
            $taille_libelle="normale";
            if ($taille==2){
                $taille_libelle="grande";
            }
            $info = $produitJson['produit'];
            return new ProduitDTO($info['id'],$info['numero'],
                $info['libelle'],$info['description'],$info['categorie'],
                $taille_libelle,$info['taille'][$taille_libelle]['tarif']);
        } catch (Exception $e) {
            throw new ProduitNonTrouveeException($num);
        }
    }

    public function getProduitsParCategorie($categorie): array {
        try {
            $check = $this->client->get('/categorie/'.$categorie.'/produits');
            return json_decode($check->getBody(), true);
        } catch (ModelNotFoundException $e) {
            throw new Exception("Aucun produit trouvé");
        }

    }

    public function getAllProduct(): array {
        try {
            $check = $this->client->get('/produits/');
            return json_decode($check->getBody(), true);
        } catch (ModelNotFoundException $e) {
            throw new Exception("Aucun produit trouvé");
        }
    }

}