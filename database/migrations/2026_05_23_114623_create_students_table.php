<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('faculty_id')
                ->constrained('faculties')
                ->cascadeOnDelete();
            $table->string('nim', 20)->unique();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->text('password');
            $table->boolean('is_eligible')->default(true)->index();
            $table->smallInteger('enrollment_year');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
