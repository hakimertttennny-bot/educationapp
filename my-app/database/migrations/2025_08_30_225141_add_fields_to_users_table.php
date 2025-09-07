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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('password');
            $table->string('avatar')->nullable()->after('phone');
            $table->enum('role', ['student', 'instructor', 'admin'])->default('student')->after('avatar');
            $table->text('bio')->nullable()->after('role');
            $table->string('website')->nullable()->after('bio');
            $table->string('linkedin')->nullable()->after('website');
            $table->string('twitter')->nullable()->after('linkedin');
            $table->boolean('is_active')->default(true)->after('twitter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'avatar', 'role', 'bio', 'website', 'linkedin', 'twitter', 'is_active'
            ]);
        });
    }
};
