@php
    $userName = Auth::user()->username ?? 'Researcher';
@endphp
<!DOCTYPE html>
<html lang="en" class="bg-[#F8FAFC] text-slate-800 antialiased">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScholarFlow - My Library</title>

    <!-- Fonts: Poppins for Headings, Inter for Body -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN ONLY -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .font-poppins { font-family: 'Poppins', sans-serif; }
        .font-inter { font-family: 'Inter', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
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
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
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
            <a href="{{ route('library') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl bg-blue-50 text-blue-700 font-medium transition-colors">
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

        <!-- Library Container -->
        <div class="w-full max-w-5xl mx-auto px-4 sm:px-8 py-8 flex-1">

            <!-- Header Banner -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="font-poppins text-3xl font-bold text-slate-900 tracking-tight">My Library</h1>
                    <p class="text-sm text-slate-500 mt-1">Organize and read your saved research papers and collections.</p>
                </div>
                <div class="flex items-center gap-3">
                    <button class="px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-xl shadow-sm transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Export RIS / BibTeX
                    </button>
                    <button class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl shadow-sm transition-colors flex items-center gap-2">
                        + New Collection
                    </button>
                </div>
            </div>

            <!-- Library Toolbar: Collections & Search/Sort -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 bg-white p-4 rounded-2xl border border-slate-200 shadow-[0_2px_10px_rgb(0,0,0,0.02)]">
                <!-- Tabs/Folders -->
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar">
                    <button class="px-4 py-2 bg-blue-50 text-blue-700 font-semibold text-sm rounded-xl whitespace-nowrap">All Saved (24)</button>
                    <button class="px-4 py-2 hover:bg-slate-50 text-slate-600 font-medium text-sm rounded-xl whitespace-nowrap transition-colors">AI & Robotics (12)</button>
                    <button class="px-4 py-2 hover:bg-slate-50 text-slate-600 font-medium text-sm rounded-xl whitespace-nowrap transition-colors">Healthcare Tech (8)</button>
                    <button class="px-4 py-2 hover:bg-slate-50 text-slate-600 font-medium text-sm rounded-xl whitespace-nowrap transition-colors">Favorites (4)</button>
                </div>
                <!-- Mini Search & Filter -->
                <div class="flex items-center gap-2 pt-4 md:pt-0 border-t md:border-t-0 md:border-l border-slate-100 md:pl-4">
                    <div class="relative flex-1 md:w-56">
                        <svg class="w-4 h-4 absolute left-3 top-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" placeholder="Filter library..." class="w-full pl-9 pr-3 py-1.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <select class="bg-blue-50 border border-blue-100 text-blue-700 text-sm font-semibold rounded-xl px-3 py-1.5 focus:outline-none cursor-pointer">
                        <option>Recently Added</option>
                        <option>Title (A-Z)</option>
                        <option>Oldest First</option>
                    </select>
                </div>
            </div>

            <!-- Saved Papers Feed -->
            <div class="space-y-4">
                <!-- Library Paper Card 1 -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-3">
                        <div>
                            <span class="inline-block px-2.5 py-1 mb-2 bg-purple-50 text-purple-700 font-semibold text-xs rounded-md">AI & Robotics</span>
                            <h2 class="font-poppins text-lg font-bold text-slate-900 leading-tight">Attention Is All You Need</h2>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <button class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Remove from Library">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1 mb-3 text-sm">
                        <span class="font-medium text-slate-700">Vaswani et al.</span>
                        <span class="text-slate-300">•</span>
                        <span class="text-blue-600 font-medium">NIPS</span>
                        <span class="text-slate-300">•</span>
                        <span class="text-slate-500">2017</span>
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed mb-6 line-clamp-2">
                        The dominant sequence transduction models are based on complex recurrent or convolutional neural networks that include an encoder and a decoder. The best performing models also connect the encoder and decoder through an attention mechanism.
                    </p>
                    <div class="flex flex-wrap items-center gap-3 pt-4 border-t border-slate-50">
                        <a href="#" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl shadow-sm transition-colors">View PDF</a>
                        <button class="px-4 py-2 bg-purple-50 hover:bg-purple-100 text-purple-700 text-sm font-medium rounded-xl transition-colors flex items-center gap-2">
                            <span class="text-purple-500">✨</span> Notes & Summary
                        </button>
                        <button class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-xl transition-colors ml-auto">Cite</button>
                    </div>
                </div>

                <!-- Library Paper Card 2 -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-3">
                        <div>
                            <span class="inline-block px-2.5 py-1 mb-2 bg-emerald-50 text-emerald-700 font-semibold text-xs rounded-md">Healthcare Tech</span>
                            <h2 class="font-poppins text-lg font-bold text-slate-900 leading-tight">Transformers in Healthcare: A systematic review of medical language models</h2>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <button class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Remove from Library">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1 mb-3 text-sm">
                        <span class="font-medium text-slate-700">Chen, L., Gupta, R. et al.</span>
                        <span class="text-slate-300">•</span>
                        <span class="text-blue-600 font-medium">Nature Machine Intelligence</span>
                        <span class="text-slate-300">•</span>
                        <span class="text-slate-500">2023</span>
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed mb-6 line-clamp-2">
                        We synthesize current applications of transformer architectures within clinical domains, exploring zero-shot reasoning, patient chart summarization, and diagnostics.
                    </p>
                    <div class="flex flex-wrap items-center gap-3 pt-4 border-t border-slate-50">
                        <a href="#" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl shadow-sm transition-colors">View PDF</a>
                        <button class="px-4 py-2 bg-purple-50 hover:bg-purple-100 text-purple-700 text-sm font-medium rounded-xl transition-colors flex items-center gap-2">
                            <span class="text-purple-500">✨</span> Notes & Summary
                        </button>
                        <button class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-xl transition-colors ml-auto">Cite</button>
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