<?php

namespace pizzashop\cat\domain\entities;

use pizzashop\cat\domain\dto\ProduitDTO;

class Produit extends \Illuminate\database\eloquent\Model
{

    protected $connection = 'catalog';
    protected $table = 'produit';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['numero', 'libelle', 'description', 'image'];

    public function categorie(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function tailles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Taille::class, 'tarif', 'produit_id', 'taille_id')
            ->withPivot('tarif');
    }

    public function toDTO():ProduitDTO
    {
        return new ProduitDTO(
            $this->numero,
            $this->libelle,
            $this->categorie->libelle,
            $this->tailles->libelle,
            $this->tailles->tarif
        );
    }


}