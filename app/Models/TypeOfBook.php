<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfBook extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'active',
    ];
}
