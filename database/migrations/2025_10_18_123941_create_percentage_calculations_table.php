<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('percentage_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('calculation_name');
            $table->string('calculation_type'); // basic, increase, decrease, percentage_of, find_number
            $table->json('inputs'); // Store all input values as JSON
            $table->decimal('result', 10, 2);
            $table->text('formula_used');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('percentage_calculations');
    }
};