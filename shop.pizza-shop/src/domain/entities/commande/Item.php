<?php

namespace pizzashop\shop\domain\entities\commande;

use Illuminate\Database\Eloquent\Model;
use pizzashop\shop\domain\dto\commande\ItemDTO;

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
        $itemDTO = new ItemDTO($this->id,$this->numero, $this->libelle,$this->taille,$this->libelle_taille, $this->quantite,$this->tarif);
        return $itemDTO;
    }

}