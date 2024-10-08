<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'age',
        'dob',
        'email',
        'creation_date',
    ];

    protected $casts = [
        'dob'           => 'date',
        'creation_date' => 'datetime',
    ];
}
