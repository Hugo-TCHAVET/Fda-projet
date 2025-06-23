<?php

namespace App\Models;

use App\Models\Corp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Metier extends Model
{
    use HasFactory;
    protected $guarded =[];
    
    public function corps()
    {
        return $this->belongTo(Corp::class);
    }
    
    public function brache()
    {
        return $this->belongTo(Brache::class);
    }
}