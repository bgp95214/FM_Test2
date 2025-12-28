<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'floor_id',
        'door_number',
        'contact_phone',
        'account',
        'password'
    ];

    protected $hidden = [
        'password',
    ];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }
}
