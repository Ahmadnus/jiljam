<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_items', function (Blueprint $table) {
            $table->string('icon_key')->nullable()->after('value_ar');
        });
    }

    public function down(): void
    {
        Schema::table('contact_items', function (Blueprint $table) {
            $table->dropColumn('icon_key');
        });
    }
};