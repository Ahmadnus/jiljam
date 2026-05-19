<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TechnologyRing extends Model {
    protected $fillable = [
        'ring_number','color','duration_seconds','direction','radius_px','sort_order','is_active'
    ];
    protected $casts = ['is_active' => 'boolean'];

    public function technologies(): HasMany {
        return $this->hasMany(Technology::class, 'ring_id')->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeActive($q) { return $q->where('is_active', true)->orderBy('sort_order'); }
}