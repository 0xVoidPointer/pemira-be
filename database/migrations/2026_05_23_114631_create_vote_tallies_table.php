<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vote_tallies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('candidate_id')
                ->unique()
                ->constrained('candidates')
                ->cascadeOnDelete();
            $table->integer('vote_count')->default(0);
            $table->timestamp('last_updated')->useCurrent();
        });

        if (in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            DB::statement('ALTER TABLE vote_tallies ADD CONSTRAINT chk_tallies_vote_count CHECK (vote_count >= 0)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('vote_tallies');
    }
};
