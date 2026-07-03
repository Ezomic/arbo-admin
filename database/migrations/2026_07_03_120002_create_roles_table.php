<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tenant-defined roles, distinct from Identity's per-app_slug `roles`
     * table (which just maps a user_type to one fixed portal role for the
     * SSO JWT). These are the finer-grained, tenant-configurable roles a
     * tenant builds by picking permissions — a separate concept even
     * though the name overlaps.
     *
     * Each role belongs to exactly one portal (`app_slug`), same as its
     * permissions — a role's permissions all come from one portal's tree,
     * so the role itself is scoped there too rather than spanning portals.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->string('app_slug');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('tenant_id');
            $table->index('app_slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
