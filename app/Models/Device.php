<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Device extends Model
{
    use HasFactory;

    protected $table = 'devices';

    protected $fillable = [
        'name',
        'content',
        'purchase_date',
        'warranty_end',
        'status',
        'vendor_id',
        'asset_id',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'warranty_end' => 'integer',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function assets()
    {
        return $this->belongsTo(Assets::class, 'asset_id');
    }
}
