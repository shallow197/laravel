<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'date_ajout',
        'date_debut',
        'date_echeance',
        'categorie',
        'statut',
        'priorite',
        'description',
        'commentaires',
        'entreprise',
        'user_id',
    ];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}



}
