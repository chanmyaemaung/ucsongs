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
        Schema::create('ebooks', function (Blueprint $table) {
            $table->id();
            $table->string('book_file')->nullable();
            $table->string('title');
            $table->enum('book_type', ['epub', 'kindle', 'pdf', 'mobi']);
            $table->string('author');
            $table->string('publication_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['title', 'author']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebooks');
    }
};
