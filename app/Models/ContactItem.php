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
    'icon_key',
    'icon_path',
    'color',
    'sort_order',
    'is_active',
];
    protected $casts = [
        'is_active'   => 'boolean',
        'icon_circle' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Icon definitions used across admin UI and frontend rendering.
     * Each entry: key => [label, color, svg_path (inline fill path for viewBox 0 0 24 24)]
     */
    public static function iconOptions(): array
    {
        return [
            // ── Contact ──────────────────────────────────────────────────
            'email'       => ['label' => 'Email',         'color' => '#3B82F6',
                'path' => 'M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z'],
            'phone'       => ['label' => 'Phone',         'color' => '#10B981',
                'path' => 'M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 00-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z'],
            'map'         => ['label' => 'Location / Map','color' => '#EF4444',
                'path' => 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z'],
            'clock'       => ['label' => 'Clock / Hours', 'color' => '#F59E0B',
                'path' => 'M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z'],
            'globe'       => ['label' => 'Globe / Website','color' => '#14B8A6',
                'path' => 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z'],
            'link'        => ['label' => 'Link',          'color' => '#8B5CF6',
                'path' => 'M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1 0 1.71-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z'],
            // ── Business ─────────────────────────────────────────────────
            'building'    => ['label' => 'Office / HQ',  'color' => '#64748B',
                'path' => 'M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z'],
            'calendar'    => ['label' => 'Calendar',     'color' => '#06B6D4',
                'path' => 'M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z'],
            'support'     => ['label' => 'Support',      'color' => '#EC4899',
                'path' => 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z'],
        ];
    }

    /**
     * Get the SVG path string for a given icon_key.
     */
    public static function pathFor(string $key): string
    {
        return static::iconOptions()[$key]['path'] ?? static::iconOptions()['email']['path'];
    }

    /**
     * Get the color for a given icon_key.
     */
    public static function colorFor(string $key): string
    {
        return static::iconOptions()[$key]['color'] ?? '#3B82F6';
    }
}