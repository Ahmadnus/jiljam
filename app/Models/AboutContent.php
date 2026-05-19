<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutContent extends Model
{
    protected $table = 'about_content';

    protected $fillable = [
        'badge_en',
        'badge_ar',
        'heading_en',
        'heading_ar',
        'desc_en',
        'desc_ar',
        'skills_title_en',
        'skills_title_ar',
    ];

    public static function current(): self
    {
        return static::firstOrCreate([], [
            'badge_en' => 'Who We Are',
            'badge_ar' => 'من نحن',
            'heading_en' => 'Precision at every layer',
            'heading_ar' => 'الدقة في كل مستوى',
            'desc_en' => 'We are a software studio that combines technical excellence with thoughtful design.',
            'desc_ar' => 'نحن استوديو برمجيات يجمع بين التميز التقني والتصميم المدروس.',
            'skills_title_en' => 'Technical Proficiency',
            'skills_title_ar' => 'الكفاءة التقنية',
        ]);
    }
}