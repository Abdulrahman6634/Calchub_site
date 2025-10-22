<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cgpa_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('calculation_name');
            $table->string('calculation_type'); // gpa, cgpa
            $table->json('subjects'); // Store subjects with name, credits, grade
            $table->decimal('total_credits', 8, 2);
            $table->decimal('total_grade_points', 8, 2);
            $table->decimal('result', 5, 2); // GPA/CGPA value
            $table->text('formula_used');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cgpa_calculations');
    }
};