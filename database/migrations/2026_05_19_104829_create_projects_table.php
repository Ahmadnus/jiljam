<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_ar');
            $table->text('desc_en');
            $table->text('desc_ar');
            $table->json('stack');                      // ["Laravel","Vue","Tailwind"]
            $table->string('bg_gradient');              // CSS gradient string
            $table->string('abbr');                     // "NC"
            $table->string('live_url')->nullable();
            $table->string('code_url')->nullable();
            $table->string('image')->nullable();        // optional cover image
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('projects'); }
};