<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestation extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'categorie',
        'prix',
        'duree',
        'image',
        'statut'
    ];

    protected $casts = [
        'statut' => 'boolean',
        'prix' => 'decimal:2',
    ];
}