<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use RobbinThijssen\IdentitySsoKit\Concerns\HasTenantScope;
use RobbinThijssen\IdentitySsoKit\Concerns\HasUuidPrimaryKey;

#[Fillable(['tenant_id', 'name', 'description', 'is_active'])]
class TaskType extends Model
{
    use HasTenantScope, HasUuidPrimaryKey;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * @return HasMany<TaskTypeCondition, $this>
     */
    public function conditions(): HasMany
    {
        return $this->hasMany(TaskTypeCondition::class);
    }
}
