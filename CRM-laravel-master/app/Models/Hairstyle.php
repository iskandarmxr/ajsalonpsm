<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hairstyle extends Model
{
    protected $fillable = ['name', 'description', 'image', 'category_id'];

    public function category()
    {
        return $this->belongsTo(HairstyleCategory::class, 'category_id');
    }
}