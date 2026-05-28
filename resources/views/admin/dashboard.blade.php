@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- ── Periode Aktif Alert ──────────────────────────────── --}}
    @if($activePeriod)
        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-700 rounded-2xl p-6 text-white shadow-xl shadow-indigo-500/10">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
            <div class="relative">
                <div class="flex items-center gap-2 mb-2">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-semibold">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                        PERIODE AKTIF
                    </span>
                </div>
                <h3 class="text-2xl font-bold mb-1">{{ $activePeriod->name }}</h3>
                <p class="text-indigo-100 text-sm">Tahun {{ $activePeriod->year }} &bull; Voting: {{ $activePeriod->vote_start_at->format('d M Y, H:i') }} — {{ $activePeriod->vote_end_at->format('d M Y, H:i') }}</p>
            </div>
        </div>
    @else
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0 w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-amber-800">Tidak Ada Periode Aktif</h3>
                    <p class="text-xs text-amber-600">Silakan aktifkan periode pemilihan melalui menu Master Data &rarr; Periode.</p>
                </div>
            </div>
        </div>
    @endif

    {{-- ── Countdown Timer ──────────────────────────────────── --}}
    @if($activePeriod)
        <div class="bg-white rounded-2xl border border-gray-200/60 shadow-sm p-6">
            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Countdown Pemira</h4>
            <div id="countdown" class="flex items-center justify-center gap-4 sm:gap-6">
                <div class="text-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-indigo-50 to-purple-50 border border-indigo-100 rounded-2xl flex items-center justify-center mb-2">
                        <span id="cd-days" class="text-2xl sm:text-3xl font-bold text-indigo-700">--</span>
                    </div>
                    <span class="text-xs font-medium text-gray-500">Hari</span>
                </div>
                <span class="text-2xl font-light text-gray-300 mt-[-1.5rem]">:</span>
                <div class="text-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-indigo-50 to-purple-50 border border-indigo-100 rounded-2xl flex items-center justify-center mb-2">
                        <span id="cd-hours" class="text-2xl sm:text-3xl font-bold text-indigo-700">--</span>
                    </div>
                    <span class="text-xs font-medium text-gray-500">Jam</span>
                </div>
                <span class="text-2xl font-light text-gray-300 mt-[-1.5rem]">:</span>
                <div class="text-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-indigo-50 to-purple-50 border border-indigo-100 rounded-2xl flex items-center justify-center mb-2">
                        <span id="cd-minutes" class="text-2xl sm:text-3xl font-bold text-purple-700">--</span>
                    </div>
                    <span class="text-xs font-medium text-gray-500">Menit</span>
                </div>
                <span class="text-2xl font-light text-gray-300 mt-[-1.5rem]">:</span>
                <div class="text-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-purple-50 to-pink-50 border border-purple-100 rounded-2xl flex items-center justify-center mb-2">
                        <span id="cd-seconds" class="text-2xl sm:text-3xl font-bold text-purple-700">--</span>
                    </div>
                    <span class="text-xs font-medium text-gray-500">Detik</span>
                </div>
            </div>
            <p id="cd-label" class="text-center text-sm text-gray-500 mt-4"></p>
        </div>
    @endif

    {{-- ── Statistics Grid ──────────────────────────────────── --}}
    @if($activePeriod)
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
            <!-- Jumlah Paslon -->
            <div class="relative overflow-hidden bg-white rounded-2xl border border-gray-200/60 shadow-sm p-6 group hover:shadow-md hover:border-indigo-200 transition-all duration-300">
                <div class="absolute top-0 right-0 w-20 h-20 bg-indigo-50 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-110 transition-transform"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($stats['candidates']) }}</p>
                    <p class="text-sm text-gray-500 font-medium">Calon / Paslon</p>
                </div>
            </div>

            <!-- Jumlah DPT -->
            <div class="relative overflow-hidden bg-white rounded-2xl border border-gray-200/60 shadow-sm p-6 group hover:shadow-md hover:border-emerald-200 transition-all duration-300">
                <div class="absolute top-0 right-0 w-20 h-20 bg-emerald-50 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-110 transition-transform"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($stats['dpt']) }}</p>
                    <p class="text-sm text-gray-500 font-medium">Suara Aktif (DPT)</p>
                </div>
            </div>

            <!-- Jumlah Suara Terisi -->
            <div class="relative overflow-hidden bg-white rounded-2xl border border-gray-200/60 shadow-sm p-6 group hover:shadow-md hover:border-violet-200 transition-all duration-300">
                <div class="absolute top-0 right-0 w-20 h-20 bg-violet-50 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-110 transition-transform"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl flex items-center justify-center shadow-lg shadow-violet-500/20">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($stats['ballots']) }}</p>
                    <p class="text-sm text-gray-500 font-medium">Suara Terisi</p>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection

@push('scripts')
@if($activePeriod)
<script>
    (function() {
        const voteStart = new Date("{{ $activePeriod->vote_start_at->toIso8601String() }}").getTime();
        const voteEnd = new Date("{{ $activePeriod->vote_end_at->toIso8601String() }}").getTime();

        function updateCountdown() {
            const now = Date.now();
            let target, label;

            if (now < voteStart) {
                target = voteStart;
                label = '⏳ Menuju dimulainya Pemira';
            } else if (now < voteEnd) {
                target = voteEnd;
                label = '🗳️ Pemira sedang berlangsung — menuju selesai';
            } else {
                document.getElementById('cd-days').textContent = '00';
                document.getElementById('cd-hours').textContent = '00';
                document.getElementById('cd-minutes').textContent = '00';
                document.getElementById('cd-seconds').textContent = '00';
                document.getElementById('cd-label').textContent = '✅ Pemira telah selesai';
                return;
            }

            const diff = target - now;
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            document.getElementById('cd-days').textContent = String(days).padStart(2, '0');
            document.getElementById('cd-hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('cd-minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('cd-seconds').textContent = String(seconds).padStart(2, '0');
            document.getElementById('cd-label').textContent = label;
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    })();
</script>
@endif
@endpush
