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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->string('image')->nullable();
            $table->string('video_url')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('instructor_id');
            $table->enum('level', ['Beginner', 'Intermediate', 'Advanced'])->default('Beginner');
            $table->string('duration')->nullable();
            $table->integer('lessons_count')->default(0);
            $table->integer('students_count')->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('reviews_count')->default(0);
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->boolean('is_free')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_active')->default(true);
            $table->json('tags')->nullable();
            $table->json('requirements')->nullable();
            $table->json('what_you_learn')->nullable();
            $table->timestamps();
            
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('instructor_id')->references('id')->on('instructors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
