<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialsPlan extends Model
{
    use HasFactory;

    protected $table = 'materialsplan';
    protected $fillable = ['content'];
}
