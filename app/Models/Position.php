<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory;
    protected $guarded =[];
    
    public function election_area(){
    return $this->belongsTo(ElectionArea::class, 'election_area_id', 'id');
    }
}
