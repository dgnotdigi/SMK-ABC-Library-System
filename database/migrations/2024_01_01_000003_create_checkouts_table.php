<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->references('id')->on('books');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->timestamp('checked_out_at')->useCurrent();
            $table->timestamp('due_at');
            $table->timestamp('returned_at')->nullable();
            $table->unsignedInteger('fine_cents')->default(0);
            $table->boolean('fine_paid')->default(false);
            $table->timestamps();

            $table->index('user_id');
            $table->index('book_id');
            $table->index(['returned_at', 'due_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};
