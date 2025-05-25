<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = [
        'name',
        'description',
        'points_required',
        'image_path',
        'active_from',
        'expiry_date',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'active_from' => 'datetime',
        'expiry_date' => 'datetime'
    ];

    public function isAvailable()
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();
        
        if ($this->active_from && $now->lt($this->active_from)) {
            return false;
        }

        if ($this->expiry_date && $now->gt($this->expiry_date)) {
            return false;
        }

        return true;
    }
}