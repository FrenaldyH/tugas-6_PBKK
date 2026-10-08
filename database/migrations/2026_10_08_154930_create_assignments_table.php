<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Create the assignments table: a student's course assignment history.
     */
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('mata_kuliah', 100)->default('PBKK');
            $table->string('judul', 150);
            $table->text('deskripsi')->nullable();
            $table->string('link_repo')->nullable();
            // Null while the assignment is still in progress.
            $table->date('dikumpulkan_pada')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Drop the assignments table.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
