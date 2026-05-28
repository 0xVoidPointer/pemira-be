<?php

namespace App\Helpers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditHelper
{
    /**
     * Log an admin activity to the audit_logs table.
     *
     * @param  array<string, mixed>|null  $meta
     */
    public static function log(
        string $eventType,
        ?string $entityType = null,
        ?string $entityId = null,
        ?array $meta = null,
    ): AuditLog {
        return AuditLog::create([
            'actor_id' => Auth::guard('admin')->id(),
            'event_type' => $eventType,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'meta' => $meta,
            'ip_address' => Request::ip() ?? '0.0.0.0',
        ]);
    }
}
