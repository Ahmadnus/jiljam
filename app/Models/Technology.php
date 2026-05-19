<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Technology extends Model {
    protected $fillable = ['ring_id','name','icon','icon_type','icon_image','sort_order','is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function ring(): BelongsTo { return $this->belongsTo(TechnologyRing::class, 'ring_id'); }

    public function scopeActive($q) { return $q->where('is_active', true)->orderBy('sort_order'); }

    public function getIconDisplayAttribute(): string {
        if ($this->icon_type === 'image' && $this->icon_image) {
            return '<img src="'.asset('storage/'.$this->icon_image).'" alt="'.$this->name.'" style="width:100%;height:100%;object-fit:contain;border-radius:8px">';
        }
        return $this->icon;
    }
}