<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2'
    ];

    public function appointments()
    {
        return $this->belongsToMany(Appointment::class);
    }
}
