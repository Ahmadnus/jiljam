<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contact_content', function (Blueprint $table) {
            $table->id();
            $table->string('badge_en')->default('Get In Touch');
            $table->string('badge_ar')->default('تواصل معنا');
            $table->string('heading_en');
            $table->string('heading_ar');
            $table->text('desc_en');
            $table->text('desc_ar');
            $table->string('cta_en')->default('Send Us A Message');
            $table->string('cta_ar')->default('راسلنا الآن');
            $table->string('cta_email');
            $table->timestamps();
        });

        Schema::create('contact_items', function (Blueprint $table) {
            $table->id();
            $table->string('label_en');
            $table->string('label_ar');
            $table->string('value_en');
            $table->string('value_ar');
            $table->string('color')->default('#3b82f6');
            $table->text('icon_path')->nullable();
            $table->text('icon_path2')->nullable();
            $table->boolean('icon_circle')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('href');
            $table->text('icon_svg')->nullable();               // SVG path d string
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('contact_items');
        Schema::dropIfExists('contact_content');
    }
};