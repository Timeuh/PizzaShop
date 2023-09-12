<?php

namespace pizzashop\shop\domain\entities\commande;

class Commande extends \Illuminate\Database\Eloquent\Model
{

    protected $connection = 'commande';
    protected $table = 'commande';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [ 'type_livraison','id','delai','date_commande','etat','montant_total','id_client'];

    public function items()
    {
        return $this->hasMany(Item::class, 'commande_id');
    }

}