<?php

namespace pizzashop\shop\domain\entities\commande;

use pizzashop\shop\domain\dto\commande\CommandeDTO;

class Commande extends \Illuminate\Database\Eloquent\Model {
    protected $connection = 'commande';
    protected $table = 'commande';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['type_livraison', 'id', 'delai', 'date_commande', 'etat', 'montant_total', 'mail_client'];

    public function items() {
        return $this->hasMany(Item::class, 'commande_id');
    }

    public function calculerMontant(){
        foreach ($this->items as $item){
            $this->montant_total+=$this->montant_total+$item->tarif;
        }
    }

    /**
     * Convertis l'entité en DTO
     *
     * @return CommandeDTO le DTO représentant l'entité
     */
    public function toDTO(): CommandeDTO {
        $this->date_commande= new \DateTime($this->date_commande);
        return new CommandeDTO(
            $this->id,
            $this->date_commande,
            $this->type_livraison,
            $this->etat,
            $this->montant_total,
            $this->mail_client,
            $this->items->toArray(),
            $this->delai
        );
    }
}

enum EtatCommande {
    const ETAT_CREE = 1;
    const ETAT_VALIDE = 2;
}