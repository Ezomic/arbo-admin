<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use RobbinThijssen\IdentitySsoKit\Concerns\HasUuidPrimaryKey;

/**
 * The permission catalog is a fixed tree defined by the platform (seeded
 * in a migration), not tenant-owned data — no HasTenantScope here. What's
 * tenant-configurable is which of these each Role grants.
 */
#[Fillable(['parent_id', 'app_slug', 'name'])]
class Permission extends Model
{
    use HasUuidPrimaryKey;

    /**
     * @return BelongsTo<Permission, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'parent_id');
    }

    /**
     * @return HasMany<Permission, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(Permission::class, 'parent_id');
    }
}
