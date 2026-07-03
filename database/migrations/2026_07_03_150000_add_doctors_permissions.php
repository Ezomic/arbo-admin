<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Additive, not an edit to the original seeding migration — real
     * roles already reference the existing case-officers/employers/admin
     * permissions by this point, so this just adds the doctors portal's
     * tree alongside them rather than risking that data.
     */
    public function up(): void
    {
        $now = now();
        $categoryId = (string) Str::uuid();

        DB::table('permissions')->insert([
            'id' => $categoryId,
            'parent_id' => null,
            'app_slug' => 'doctors',
            'name' => 'Medical Cases',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        foreach (['View medical cases', 'Manage medical cases', 'Close medical cases'] as $name) {
            DB::table('permissions')->insert([
                'id' => (string) Str::uuid(),
                'parent_id' => $categoryId,
                'app_slug' => 'doctors',
                'name' => $name,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('permissions')->where('app_slug', 'doctors')->delete();
    }
};
