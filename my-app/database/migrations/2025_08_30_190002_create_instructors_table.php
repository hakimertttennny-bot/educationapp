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
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('bio')->nullable();
            $table->string('specialization')->nullable();
            $table->integer('experience_years')->default(0);
            $table->string('website')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
            $table->string('github')->nullable();
            $table->decimal('hourly_rate', 8, 2)->nullable();
            $table->boolean('is_verified')->default(false);
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index(['user_id', 'status']);
            $table->index('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructors');
    }
};
