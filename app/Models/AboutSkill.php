<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSkill extends Model
{
    protected $table = 'about_skills';

    protected $fillable = [
        'name_en',
        'name_ar',
        'percentage',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}