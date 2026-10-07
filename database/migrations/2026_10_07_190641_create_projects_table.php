<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Create the projects table that stores Agentic AI proposal ideas.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            // Owner of the idea; deleting the user deletes their projects too.
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('judul', 150);
            $table->text('deskripsi')->nullable();
            $table->string('tema_agent', 50)->default('Ollama');
            // TEXT, not VARCHAR: the value is stored encrypted, which is much longer than the raw key.
            $table->text('api_key_secure');
            $table->timestamps();
        });
    }

    /**
     * Drop the projects table.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
