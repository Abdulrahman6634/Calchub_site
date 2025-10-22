<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('loan_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('calculation_name')->nullable();
            $table->decimal('loan_amount', 12, 2);
            $table->decimal('interest_rate', 5, 2);
            $table->integer('loan_term'); // in months
            $table->string('term_type'); // months, years
            $table->string('payment_frequency'); // monthly, bi-weekly, weekly
            $table->decimal('monthly_payment', 10, 2);
            $table->decimal('total_interest', 12, 2);
            $table->decimal('total_payment', 12, 2);
            $table->json('amortization_schedule')->nullable();
            $table->json('calculation_details')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('loan_calculations');
    }
};