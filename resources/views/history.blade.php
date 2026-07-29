@php
    $userName = Auth::user()->username ?? 'Researcher';
@endphp
<!DOCTYPE html>
<html lang="en" class="bg-[#F8FAFC] text-slate-800 antialiased">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScholarFlow - Search History</title>

    <!-- Fonts: Poppins for Headings, Inter for Body -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN ONLY -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .font-poppins { font-family: 'Poppins', sans-serif; }
        .font-inter { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="font-inter flex min-h-screen overflow-x-hidden selection:bg-blue-100 selection:text-blue-900">

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-slate-900/20 z-40 hidden transition-opacity opacity-0 backdrop-blur-sm lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-white border-r border-slate-100 z-50 flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-300 shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
        <!-- Logo -->
        <div class="h-20 flex items-center px-8 border-b border-slate-50">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <span class="font-poppins font-bold text-xl text-slate-900 tracking-tight">ScholarFlow</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
            <p class="px-4 text-xs font-semibold text-slate-400 tracking-wider uppercase mb-3">Menu</p>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            <a href="{{ route('search') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                Search Papers
            </a>
            <a href="{{ route('library') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                My Library
            </a>
            <a href="{{ route('assistant') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-colors">
                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                AI Assistant
            </a>
            <a href="{{ route('history') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl bg-blue-50 text-blue-700 font-medium transition-colors">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                History
            </a>
        </nav>

        <!-- User Profile Bottom -->
        <div class="p-4 border-t border-slate-100">
            <div class="flex items-center gap-3 p-3 rounded-2xl hover:bg-slate-50 transition-colors cursor-pointer group">
                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                    {{ substr($userName, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-900 truncate">{{ $userName }}</p>
                    <p class="text-xs text-slate-500 truncate">user@scholarflow.app</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 lg:ml-72 flex flex-col relative w-full h-screen overflow-y-auto">

        <!-- Mobile Header -->
        <div class="lg:hidden flex items-center justify-between p-4 bg-white/80 backdrop-blur-md sticky top-0 z-30 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <span class="font-poppins font-bold text-lg text-slate-900">ScholarFlow</span>
            </div>
            <button onclick="toggleSidebar()" class="p-2 text-slate-500 rounded-lg hover:bg-slate-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>

        <!-- History Container -->
        <div class="w-full max-w-5xl mx-auto px-4 sm:px-8 py-8 flex-1">

            <!-- Header Title and Clear Action -->
            <div class="flex items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="font-poppins text-3xl font-bold text-slate-900 tracking-tight">Search History</h1>
                    <p class="text-sm text-slate-500 mt-1">Review your recent queries, filter settings, and viewed papers.</p>
                </div>
                <button class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-medium rounded-xl transition-colors">
                    Clear History
                </button>
            </div>

            <!-- History Entries Stream -->
            <div class="space-y-6">

                <!-- Timeline Group: Today -->
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Today</h3>
                    <div class="space-y-3">
                        
                        <!-- History Item 1 -->
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4 min-w-0">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-medium text-slate-900 truncate">"Transformers in Healthcare"</p>
                                    <p class="text-xs text-slate-500 mt-0.5">Filters: 2023–2026 • Open Access • OpenAlex</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                <span class="text-xs text-slate-400">10 mins ago</span>
                                <a href="#" class="px-3.5 py-1.5 bg-slate-50 hover:bg-blue-50 text-slate-700 hover:text-blue-700 text-xs font-medium rounded-lg border border-slate-200 transition-colors">
                                    Rerun Search
                                </a>
                            </div>
                        </div>

                        <!-- History Item 2 -->
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4 min-w-0">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-medium text-slate-900 truncate">"Sparse Attention Mechanisms"</p>
                                    <p class="text-xs text-slate-500 mt-0.5">Filters: Most Cited • ArXiv</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                <span class="text-xs text-slate-400">2 hours ago</span>
                                <a href="#" class="px-3.5 py-1.5 bg-slate-50 hover:bg-blue-50 text-slate-700 hover:text-blue-700 text-xs font-medium rounded-lg border border-slate-200 transition-colors">
                                    Rerun Search
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Timeline Group: Yesterday -->
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Yesterday</h3>
                    <div class="space-y-3">
                        <!-- History Item 3 -->
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4 min-w-0">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-medium text-slate-900 truncate">"Zero-Shot Reasoning in Medical LLMs"</p>
                                    <p class="text-xs text-slate-500 mt-0.5">Filters: None</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                <span class="text-xs text-slate-400">Yesterday</span>
                                <a href="#" class="px-3.5 py-1.5 bg-slate-50 hover:bg-blue-50 text-slate-700 hover:text-blue-700 text-xs font-medium rounded-lg border border-slate-200 transition-colors">
                                    Rerun Search
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.remove('opacity-0'), 10);
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('opacity-0');
                setTimeout(() => overlay.classList.add('hidden'), 300);
            }
        }
    </script>
</body>
</html>