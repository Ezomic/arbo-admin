<?php

namespace Database\Seeders;

use App\Models\ApiClient;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Local dev data (tenant/contract types) is created via the SSO login
     * flow and manual testing, not seeded here — the tenant itself must
     * already exist (i.e. someone has logged into Admin at least once)
     * before the demo roles below can be attached to it. This seeder only
     * provisions the machine-to-machine token Case Officers needs to call
     * this app's internal API, plus a handful of example roles per portal.
     */
    public function run(): void
    {
        $client = ApiClient::query()->firstOrCreate(['name' => 'case-officers-service']);

        $token = $client->createToken('case-officers-service', ['contract-types:read'])->plainTextToken;

        $this->command?->info("case-officers-service token (put in case-officers/.env as ADMIN_SERVICE_TOKEN):\n{$token}");

        $this->seedDemoRoles();
    }

    private function seedDemoRoles(): void
    {
        $tenant = Tenant::query()->first();

        if ($tenant === null) {
            $this->command?->warn('No tenant synced yet (log into Admin once first) — skipping demo role seeding.');

            return;
        }

        $roles = [
            'case-officers' => [
                'Case Officer' => ['View employers', 'View contracts', 'View employees', 'View cases', 'Manage cases'],
                'Senior Case Officer' => ['View employers', 'Manage employers', 'View contracts', 'Manage contracts', 'View employees', 'Manage employees', 'View cases', 'Manage cases', 'Close cases'],
                'Read-only Auditor' => ['View employers', 'View contracts', 'View employees', 'View cases'],
            ],
            'employers' => [
                'Employer Contact' => ['View employees'],
                'Employer Admin' => ['View employees', 'Manage employees'],
            ],
            'doctors' => [
                'Doctor' => ['View medical cases', 'Manage medical cases'],
                'Senior Doctor' => ['View medical cases', 'Manage medical cases', 'Close medical cases'],
            ],
            'admin' => [
                'Tenant Administrator' => ['Manage contract types', 'Manage task types', 'Manage roles'],
                'Configuration Manager' => ['Manage contract types', 'Manage task types'],
            ],
        ];

        foreach ($roles as $appSlug => $roleDefinitions) {
            $permissionIds = Permission::query()
                ->where('app_slug', $appSlug)
                ->pluck('id', 'name');

            foreach ($roleDefinitions as $name => $permissionNames) {
                $role = Role::query()->updateOrCreate(
                    ['tenant_id' => $tenant->id, 'app_slug' => $appSlug, 'name' => $name],
                );

                $role->permissions()->sync(
                    collect($permissionNames)->map(fn (string $permissionName) => $permissionIds[$permissionName]),
                );
            }
        }

        $this->command?->info('Seeded demo roles for case-officers, employers, doctors, and admin.');
    }
}
