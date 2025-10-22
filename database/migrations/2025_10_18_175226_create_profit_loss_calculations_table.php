<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profit_loss_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('calculation_name');
            $table->decimal('revenue', 15, 2)->default(0);
            $table->decimal('cogs', 15, 2)->default(0); // Cost of Goods Sold
            $table->decimal('operating_expenses', 15, 2)->default(0);
            $table->decimal('other_income', 15, 2)->default(0);
            $table->decimal('other_expenses', 15, 2)->default(0);
            $table->decimal('gross_profit', 15, 2)->default(0);
            $table->decimal('operating_profit', 15, 2)->default(0);
            $table->decimal('net_profit', 15, 2)->default(0);
            $table->decimal('profit_margin', 8, 2)->default(0);
            $table->text('formula_used');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profit_loss_calculations');
    }
};