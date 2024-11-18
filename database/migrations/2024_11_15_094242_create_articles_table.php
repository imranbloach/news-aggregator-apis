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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('url')->unique()->nullable(); // Unique to avoid duplicates
            $table->string('source_name')->nullable(); // e.g., "NewsAPI", "The Guardian", "New York Times"
            $table->string('section_name')->nullable(); // e.g., "Sports", "Politics"
            $table->dateTime('published_at')->nullable();

            // Optional relationships
            $table->unsignedBigInteger('author_id')->nullable()->constrained('authors')->cascadeOnDelete();
            $table->unsignedBigInteger('category_id')->nullable()->constrained('categories')->cascadeOnDelete();
            $table->unsignedBigInteger('source_id')->nullable()->constrained('sources')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
