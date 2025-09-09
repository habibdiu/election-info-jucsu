<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MemberCandidate extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id','id');
    }

    public function election_area()
    {
        return $this->belongsTo(ElectionArea::class, 'election_area_id','id');
    }

}
