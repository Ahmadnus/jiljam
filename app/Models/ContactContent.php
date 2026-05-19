<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactContent extends Model
{
    protected $table = 'contact_content';

    protected $fillable = [
        'badge_en',
        'badge_ar',
        'heading_en',
        'heading_ar',
        'desc_en',
        'desc_ar',
        'cta_en',
        'cta_ar',
        'cta_email',
    ];

    public static function current(): self
    {
        return static::firstOrCreate([], [
            'badge_en' => 'Get In Touch',
            'badge_ar' => 'تواصل معنا',
            'heading_en' => "Let's build something great",
            'heading_ar' => 'لنبنِ شيئاً رائعاً معاً',
            'desc_en' => "Have a project in mind? We'd love to hear from you.",
            'desc_ar' => 'هل لديك مشروع في ذهنك؟ يسعدنا الاستماع إليك.',
            'cta_en' => 'Send Us A Message',
            'cta_ar' => 'راسلنا الآن',
            'cta_email' => 'hello@jiljam.com',
        ]);
    }
}