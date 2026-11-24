<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caisse extends Model
{
    protected $fillable = ['date', 'designation', 'categorie', 'type', 'montant'];

    protected $casts = ['date' => 'date'];
}