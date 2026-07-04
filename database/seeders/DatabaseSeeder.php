<?php

namespace Database\Seeders;

use App\Models\ApiClient;
use App\Models\ContractType;
use App\Models\Permission;
use App\Models\Role;
use App\Models\TaskType;
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
        $coClient = ApiClient::query()->firstOrCreate(['name' => 'case-officers-service']);
        $coToken = $coClient->createToken('case-officers-service', ['contract-types:read', 'note-types:read', 'task-types:read', 'role-permissions:read'])->plainTextToken;
        $this->command?->info("case-officers-service token (put in case-officers/.env as ADMIN_SERVICE_TOKEN):\n{$coToken}");

        $this->seedDemoRoles();
        $this->seedTaskTypes();
        $this->seedContractTypes();
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

    private function seedTaskTypes(): void
    {
        $tenant = Tenant::query()->first();

        if ($tenant === null) {
            $this->command?->warn('No tenant synced yet — skipping task type seeding.');

            return;
        }

        $taskTypes = [
            ['name' => 'Telefonisch consult', 'description' => 'Telefonisch contact met werknemer of werkgever over verzuim of herstel'],
            ['name' => 'Spreekuur', 'description' => 'Persoonlijk consult bij de casemanager op kantoor'],
            ['name' => 'Huisbezoek', 'description' => 'Bezoek aan werknemer thuis bij langdurig of complex verzuim'],
            ['name' => 'Werkplekbezoek', 'description' => 'Bezoek aan de werkplek voor inventarisatie van werkomstandigheden'],
            ['name' => 'Terugkeergesprek', 'description' => 'Gesprek ter voorbereiding op of begeleiding van werkhervatting'],
            ['name' => 'Probleemanalyse', 'description' => 'Opstellen van de probleemanalyse conform Wet verbetering poortwachter'],
            ['name' => 'Plan van aanpak', 'description' => 'Opstellen of bijstellen van het re-integratieplan'],
            ['name' => 'Eerstejaarsevaluatie', 'description' => 'Evaluatie van het re-integratietraject na één jaar verzuim'],
            ['name' => 'Medische verwijzing', 'description' => 'Verwijzing naar bedrijfsarts, specialist of andere zorgverlener'],
            ['name' => 'Overleg werkgever', 'description' => 'Afstemming met leidinggevende of HR over re-integratieaanpak'],
            ['name' => 'Deskundigenoordeel aanvragen', 'description' => 'Aanvraag second opinion bij UWV over arbeids(on)geschiktheid'],
            ['name' => 'Administratie', 'description' => 'Verwerken van documenten, rapportages en dossieraantekeningen'],
        ];

        foreach ($taskTypes as $taskType) {
            TaskType::query()->firstOrCreate(
                ['tenant_id' => $tenant->id, 'name' => $taskType['name']],
                ['description' => $taskType['description'], 'is_active' => true],
            );
        }

        $this->command?->info('Seeded '.count($taskTypes).' task types.');
    }

    private function seedContractTypes(): void
    {
        $tenant = Tenant::query()->first();

        if ($tenant === null) {
            $this->command?->warn('No tenant synced yet — skipping contract type seeding.');

            return;
        }

        $contractTypes = [
            ['name' => 'Basis verzuimbegeleiding', 'description' => 'Standaard begeleiding bij ziekmelding conform Wet verbetering poortwachter'],
            ['name' => 'Uitgebreide verzuimbegeleiding', 'description' => 'Intensieve begeleiding inclusief werkplekonderzoek en medische consultatie'],
            ['name' => 'Re-integratie eerste spoor', 'description' => 'Begeleiding bij terugkeer naar eigen of aangepast werk bij huidige werkgever'],
            ['name' => 'Re-integratie tweede spoor', 'description' => 'Begeleiding bij re-integratie naar werk bij een andere werkgever'],
            ['name' => 'Preventiecontract', 'description' => 'Proactieve ondersteuning gericht op het voorkomen van verzuim'],
            ['name' => 'Bedrijfsmaatschappelijk werk', 'description' => 'Psychosociale begeleiding bij werkgerelateerde of privéproblemen'],
            ['name' => 'Arbeidsdeskundig onderzoek', 'description' => 'Beoordeling van arbeidsmogelijkheden en re-integratiekansen'],
            ['name' => 'Medische keuring', 'description' => 'Aanstellingskeuring of periodiek medisch onderzoek'],
            ['name' => 'Risico-inventarisatie & evaluatie', 'description' => 'Beoordeling van arbeidsrisico\'s in de werkomgeving (RI&E)'],
            ['name' => 'Vitaliteitsprogramma', 'description' => 'Programma gericht op duurzame inzetbaarheid en werknemerswelzijn'],
        ];

        foreach ($contractTypes as $contractType) {
            ContractType::query()->firstOrCreate(
                ['tenant_id' => $tenant->id, 'name' => $contractType['name']],
                ['description' => $contractType['description'], 'is_active' => true],
            );
        }

        $this->command?->info('Seeded '.count($contractTypes).' contract types.');
    }
}
