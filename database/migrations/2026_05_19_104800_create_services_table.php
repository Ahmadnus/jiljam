<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('number_display');          // "01" or "٠١"
            $table->string('title_en');
            $table->string('title_ar');
            $table->text('desc_en');
            $table->text('desc_ar');
            $table->string('color')->default('#3b82f6');
            $table->text('icon_path');                 // SVG path d attribute
            $table->text('icon_path2')->nullable();
            $table->boolean('icon_circle')->default(false);
            $table->json('icon_rect')->nullable();      // {x,y,w,h,rx}
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('services'); }
};