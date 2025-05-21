<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    /** @use HasFactory<\Database\Factories\MovieFactory> */
    // use HasFactory;
    protected $fillable = [
    'title', 'slug', 'synopsis', 'year', 'actors', 'cover_image', 'category_id'
];

public function category()
{
    return $this->belongsTo(Category::class);
}


}
