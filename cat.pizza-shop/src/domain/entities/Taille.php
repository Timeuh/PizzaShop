<?php

namespace pizzashop\cat\domain\entities;

use pizzashop\cat\domain\entities\Produit;

class Taille extends \Illuminate\Database\Eloquent\Model
{

    protected $connection = 'catalog';
    protected $table = 'taille';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [ 'libelle'];

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'tarif', 'taille_id', 'produit_id');
    }

    public function toDTO(){

    }
}