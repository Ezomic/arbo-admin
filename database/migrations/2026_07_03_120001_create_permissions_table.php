<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * The permission catalog itself is a fixed tree defined by the
     * platform (not tenant-editable) — what a tenant configures per Role
     * is which of these it grants, not the tree's shape. Every permission
     * belongs to exactly one portal (`app_slug`) — permissions are scoped
     * per portal, since an action like "close a case" only ever makes
     * sense within Case Officers, never within Employers or Admin. The
     * top-level tree nodes are category labels within a portal (e.g.
     * "Contracts" under case-officers), not the portal itself — the
     * portal is `app_slug`, carried on every node including categories.
     *
     * Self-referencing FK is added in a second step (Postgres won't let a
     * table reference its own not-yet-committed primary key within the
     * same CREATE TABLE statement).
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('parent_id')->nullable();
            $table->string('app_slug');
            $table->string('name');
            $table->timestamps();

            $table->index('app_slug');
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('permissions')->cascadeOnDelete();
        });

        $this->seedTree();
    }

    private function seedTree(): void
    {
        $now = now();

        $tree = [
            'case-officers' => [
                'Employers' => ['View employers', 'Manage employers'],
                'Contracts' => ['View contracts', 'Manage contracts'],
                'Employees' => ['View employees', 'Manage employees'],
                'Cases' => ['View cases', 'Manage cases', 'Close cases'],
            ],
            'employers' => [
                'Employees' => ['View employees', 'Manage employees'],
            ],
            'admin' => [
                'Configuration' => ['Manage contract types', 'Manage task types', 'Manage roles'],
            ],
        ];

        foreach ($tree as $appSlug => $categories) {
            foreach ($categories as $category => $leaves) {
                $categoryId = (string) Str::uuid();

                DB::table('permissions')->insert([
                    'id' => $categoryId,
                    'parent_id' => null,
                    'app_slug' => $appSlug,
                    'name' => $category,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                foreach ($leaves as $name) {
                    DB::table('permissions')->insert([
                        'id' => (string) Str::uuid(),
                        'parent_id' => $categoryId,
                        'app_slug' => $appSlug,
                        'name' => $name,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
