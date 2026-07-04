<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\DoctorsClient;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AuditLogController extends Controller
{
    public function index(DoctorsClient $doctors): Response
    {
        /** @var User $user */
        $user = Auth::user();

        $result = rescue(
            fn () => $doctors->getAuditLogs($user->tenant_id),
            ['data' => [], 'current_page' => 1, 'last_page' => 1, 'total' => 0],
        );

        return Inertia::render('audit-logs/Index', [
            'logs' => $result['data'],
            'currentPage' => $result['current_page'],
            'lastPage' => $result['last_page'],
            'total' => $result['total'],
        ]);
    }
}
