<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — Pemira</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #1e293b; }
        ::-webkit-scrollbar-thumb { background: #475569; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748b; }

        /* Sidebar accordion animation */
        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
        }
        .accordion-content.open {
            max-height: 500px;
        }

        /* Active nav glow */
        .nav-active {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(139, 92, 246, 0.1));
            border-left: 3px solid #818cf8;
        }
    </style>
</head>
<body class="h-full bg-gray-50">

    <!-- ========== SIDEBAR ========== -->
    <aside id="sidebar" class="fixed top-0 left-0 z-50 w-64 h-full bg-slate-900 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col">
        <!-- Logo -->
        <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-700/50">
            <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-lg shadow-indigo-500/20">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-white font-bold text-lg leading-tight">Pemira</h1>
                <p class="text-slate-400 text-xs font-medium">Admin Panel</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('admin.dashboard') ? 'nav-active text-indigo-300' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>
                </svg>
                Dashboard
            </a>

            <!-- Divider -->
            <div class="pt-3 pb-1 px-3">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Master Data</p>
            </div>

            <!-- Master Data Accordion -->
            <div>
                <button onclick="toggleAccordion('masterDataMenu')"
                        class="flex items-center justify-between w-full px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200
                               {{ request()->routeIs('admin.periode.*') || request()->routeIs('admin.fakultas.*') || request()->routeIs('admin.kategori.*') ? 'nav-active text-indigo-300' : '' }}">
                    <span class="flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75"/>
                        </svg>
                        Master Data
                    </span>
                    <svg id="masterDataMenuIcon" class="w-4 h-4 transform transition-transform duration-200 {{ request()->routeIs('admin.periode.*') || request()->routeIs('admin.fakultas.*') || request()->routeIs('admin.kategori.*') ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="masterDataMenu" class="accordion-content {{ request()->routeIs('admin.periode.*') || request()->routeIs('admin.fakultas.*') || request()->routeIs('admin.kategori.*') ? 'open' : '' }}">
                    <div class="ml-4 pl-4 border-l border-slate-700 mt-1 space-y-1">
                        <a href="{{ route('admin.periode.index') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-all duration-200
                                  {{ request()->routeIs('admin.periode.*') ? 'text-indigo-300 bg-indigo-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.periode.*') ? 'bg-indigo-400' : 'bg-slate-600' }}"></span>
                            Periode
                        </a>
                        <a href="{{ route('admin.fakultas.index') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-all duration-200
                                  {{ request()->routeIs('admin.fakultas.*') ? 'text-indigo-300 bg-indigo-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.fakultas.*') ? 'bg-indigo-400' : 'bg-slate-600' }}"></span>
                            Wilayah / Fakultas
                        </a>
                        <a href="{{ route('admin.kategori.index') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-all duration-200
                                  {{ request()->routeIs('admin.kategori.*') ? 'text-indigo-300 bg-indigo-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.kategori.*') ? 'bg-indigo-400' : 'bg-slate-600' }}"></span>
                            Kategori Pemilihan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="pt-3 pb-1 px-3">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pemilihan</p>
            </div>

            <!-- Calon / Paslon -->
            <a href="{{ route('admin.calon.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('admin.calon.*') ? 'nav-active text-indigo-300' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                </svg>
                Identitas Calon
            </a>

            <!-- Informasi Lainnya -->
            <a href="{{ route('admin.informasi.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('admin.informasi.*') ? 'nav-active text-indigo-300' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                </svg>
                Informasi Lainnya
            </a>

            <!-- Divider -->
            <div class="pt-3 pb-1 px-3">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pengaturan</p>
            </div>

            <!-- Akun Admin Accordion -->
            <div>
                <button onclick="toggleAccordion('akunMenu')"
                        class="flex items-center justify-between w-full px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200
                               {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.logs.*') ? 'nav-active text-indigo-300' : '' }}">
                    <span class="flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Akun & Log
                    </span>
                    <svg id="akunMenuIcon" class="w-4 h-4 transform transition-transform duration-200 {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.logs.*') ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="akunMenu" class="accordion-content {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.logs.*') ? 'open' : '' }}">
                    <div class="ml-4 pl-4 border-l border-slate-700 mt-1 space-y-1">
                        <a href="{{ route('admin.users.index') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-all duration-200
                                  {{ request()->routeIs('admin.users.*') ? 'text-indigo-300 bg-indigo-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.users.*') ? 'bg-indigo-400' : 'bg-slate-600' }}"></span>
                            Manajemen Admin
                        </a>
                        <a href="{{ route('admin.logs.index') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-all duration-200
                                  {{ request()->routeIs('admin.logs.*') ? 'text-indigo-300 bg-indigo-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.logs.*') ? 'bg-indigo-400' : 'bg-slate-600' }}"></span>
                            Log Aktivitas
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Sidebar Footer: User Info -->
        <div class="p-4 border-t border-slate-700/50">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-9 h-9 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-lg text-white text-sm font-bold">
                    {{ strtoupper(substr(auth('admin')->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-white truncate">{{ auth('admin')->user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ auth('admin')->user()->role?->value ?? 'ADMIN' }}</p>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="p-1.5 text-slate-400 hover:text-red-400 hover:bg-slate-800 rounded-lg transition-all" title="Logout">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- ========== OVERLAY (Mobile) ========== -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden" onclick="closeSidebar()"></div>

    <!-- ========== MAIN CONTENT ========== -->
    <div class="lg:ml-64 min-h-full flex flex-col">
        <!-- Header -->
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-lg border-b border-gray-200/50">
            <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 h-16">
                <!-- Mobile menu button -->
                <button onclick="openSidebar()" class="lg:hidden p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                </button>

                <!-- Page Title -->
                <h2 class="text-lg font-semibold text-gray-800">@yield('title', 'Dashboard')</h2>

                <!-- Right side -->
                <div class="flex items-center gap-3">
                    <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 text-indigo-700 text-xs font-semibold rounded-full">
                        <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-pulse"></span>
                        {{ auth('admin')->user()->role?->value ?? 'ADMIN' }}
                    </span>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 animate-fade-in" role="alert">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700" role="alert">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="border-t border-gray-200/50 px-4 sm:px-6 lg:px-8 py-4">
            <p class="text-center text-xs text-gray-400">&copy; {{ date('Y') }} Pemira — Komisi Pemilihan Umum Raya. All rights reserved.</p>
        </footer>
    </div>

    <!-- Sidebar Toggle & Accordion JS -->
    <script>
        function openSidebar() {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.remove('hidden');
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.add('hidden');
        }

        function toggleAccordion(id) {
            const content = document.getElementById(id);
            const icon = document.getElementById(id + 'Icon');
            content.classList.toggle('open');
            icon.classList.toggle('rotate-180');
        }

        // Auto-dismiss flash messages after 5 seconds
        document.querySelectorAll('[role="alert"]').forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });
    </script>

    @stack('scripts')
</body>
</html>
