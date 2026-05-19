<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model {
    use HasFactory;
    protected $fillable = [
        'number_display','title_en','title_ar','desc_en','desc_ar',
        'color','icon_path','icon_path2','icon_circle','icon_rect','sort_order','is_active'
    ];
    protected $casts = ['is_active' => 'boolean', 'icon_circle' => 'boolean', 'icon_rect' => 'array'];
    public function scopeActive($q) { return $q->where('is_active', true)->orderBy('sort_order'); }
}