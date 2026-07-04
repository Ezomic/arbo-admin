<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContractType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContractTypeApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $tenantId = $request->validate(['tenant_id' => ['required', 'uuid']])['tenant_id'];

        $contractTypes = ContractType::withoutGlobalScope('tenant')
            ->where('tenant_id', $tenantId)
            ->where('is_active', true)
            ->with('caseTypes')
            ->oldest()
            ->get()
            ->map(fn (ContractType $ct) => [
                'id' => $ct->id,
                'tenant_id' => $ct->tenant_id,
                'name' => $ct->name,
                'case_types' => $ct->caseTypes->pluck('case_type')->all(),
            ]);

        return response()->json($contractTypes);
    }
}
