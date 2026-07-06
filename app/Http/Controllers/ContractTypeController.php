<?php

namespace App\Http\Controllers;

use App\Enums\CaseType;
use App\Models\ContractType;
use App\Models\ContractTypeCaseType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class ContractTypeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('contract-types/Index', [
            'contractTypes' => ContractType::query()->latest()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        ContractType::query()->create($data);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Contract type created.']);

        return to_route('contract-types.index');
    }

    public function edit(ContractType $contractType): Response
    {
        $enabledTypes = $contractType->caseTypes()->pluck('case_type')->all();

        return Inertia::render('contract-types/Edit', [
            'contractType' => $contractType,
            'caseTypes' => array_map(
                fn (CaseType $t) => ['value' => $t->value, 'label' => $t->label()],
                CaseType::cases(),
            ),
            'enabledCaseTypes' => $enabledTypes,
        ]);
    }

    public function update(Request $request, ContractType $contractType): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'case_types' => ['array'],
            'case_types.*' => [Rule::enum(CaseType::class)],
        ]);

        $contractType->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'is_active' => $data['is_active'] ?? $contractType->is_active,
        ]);

        $contractType->caseTypes()->delete();

        foreach ($data['case_types'] ?? [] as $type) {
            ContractTypeCaseType::query()->create([
                'contract_type_id' => $contractType->id,
                'case_type' => $type,
            ]);
        }

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Contract type updated.']);

        return to_route('contract-types.index');
    }
}
