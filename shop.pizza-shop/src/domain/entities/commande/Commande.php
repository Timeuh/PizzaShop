<?php

namespace pizzashop\shop\domain\entities\commande;

use pizzashop\shop\domain\dto\commande\CommandeDTO;

class Commande extends \Illuminate\Database\Eloquent\Model {
    protected $connection = 'commande';
    protected $table = 'commande';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['type_livraison', 'id', 'delai', 'date_commande', 'etat', 'montant_total', 'id_client'];

    public function items() {
        return $this->hasMany(Item::class, 'commande_id');
    }

    public function toDTO(): CommandeDTO {
        return new CommandeDTO(
            $this->id,
            $this->date_commande,
            $this->type_livraison,
            $this->etat,
            $this->montant_total,
            $this->id_client,
            $this->items,
            $this->delai
        );
    }
}