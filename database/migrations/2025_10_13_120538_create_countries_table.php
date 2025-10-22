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
        Schema::create('countries', function (Blueprint $table) {
            $table->id(); // Primary key AUTO_INCREMENT

            $table->string('countryName', 100);
            $table->string('currency', 110);
            $table->string('symbol', 200);
            $table->string('dateFormat', 100)->nullable();
            $table->char('iso_code', 11);
            $table->string('capital', 111)->nullable();
            $table->string('timezone', 200)->nullable();
            $table->string('language', 200)->nullable();
            $table->string('language_code', 100)->nullable();
            $table->string('continent', 100)->nullable();
            $table->char('continent_code', 200)->nullable();
            $table->string('flag_emoji', 100)->nullable();
            $table->string('flag_unicode', 200)->nullable();
            $table->string('flag_img', 255)->nullable();
            $table->string('phone_code', 200)->nullable();
            $table->text('borders')->nullable();

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
