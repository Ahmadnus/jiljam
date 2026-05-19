<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('about_content', function (Blueprint $table) {
            $table->id();
            $table->string('badge_en')->default('Who We Are');
            $table->string('badge_ar')->default('من نحن');
            $table->string('heading_en');
            $table->string('heading_ar');
            $table->text('desc_en');
            $table->text('desc_ar');
            $table->string('skills_title_en')->default('Technical Proficiency');
            $table->string('skills_title_ar')->default('الكفاءة التقنية');
            $table->timestamps();
        });

        Schema::create('about_stats', function (Blueprint $table) {
            $table->id();
            $table->string('number');           // "12+"
            $table->string('label_en');
            $table->string('label_ar');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('about_skills', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar');
            $table->unsignedTinyInteger('percentage');   // 0–100
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('about_skills');
        Schema::dropIfExists('about_stats');
        Schema::dropIfExists('about_content');
    }
};