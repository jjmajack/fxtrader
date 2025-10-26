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
        Schema::create('trading_pairs', function (Blueprint $table) {
            $table->id();
            $table->string('symbol')->unique(); // e.g., 'EUR/USD', 'US30', 'BTC/USD'
            $table->string('name'); // e.g., 'Euro/US Dollar', 'Dow Jones', 'Bitcoin/US Dollar'
            $table->string('category'); // e.g., 'forex', 'stock_indices', 'cryptocurrency', 'commodities'
            $table->string('subcategory')->nullable(); // e.g., 'major_forex', 'minor_forex', 'crypto'
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['category', 'is_active']);
            $table->index(['is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trading_pairs');
    }
};
