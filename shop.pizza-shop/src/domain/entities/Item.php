<?php

namespace pizzashop\shop\domain\entities;

use Illuminate\Database\Eloquent\Model;
use pizzashop\shop\domain\dto\ItemDTO;
use pizzashop\shop\domain\entities\Commande;

class Item extends Model
{

    public $timestamps = false;
    protected $connection = 'commande';
    protected $table = 'item';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'numero', 'libelle', 'taille', 'tarif','libelle_taille', 'quantite', 'commande_id'];

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }

    public function toDTO(): ItemDTO
    {
        $itemDTO = new ItemDTO($this->id,$this->numero, $this->libelle,$this->taille,$this->libelle_taille, $this->quantite,$this->tarif, $this->commande_id);
        return $itemDTO;
    }

}