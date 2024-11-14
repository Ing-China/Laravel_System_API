<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'active',
    ];

    protected $appends = ['image_url'];

    // Accessor for the 'image_url' attribute
    public function getImageUrlAttribute()
    {
        // Assuming 'image' holds the file name or relative path of the image
        return asset("storage/{$this->image}"); // Replace 'storage' with the actual folder where images are stored
    }
}
