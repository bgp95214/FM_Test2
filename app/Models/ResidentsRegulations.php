<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidentsRegulations extends Model
{
    use HasFactory;

    protected $table = 'residentsregulations';
    protected $fillable = ['content'];
}
