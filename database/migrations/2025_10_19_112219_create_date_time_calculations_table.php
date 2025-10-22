<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('date_time_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('calculation_name');
            $table->string('calculation_type'); // difference, add, subtract, business_days
            $table->json('inputs'); // Store all input values
            $table->json('results'); // Store all calculated results
            $table->text('formula_used');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('date_time_calculations');
    }
};