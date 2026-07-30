<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ProjectCategory extends Model {
    use HasFactory;
    protected $fillable = ['name_en','name_ar','slug','sort_order','is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($q) { return $q->where('is_active', true)->orderBy('sort_order'); }

    public function projects()
    {
        return $this->hasMany(Project::class, 'category_id');
    }

    public static function makeSlug(string $nameEn, ?int $ignoreId = null): string
    {
        $base = Str::slug($nameEn) ?: Str::random(6);
        $slug = $base;
        $i = 1;
        while (static::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . (++$i);
        }
        return $slug;
    }
}
