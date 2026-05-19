<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HeroContent extends Model {
    protected $table = 'hero_content';
    protected $fillable = [
        'badge_en','badge_ar','line1_en','line1_ar','line2_en','line2_ar',
        'line3_en','line3_ar','desc_en','desc_ar','cta1_en','cta1_ar',
        'cta2_en','cta2_ar','scroll_en','scroll_ar'
    ];

    public static function current(): self {
        return static::firstOrCreate([], [
            'badge_en' => 'Software Engineering Studio · Rotterdam',
            'badge_ar' => 'استوديو هندسة البرمجيات · روتردام',
            'line1_en' => 'We Build', 'line1_ar' => 'نبني',
            'line2_en' => 'Software That', 'line2_ar' => 'برمجيات',
            'line3_en' => 'Matters', 'line3_ar' => 'تصنع الفارق',
            'desc_en'  => 'JILJAM is a precision-focused software studio.',
            'desc_ar'  => 'JILJAM استوديو برمجيات متخصص.',
            'cta1_en'  => 'View Our Work', 'cta1_ar' => 'استعرض أعمالنا',
            'cta2_en'  => 'Get In Touch',  'cta2_ar' => 'تواصل معنا',
            'scroll_en'=> 'Scroll', 'scroll_ar' => 'للأسفل',
        ]);
    }
}