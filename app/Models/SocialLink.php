<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    protected $table = 'social_links';

    protected $fillable = [
        'label',
        'platform_key',
        'href',
        'whatsapp_number',
        'sort_order',
        'is_active',
        'is_floating',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'is_floating' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public static function platforms(): array
    {
        return [
            'facebook' => [
                'label' => 'Facebook',
                'color' => '#1877F2',
                'category' => 'social',
                'icon' => 'fa-brands fa-facebook-f',
            ],
            'instagram' => [
                'label' => 'Instagram',
                'color' => '#E1306C',
                'category' => 'social',
                'icon' => 'fa-brands fa-instagram',
            ],
            'whatsapp' => [
                'label' => 'WhatsApp',
                'color' => '#25D366',
                'category' => 'social',
                'needs_number' => true,
                'icon' => 'fa-brands fa-whatsapp',
            ],
            'tiktok' => [
                'label' => 'TikTok',
                'color' => '#010101',
                'category' => 'social',
                'icon' => 'fa-brands fa-tiktok',
            ],
            'twitter_x' => [
                'label' => 'X / Twitter',
                'color' => '#111111',
                'category' => 'social',
                'icon' => 'fa-brands fa-x-twitter',
            ],
            'linkedin' => [
                'label' => 'LinkedIn',
                'color' => '#0A66C2',
                'category' => 'social',
                'icon' => 'fa-brands fa-linkedin-in',
            ],
            'youtube' => [
                'label' => 'YouTube',
                'color' => '#FF0000',
                'category' => 'social',
                'icon' => 'fa-brands fa-youtube',
            ],
            'github' => [
                'label' => 'GitHub',
                'color' => '#24292F',
                'category' => 'dev',
                'icon' => 'fa-brands fa-github',
            ],
            'custom' => [
                'label' => 'Custom',
                'color' => '#64748B',
                'category' => 'other',
                'icon' => 'fa-solid fa-link',
            ],
        ];
    }

    public function getPlatformLabelAttribute(): string
    {
        return static::platforms()[$this->platform_key]['label'] ?? ucfirst((string) $this->platform_key);
    }

    public function getPlatformColorAttribute(): string
    {
        return static::platforms()[$this->platform_key]['color'] ?? '#64748B';
    }

    public function getPlatformIconAttribute(): string
    {
        return static::platforms()[$this->platform_key]['icon'] ?? 'fa-solid fa-link';
    }

    public function getResolvedHrefAttribute(): string
    {
        if ($this->platform_key === 'whatsapp' && $this->whatsapp_number) {
            $num = preg_replace('/\D/', '', $this->whatsapp_number);
            return "https://wa.me/{$num}";
        }

        return $this->href ?: '#';
    }
}