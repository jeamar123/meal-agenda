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
        Schema::create('meals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->date('date');
            $table->string('name');
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack']);
            $table->time('time')->nullable();
            $table->uuid('assigned_to_id')->nullable();
            $table->text('notes')->nullable();
            $table->integer('calories')->nullable();
            $table->timestamps();

            // Composite index for fast queries by user and date
            $table->index(['user_id', 'date']);
            $table->index('meal_type');
            $table->index('assigned_to_id');

            // Foreign keys
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('assigned_to_id')
                  ->references('id')
                  ->on('household_members')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};
