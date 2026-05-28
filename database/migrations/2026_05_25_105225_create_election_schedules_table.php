<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('election_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('period_id')
                ->constrained('election_periods')
                ->cascadeOnDelete();
            $table->foreignUuid('scope_faculty_id')
                ->constrained('faculties')
                ->restrictOnDelete();
            $table->timestamp('vote_start_at');
            $table->timestamp('vote_end_at');
            $table->timestamps();
        });

        if (in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            DB::statement('ALTER TABLE election_schedules ADD CONSTRAINT chk_schedules_vote_window CHECK (vote_end_at > vote_start_at)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('election_schedules');
    }
};
