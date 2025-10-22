<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('currency_conversions', function (Blueprint $table) {
            $table->id();
            $table->string('from_currency', 10);
            $table->string('to_currency', 10);
            $table->decimal('amount', 15, 2);
            $table->decimal('converted_amount', 15, 2);
            $table->decimal('rate', 15, 6);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('currency_conversions');
    }
};
