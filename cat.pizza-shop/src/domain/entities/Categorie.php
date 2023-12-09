<?php

namespace pizzashop\cat\domain\entities;

class Categorie extends \Illuminate\Database\Eloquent\Model
{

    protected $connection = 'catalog';
    protected $table = 'categorie';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['libelle'];

    public function produits()
    {
        return $this->hasMany(Produit::class, 'categorie_id');
    }


}