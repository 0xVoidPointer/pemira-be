<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('actor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('event_type', 100)->index();
            $table->string('entity_type', 50)->nullable();
            $table->uuid('entity_id')->nullable();
            $table->json('meta')->nullable();
            $table->string('ip_address', 20);
            $table->timestamp('created_at')->useCurrent();

            $table->index(['entity_type', 'entity_id'], 'idx_audit_entity');
            $table->index('created_at', 'idx_audit_created');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
