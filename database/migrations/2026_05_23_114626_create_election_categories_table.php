<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('election_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('period_id')
                ->constrained('election_periods')
                ->cascadeOnDelete();
            $table->foreignUuid('scope_faculty_id')
                ->nullable()
                ->constrained('faculties')
                ->restrictOnDelete();
            $table->enum('type', ['PRESIDENT', 'DPM', 'FACULTY_GOVERNOR']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamp('vote_start_at')->nullable();
            $table->timestamp('vote_end_at')->nullable();
            $table->smallInteger('max_winners')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('election_categories');
    }
};
