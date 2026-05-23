<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidate_members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('candidate_id')
                ->constrained('candidates')
                ->cascadeOnDelete();
            $table->foreignUuid('student_id')
                ->constrained('students')
                ->restrictOnDelete();
            $table->enum('role', ['INDIVIDUAL', 'KETUA', 'WAKIL']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidate_members');
    }
};
