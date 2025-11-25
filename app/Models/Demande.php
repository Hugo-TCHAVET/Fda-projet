<?php

namespace App\Models;

use App\Models\Brache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Demande extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'date_transmission' => 'datetime',
        'date_depot_rapport' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function branche()
    {
        return $this->belongsTo(Brache::class);
    }

    public function localisations()
    {
        return $this->hasMany(DemandeLocalisation::class);
    }
}
