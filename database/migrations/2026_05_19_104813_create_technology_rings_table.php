<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('technology_rings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('ring_number');    // 1, 2, 3
            $table->string('color')->default('rgba(100,160,255,0.18)');
            $table->unsignedInteger('duration_seconds')->default(22); // animation speed
            $table->enum('direction', ['cw', 'ccw'])->default('cw');
            $table->unsignedInteger('radius_px')->default(230);       // base radius at 1x scale
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('technologies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ring_id')->constrained('technology_rings')->onDelete('cascade');
            $table->string('name');
            $table->string('icon');                     // emoji or short string
            $table->string('icon_type')->default('emoji'); // emoji | image | svg
            $table->string('icon_image')->nullable();   // uploaded file path
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('technologies');
        Schema::dropIfExists('technology_rings');
    }
};