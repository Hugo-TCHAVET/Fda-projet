<?php

namespace App\Models;

use App\Models\Brache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Demande extends Model
{
    use HasFactory;

    protected $guarded =[];

    
    public function branche(){
        return $this->belongsTo(Brache::class);
    }
}