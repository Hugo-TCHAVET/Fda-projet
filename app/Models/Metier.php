<?php

namespace App\Models;

use App\Models\Corp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Metier extends Model
{
        use HasFactory;
        protected $guarded = [];

        public function corps()
        {
                return $this->belongsTo(Corp::class, 'corp_id');
        }

        public function brache()
        {
                return $this->belongsTo(Brache::class, 'branche_id');
        }
}
