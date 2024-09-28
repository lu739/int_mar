<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('text')->nullable();
            if (app()->environment() !== 'testing') {
                $table->fullText(['title', 'text']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!app()->isProduction()) {
            Schema::table('products', function (Blueprint $table) {
                if (app()->environment() !== 'testing') {
                    $table->dropFullText(['title', 'text']);
                }
                $table->dropColumn('text');
            });
        }
    }
};
