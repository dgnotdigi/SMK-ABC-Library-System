<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('holds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->references('id')->on('books');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->timestamp('requested_at')->useCurrent();
            $table->enum('status', ['waiting', 'ready', 'fulfilled', 'cancelled'])->default('waiting');
            $table->timestamp('notified_at')->nullable();
            $table->timestamps();

            $table->index('book_id');
            $table->index('user_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('holds');
    }
};
