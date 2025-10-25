<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password_reset_token')->nullable();
            $table->timestamp('password_reset_token_expires_at')->nullable();
            $table->timestamp('password_reset_email_sent_at')->nullable();
            $table->integer('password_reset_attempts')->default(0);
            $table->timestamp('password_reset_locked_until')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'password_reset_token',
                'password_reset_token_expires_at',
                'password_reset_email_sent_at',
                'password_reset_attempts',
                'password_reset_locked_until'
            ]);
        });
    }
};