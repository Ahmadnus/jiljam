<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactItem extends Model
{
    protected $table = 'contact_items';

    protected $fillable = [
        'label_en',
        'label_ar',
        'value_en',
        'value_ar',
        'color',
        'icon_path',
        'icon_path2',
        'icon_circle',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'icon_circle' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}