<?php

namespace App\Models;

use App\Models\Brache;
use App\Models\Metier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Corp extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function brache()
    {
        return $this->belongsTo(Brache::class, 'branche_id');
    }

    public function metiers()
    {
        return $this->hasMany(Metier::class);
    }
}
