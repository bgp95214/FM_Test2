<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessSpecifications extends Model
{
    use HasFactory;

    protected $table = 'processspecifications';

    protected $fillable = ['content'];
}
