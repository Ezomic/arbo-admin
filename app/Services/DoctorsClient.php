<?php

namespace App\Services;

use RobbinThijssen\IdentitySsoKit\Api\InternalApiClient;

class DoctorsClient extends InternalApiClient
{
    protected function baseUrl(): string
    {
        return config('services.doctors.base_url');
    }

    protected function token(): string
    {
        return config('services.doctors.token');
    }

    public function getAuditLogs(string $tenantId, int $page = 1, int $perPage = 50): array
    {
        return $this->get('audit-logs', [
            'tenant_id' => $tenantId,
            'per_page' => $perPage,
            'page' => $page,
        ]);
    }
}
