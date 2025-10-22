<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bmi_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('calculation_name')->nullable();
            $table->decimal('height', 8, 2);
            $table->string('height_unit'); // cm, m, ft, in
            $table->decimal('weight', 8, 2);
            $table->string('weight_unit'); // kg, lbs
            $table->decimal('bmi', 8, 2);
            $table->string('category');
            $table->text('health_advice')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender')->nullable(); // male, female, other
            $table->json('measurements')->nullable(); // Additional measurements
            $table->timestamps();
            
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bmi_calculations');
    }
};