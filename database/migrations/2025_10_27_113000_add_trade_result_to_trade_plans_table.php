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
        Schema::table('trade_plans', function (Blueprint $table) {
            $table->enum('trade_result', ['profit', 'loss', 'breakeven', 'pending'])->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trade_plans', function (Blueprint $table) {
            $table->dropColumn('trade_result');
        });
    }
};
