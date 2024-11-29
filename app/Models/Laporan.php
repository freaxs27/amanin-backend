<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'image',
        'latitude',
        'longitude',
        'datetime',
        'status',
    ];

    // Model Laporan.php
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
