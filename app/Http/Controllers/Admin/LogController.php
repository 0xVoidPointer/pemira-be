<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\View\View;

class LogController extends Controller
{
    /**
     * Show audit log list (read-only).
     */
    public function index(): View
    {
        $logs = AuditLog::with('actor')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.logs.index', compact('logs'));
    }
}
