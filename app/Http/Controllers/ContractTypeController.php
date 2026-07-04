<?php

namespace App\Http\Controllers;

use App\Models\ContractType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        return to_route('contract-types.index');
    }

    public function edit(ContractType $contractType): Response
    {
        return Inertia::render('contract-types/Edit', [
            'contractType' => $contractType,
        ]);
    }

    public function update(Request $request, ContractType $contractType): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $contractType->update($data);

        return to_route('contract-types.index');
    }
}
