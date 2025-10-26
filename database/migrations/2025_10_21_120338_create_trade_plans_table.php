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
        Schema::create('trade_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('trading_pair'); // e.g., 'EUR/USD', 'BTC/USD'
            $table->enum('status', ['draft', 'active', 'completed', 'cancelled', 'expired'])->default('draft');
            $table->decimal('entry_price', 15, 8)->nullable();
            $table->decimal('exit_price', 15, 8)->nullable();
            $table->decimal('stop_loss', 15, 8)->nullable();
            $table->decimal('take_profit', 15, 8)->nullable();
            $table->enum('trade_type', ['long', 'short'])->nullable();
            $table->decimal('position_size', 15, 8)->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('planned_entry_time')->nullable();
            $table->timestamp('planned_exit_time')->nullable();
            $table->timestamp('actual_entry_time')->nullable();
            $table->timestamp('actual_exit_time')->nullable();
            $table->decimal('risk_reward_ratio', 8, 4)->nullable();
            $table->decimal('risk_percentage', 5, 2)->nullable();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['user_id', 'status']);
            $table->index(['status']);
            $table->index(['trading_pair']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_plans');
    }
};
