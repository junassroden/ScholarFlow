@php
    $userName = Auth::user()->username ?? 'Researcher';
@endphp
<!DOCTYPE html>
<html lang="en" class="bg-[#F8FAFC] text-slate-800 antialiased">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScholarFlow - Search Papers</title>

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
            <a href="{{ route('search') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl bg-blue-50 text-blue-700 font-medium transition-colors">
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
            <a href="{{ route('history') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-colors">
                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
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

        <!-- Sticky Search Bar -->
        <div class="w-full max-w-5xl mx-auto px-4 sm:px-8 pt-8 pb-4 sticky top-0 z-20 bg-[#F8FAFC]/90 backdrop-blur-md">
            <h1 class="font-poppins text-3xl font-bold text-slate-900 mb-4 tracking-tight">Academic Literature Search</h1>

            <!-- Main Input -->
            <form class="relative w-full group mb-4">
                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                    <svg class="w-6 h-6 text-slate-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" placeholder="Search across ArXiv, Crossref, OpenAlex, PubMed, DOI..." class="w-full py-4 pl-16 pr-32 text-base bg-white border border-slate-200 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 shadow-sm transition-all">
                <button type="submit" class="absolute inset-y-2 right-2 px-6 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-colors shadow-sm">
                    Search
                </button>
            </form>

            <!-- Filters & Sort Options -->
            <div class="flex flex-wrap items-center justify-between gap-3 bg-white p-3 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex flex-wrap items-center gap-2">
                    <select class="bg-slate-50 border border-slate-200 text-xs font-medium text-slate-700 rounded-xl px-3 py-1.5 focus:outline-none cursor-pointer">
                        <option>Publication Year: All</option>
                        <option>2026</option>
                        <option>2025</option>
                        <option>2024</option>
                    </select>
                    <select class="bg-slate-50 border border-slate-200 text-xs font-medium text-slate-700 rounded-xl px-3 py-1.5 focus:outline-none cursor-pointer">
                        <option>Open Access: Any</option>
                        <option>Open Access Only</option>
                    </select>
                    <select class="bg-slate-50 border border-slate-200 text-xs font-medium text-slate-700 rounded-xl px-3 py-1.5 focus:outline-none cursor-pointer">
                        <option>Source: All Repositories</option>
                        <option>ArXiv</option>
                        <option>PubMed</option>
                        <option>OpenAlex</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Sort By</span>
                    <select class="bg-blue-50 border border-blue-100 text-blue-700 text-xs font-semibold rounded-xl px-3 py-1.5 focus:outline-none cursor-pointer">
                        <option>Most Relevant</option>
                        <option>Newest First</option>
                        <option>Highest Citation Count</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Search Results List -->
        <div class="w-full max-w-5xl mx-auto px-4 sm:px-8 pb-20 space-y-4">

            <!-- Result Card 1 -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300">
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-3">
                    <h2 class="font-poppins text-lg font-bold text-slate-900 leading-tight md:pr-12">
                        Zero-Shot Learning Capabilities in Deep Neural Architectures
                    </h2>
                    <div class="shrink-0">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-50 border border-slate-200 rounded-lg text-sm font-medium text-slate-600">
                            ★ 412 Citations
                        </span>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-x-2 gap-y-1 mb-3 text-sm">
                    <span class="font-medium text-slate-700">Smith, J., Baker, R.</span>
                    <span class="text-slate-300">•</span>
                    <span class="text-blue-600 font-medium">ArXiv</span>
                    <span class="text-slate-300">•</span>
                    <span class="text-slate-500">2024</span>
                </div>
                <p class="text-slate-600 text-sm leading-relaxed mb-6 line-clamp-3">
                    We propose an evaluation framework for testing zero-shot generalization across domain boundaries using contrastive pre-training objectives and sparse cross-attention mechanisms.
                </p>
                <div class="flex flex-wrap items-center gap-3 pt-4 border-t border-slate-50">
                    <a href="#" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl shadow-sm transition-colors">View Paper</a>
                    <button class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-xl transition-colors">Save to Library</button>
                    <button class="px-4 py-2 bg-purple-50 hover:bg-purple-100 text-purple-700 text-sm font-medium rounded-xl transition-colors flex items-center gap-2 ml-auto">
                        <span class="text-purple-500">✨</span> AI Summary
                    </button>
                </div>
            </div>

            <!-- Result Card 2 -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300">
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-3">
                    <h2 class="font-poppins text-lg font-bold text-slate-900 leading-tight md:pr-12">
                        Retrieval-Augmented Generation for Scientific Domain Adaptation
                    </h2>
                    <div class="shrink-0">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-50 border border-slate-200 rounded-lg text-sm font-medium text-slate-600">
                            ★ 1,289 Citations
                        </span>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-x-2 gap-y-1 mb-3 text-sm">
                    <span class="font-medium text-slate-700">Lewis, M., Perez, E. et al.</span>
                    <span class="text-slate-300">•</span>
                    <span class="text-blue-600 font-medium">OpenAlex</span>
                    <span class="text-slate-300">•</span>
                    <span class="text-slate-500">2023</span>
                </div>
                <p class="text-slate-600 text-sm leading-relaxed mb-6 line-clamp-3">
                    By decoupling knowledge storage from parametric memory, retrieval-augmented models reduce factual hallucinations and continuously update domain references without retraining weights.
                </p>
                <div class="flex flex-wrap items-center gap-3 pt-4 border-t border-slate-50">
                    <a href="#" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl shadow-sm transition-colors">View Paper</a>
                    <button class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-xl transition-colors">Save to Library</button>
                    <button class="px-4 py-2 bg-purple-50 hover:bg-purple-100 text-purple-700 text-sm font-medium rounded-xl transition-colors flex items-center gap-2 ml-auto">
                        <span class="text-purple-500">✨</span> AI Summary
                    </button>
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