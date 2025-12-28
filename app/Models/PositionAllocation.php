<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionAllocation extends Model
{
    use HasFactory;

    protected $table = 'position_allocations';

    protected $fillable = [
        'position_id',
        'resident_id'
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
