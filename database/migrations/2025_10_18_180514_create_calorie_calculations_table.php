<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('calorie_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('calculation_name');
            $table->integer('age');
            $table->string('gender'); // male, female
            $table->decimal('weight', 8, 2); // in kg
            $table->decimal('height', 8, 2); // in cm
            $table->string('activity_level'); // sedentary, light, moderate, active, very_active
            $table->string('goal'); // maintain, lose, gain
            $table->integer('bmr'); // Basal Metabolic Rate
            $table->integer('tdee'); // Total Daily Energy Expenditure
            $table->integer('calorie_target');
            $table->text('formula_used');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('calorie_calculations');
    }
};