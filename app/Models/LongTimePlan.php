<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LongTimePlan extends Model
{
    use HasFactory;

    protected $table = 'longtimeplan';
    protected $fillable = ['content'];
}
