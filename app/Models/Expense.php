<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'category', 'amount', 'description', 'entry_date', 'reference'
    ];

    protected $casts = [
        'entry_date' => 'date',
    ];
}
