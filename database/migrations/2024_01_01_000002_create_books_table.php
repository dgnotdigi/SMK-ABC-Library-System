<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('isbn')->nullable();
            $table->string('title');
            $table->string('author');
            $table->string('genre')->nullable();
            $table->string('call_number')->nullable();
            $table->string('publisher')->nullable();
            $table->unsignedSmallInteger('published_year')->nullable();
            $table->text('description')->nullable();
            $table->string('cover_color', 7)->default('#1B3A2E');
            $table->unsignedInteger('total_copies')->default(1);
            $table->unsignedInteger('available_copies')->default(1);
            $table->timestamps();

            $table->index('title');
            $table->index('author');
            $table->index('genre');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
