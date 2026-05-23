<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('category_id')
                ->constrained('election_categories')
                ->cascadeOnDelete();
            $table->smallInteger('number');
            $table->text('vision');
            $table->text('mission');
            $table->text('photo_url')->nullable();
            $table->text('video_url')->nullable();
            $table->timestamps();

            $table->unique(['category_id', 'number'], 'uq_candidates_number_per_category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
