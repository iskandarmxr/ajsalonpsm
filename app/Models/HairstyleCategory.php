<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HairstyleCategory extends Model
{
    protected $fillable = ['name', 'description'];

    public function hairstyles()
    {
        return $this->hasMany(Hairstyle::class, 'category_id');
    }
}