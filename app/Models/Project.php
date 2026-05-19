<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model {
    use HasFactory;
    protected $fillable = [
        'title_en','title_ar','desc_en','desc_ar','stack','bg_gradient',
        'abbr','live_url','code_url','image','sort_order','is_active'
    ];
    protected $casts = ['is_active' => 'boolean', 'stack' => 'array'];
    public function scopeActive($q) { return $q->where('is_active', true)->orderBy('sort_order'); }
}