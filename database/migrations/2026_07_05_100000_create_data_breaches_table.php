<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_breaches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->uuid('reported_by_user_id')->nullable();
            $table->timestamp('discovered_at');
            $table->text('description');
            $table->json('data_categories');
            $table->integer('individuals_affected')->nullable();
            $table->text('measures_taken')->nullable();
            $table->string('status')->default('open');
            $table->timestamp('authority_notified_at')->nullable();
            $table->timestamps();

            $table->index('tenant_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_breaches');
    }
};
