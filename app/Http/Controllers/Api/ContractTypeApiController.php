<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContractType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ContractTypeApiController extends Controller
{
    public function index(Request $request): Collection
    {
        $tenantId = $request->validate(['tenant_id' => ['required', 'uuid']])['tenant_id'];

        return ContractType::withoutGlobalScope('tenant')
            ->where('tenant_id', $tenantId)
            ->where('is_active', true)
            ->oldest()
            ->get();
    }
}
