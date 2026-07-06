<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use RobbinThijssen\IdentitySsoKit\Concerns\HasTenantScope;
use RobbinThijssen\IdentitySsoKit\Concerns\HasUuidPrimaryKey;

#[Fillable(['tenant_id', 'app_slug', 'name'])]
class NoteType extends Model
{
    use HasTenantScope, HasUuidPrimaryKey;

    /**
     * @return HasMany<NoteTypePermission, $this>
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(NoteTypePermission::class);
    }
}
