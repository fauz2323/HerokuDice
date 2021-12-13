<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunTester extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'password',
        'balance',
        'reff',
        'bonus',
    ];
}
