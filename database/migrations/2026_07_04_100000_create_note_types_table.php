<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('note_types', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->string('app_slug');
            $table->string('name');
            $table->timestamps();

            $table->index(['tenant_id', 'app_slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('note_types');
    }
};
