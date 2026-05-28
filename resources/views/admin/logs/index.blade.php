@extends('layouts.admin')
@section('title', 'Log Aktivitas Admin')
@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Log Aktivitas Admin</h1>
        <p class="text-sm text-gray-500 mt-1">Catatan seluruh aktivitas CRUD yang dilakukan oleh admin</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200/60 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-200">
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Admin</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aktivitas</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Target</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Detail</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">IP</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center justify-center w-7 h-7 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-lg text-white text-xs font-bold">
                                        {{ strtoupper(substr($log->actor?->name ?? '?', 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-gray-900 text-xs">{{ $log->actor?->name ?? 'System' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $eventColors = [
                                        'CREATE' => 'bg-emerald-100 text-emerald-700',
                                        'UPDATE' => 'bg-blue-100 text-blue-700',
                                        'DELETE' => 'bg-red-100 text-red-700',
                                    ];
                                @endphp
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold {{ $eventColors[$log->event_type] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ $log->event_type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-xs">{{ $log->entity_type ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-500 text-xs max-w-xs truncate">
                                @if($log->meta)
                                    @foreach($log->meta as $key => $val)
                                        <span class="inline-flex px-1.5 py-0.5 bg-gray-100 rounded text-xs mr-1">{{ $key }}: {{ is_array($val) ? implode(', ', $val) : Str::limit((string)$val, 30) }}</span>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-xs font-mono">{{ $log->ip_address }}</td>
                            <td class="px-6 py-4 text-gray-500 text-xs">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                <p class="font-medium">Belum ada log aktivitas</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">{{ $logs->links() }}</div>
        @endif
    </div>
</div>
@endsection
