<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hero_content', function (Blueprint $table) {
            $table->id();
            $table->string('badge_en');
            $table->string('badge_ar');
            $table->string('line1_en');
            $table->string('line1_ar');
            $table->string('line2_en');
            $table->string('line2_ar');
            $table->string('line3_en');
            $table->string('line3_ar');
            $table->text('desc_en');
            $table->text('desc_ar');
            $table->string('cta1_en');
            $table->string('cta1_ar');
            $table->string('cta2_en');
            $table->string('cta2_ar');
            $table->string('scroll_en')->default('Scroll');
            $table->string('scroll_ar')->default('للأسفل');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('hero_content'); }
};