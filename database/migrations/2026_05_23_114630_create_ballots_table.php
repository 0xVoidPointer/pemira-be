<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ballots', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('category_id')
                ->constrained('election_categories')
                ->restrictOnDelete();
            $table->foreignUuid('student_id')
                ->constrained('students')
                ->restrictOnDelete();
            $table->timestamp('voted_at')->useCurrent()->index();
            $table->string('ip_address', 20)->nullable();
            $table->text('user_agent')->nullable();

            $table->unique(['category_id', 'student_id'], 'uq_ballots_one_vote_per_student_per_race');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ballots');
    }
};
