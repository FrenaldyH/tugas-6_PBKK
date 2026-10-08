<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Create the profiles table: academic biodata, one row per user.
     * Kept apart from users so that table only holds login credentials.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            // unique() turns the relation into one-to-one: a user can own at most one profile.
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('nrp', 10)->unique();
            $table->string('departemen', 100)->default('Teknik Informatika');
            $table->unsignedSmallInteger('angkatan');
            $table->text('bio')->nullable();
            $table->string('github')->nullable();
            $table->string('linkedin')->nullable();
            // List of skills, e.g. ["PHP", "Laravel"]; cast to an array by the model.
            $table->json('keahlian')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Drop the profiles table.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
