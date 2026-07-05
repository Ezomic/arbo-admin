<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use RobbinThijssen\IdentitySsoKit\Concerns\HasTenantScope;
use RobbinThijssen\IdentitySsoKit\Concerns\HasUuidPrimaryKey;

#[Fillable(['tenant_id', 'reported_by_user_id', 'discovered_at', 'description', 'data_categories', 'individuals_affected', 'measures_taken', 'status', 'authority_notified_at'])]
class DataBreach extends Model
{
    use HasTenantScope, HasUuidPrimaryKey;

    protected function casts(): array
    {
        return [
            'data_categories' => 'array',
            'discovered_at' => 'datetime',
            'authority_notified_at' => 'datetime',
        ];
    }
}
