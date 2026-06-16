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
        Schema::create('macro_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('weight_kg', 5, 2);
            $table->decimal('height_cm', 5, 2);
            $table->unsignedTinyInteger('age');
            $table->enum('sex', ['male', 'female']);
            $table->enum('activity_level', ['sedentary', 'light', 'moderate', 'active', 'very_active']);
            $table->enum('goal', ['lose', 'maintain', 'gain']);
            $table->string('preset')->nullable();
            $table->unsignedSmallInteger('daily_calories');
            $table->decimal('protein_g', 6, 2);
            $table->decimal('carbs_g', 6, 2);
            $table->decimal('fat_g', 6, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('macro_targets');
    }
};
