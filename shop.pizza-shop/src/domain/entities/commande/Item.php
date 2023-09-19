<?php

namespace pizzashop\shop\domain\entities\commande;

use pizzashop\shop\domain\dto\commande\ItemDTO;

class Item extends \Illuminate\Database\Eloquent\Model
{

    protected $connection = 'commande';
    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [ 'id','numero','libelle','taille','tarif','quantite','commande_id'];

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }
}