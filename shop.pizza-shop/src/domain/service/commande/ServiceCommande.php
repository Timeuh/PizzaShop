<?php

namespace pizzashop\shop\domain\service\commande;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\entities\commande\Commande;
use pizzashop\shop\domain\entities\commande\EtatCommande;
use pizzashop\shop\domain\entities\commande\Item;
use pizzashop\shop\domain\exception\commandeNonTrouveeException;
use pizzashop\shop\domain\exception\MauvaisEtatCommandeException;
use pizzashop\shop\domain\exception\ServiceCommandeInvalideDonneeException;
use pizzashop\shop\domain\service\catalogue\IInfoProduit;
use pizzashop\shop\domain\service\catalogue\ServiceCatalogue;
use Ramsey\Uuid\Uuid;

use Psr\Log\LoggerInterface;
class ServiceCommande implements ICommander
{

    private LoggerInterface $logger;
    private ServiceCatalogue $serviceCatalogue;

    public function __construct(LoggerInterface $logger)
    {
        $this->serviceCatalogue = new IInfoProduit();
        $this->logger = $logger;
    }


    /**
     * Crée une commande dans la base de données
     *
     * @param CommandeDTO $commande le DTO de la commande à créer
     * @return CommandeDTO le DTO de la commande créée
     */
    public function creerCommande(CommandeDTO $commande): CommandeDTO
    {
        $creation = new Commande();
        $creation->id = Uuid::uuid4()->toString();
        $creation->date_commande = date("Y-m-d H:i:s");
        $creation->etat = 1;
        $creation->delai = 0;
        $creation->type_livraison = $commande->type_livraison;
        $creation->mail_client = $commande->mail_client;

        foreach ($commande->items as $itemDTO){
            try {
                $infoitem = $this->serviceCatalogue->getProduit($itemDTO->numero, $itemDTO->taille);
            }catch (ServiceCommandeInvalideDonneeException $e){
                throw new ServiceCommandeInvalideDonneeException();
            }

            $item = new Item();
            $item->numero = $itemDTO->numero;
            $item->taille = $itemDTO->taille;
            $item->quantite = $itemDTO->quantite;

            $item->libelle = $infoitem->libelle_produit;
            $item->libelle_taille = $infoitem->libelle_taille;
            $item->tarif = $infoitem->tarif;

            $creation->items()->save($item);
        }

        $creation->calculerMontant();
        $creation->save();
        return $creation->toDTO();


    }

    /**
     * Fait passer une commande à l'état "validée"
     *
     * @param string $id id de la commande à valider
     * @return CommandeDTO un DTO de la commande validée
     * @throws CommandeNonTrouveeException si la commande n'est pas trouvée
     * @throws MauvaisEtatCommandeException si la commande est déjà validée ou plus
     */
    public function validerCommande(string $id): CommandeDTO
    {
        try {
            $commande = Commande::findOrFail($id);

            if ($commande->etat >= EtatCommande::ETAT_VALIDE) {
                $this->logger->error('Erreur de validation : impossible de valider la commande '.$id.
                  ' : Cette commande est déjà validée.');
                throw new MauvaisEtatCommandeException($id);
            }

            $commande->update(['etat' => EtatCommande::ETAT_VALIDE]);

            $this->logger->info('Etat Commande : la commande '.$id.' est désormais validée.');
        } catch (ModelNotFoundException $e)  {
            $this->logger->error('Aucune Commande Erreur : il n\'y a pas de commande avec l\'id '.$id.
                '.');
            throw new CommandeNonTrouveeException($id);
        }
        return $commande->toDTO();
    }

    /**
     * Récupère une commande dans la base de données
     *
     * @param string $id id de la commande recherchée
     * @return CommandeDTO un DTO de la commande recherchée
     * @throws CommandeNonTrouveeException si la commande n'est pas trouvée
     */
    public function accederCommande(string $id): CommandeDTO
    {
        try {
            $commande = Commande::findOrFail($id);

        } catch (ModelNotFoundException $e)  {
            $this->logger->error('Aucune Commande Erreur : il n\'y a pas de commande avec l\'id '.$id.'.');
            throw new CommandeNonTrouveeException($id);
        }
        $this->logger->info('Commande : récupération de la commande id '.$id.'.');
        return $commande->toDTO();
    }
}