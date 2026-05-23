<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('election_periods', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->smallInteger('year')->unique();
            $table->json('theme_config');
            $table->timestamp('reg_start_at');
            $table->timestamp('reg_end_at');
            $table->timestamp('vote_start_at');
            $table->timestamp('vote_end_at');
            $table->enum('status', ['DRAFT', 'VOTING', 'DONE'])
                ->default('DRAFT')
                ->index();
            $table->foreignUuid('created_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->timestamps();
        });

        if (in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            DB::statement('ALTER TABLE election_periods ADD CONSTRAINT chk_periods_reg_window CHECK (reg_end_at > reg_start_at)');
            DB::statement('ALTER TABLE election_periods ADD CONSTRAINT chk_periods_vote_window CHECK (vote_end_at > vote_start_at)');
            DB::statement('ALTER TABLE election_periods ADD CONSTRAINT chk_periods_reg_before_vote CHECK (vote_start_at >= reg_end_at)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('election_periods');
    }
};
