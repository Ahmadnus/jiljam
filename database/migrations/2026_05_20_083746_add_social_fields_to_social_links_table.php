<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('social_links', function (Blueprint $table) {

            $table->string('platform_key')->nullable()->after('id');

            $table->string('whatsapp_number')
                  ->nullable()
                  ->after('href');

            $table->boolean('is_floating')
                  ->default(false)
                  ->after('whatsapp_number');

         
          
        });
    }

    public function down(): void
    {
        Schema::table('social_links', function (Blueprint $table) {

            $table->dropColumn([
                'platform_key',
                'whatsapp_number',
                'is_floating',
                'is_active',
                'sort_order',
            ]);
        });
    }
};