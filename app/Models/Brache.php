<?php

namespace App\Models;

use App\Models\Corp;
use App\Models\Demande;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brache extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function corps()
    {
        return $this->hasMany(Corp::class);
    }

    public function metiers()
    {
        return $this->hasMany(Metier::class);
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
}