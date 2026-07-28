@php
    $userName = Auth::user()->username ?? 'Researcher';
@endphp
<!DOCTYPE html>
<html lang="en" class="bg-[#F8FAFC] text-slate-800 antialiased">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScholarFlow - Dashboard</title>

    <!-- Fonts: Poppins for Headings, Inter for Body -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS CDN ONLY -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Typography mapping */
        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }

        .font-inter {
            font-family: 'Inter', sans-serif;
        }

        /* Smooth transition for layout shifts */
        #search-container {
            transition: all 0.7s cubic-bezier(0.25, 1, 0.5, 1);
        }

        #welcome-section {
            transition: all 0.5s ease-out;
        }

        .fade-in-up {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .fade-in-up.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Hide scrollbar for chips */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="font-inter flex min-h-screen overflow-x-hidden selection:bg-blue-100 selection:text-blue-900">

    <!-- Mobile Overlay -->
    <div id="mobile-overlay"
        class="fixed inset-0 bg-slate-900/20 z-40 hidden transition-opacity opacity-0 backdrop-blur-sm lg:hidden"
        onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 w-72 bg-white border-r border-slate-100 z-50 flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-300 shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
        <!-- Logo -->
        <div class="h-20 flex items-center px-8 border-b border-slate-50">
            <div class="flex items-center gap-3">
                <div
                    class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <span class="font-poppins font-bold text-xl text-slate-900 tracking-tight">ScholarFlow</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
            <p class="px-4 text-xs font-semibold text-slate-400 tracking-wider uppercase mb-3">Menu</p>

            <a href="#"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl bg-blue-50 text-blue-700 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                Dashboard
            </a>
            <a href="#"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Search Papers
            </a>
            <a href="#"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
                My Library
            </a>
            <a href="#"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                </svg>
                Collections
            </a>
            <a href="#"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                </svg>
                Saved Papers
            </a>
            <a href="#"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
                Notes
            </a>
            <a href="#"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Citation Generator
            </a>
            <a href="#"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-colors">
                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                AI Assistant
            </a>
            <a href="#"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
                Analytics
            </a>
        </nav>

        <!-- User Profile Bottom -->
        <div class="p-4 border-t border-slate-100">
            <div
                class="flex items-center gap-3 p-3 rounded-2xl hover:bg-slate-50 transition-colors cursor-pointer group">
                <div
                    class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                    {{ substr($userName, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-900 truncate">{{ $userName }}</p>
                    <p class="text-xs text-slate-500 truncate">user@scholarflow.app</p>
                </div>
                <form action="#" method="POST" class="ml-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button class="text-slate-400 hover:text-red-500 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 lg:ml-72 flex flex-col relative w-full h-screen overflow-y-auto">

        <!-- Mobile Header -->
        <div
            class="lg:hidden flex items-center justify-between p-4 bg-white/80 backdrop-blur-md sticky top-0 z-30 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <span class="font-poppins font-bold text-lg text-slate-900">ScholarFlow</span>
            </div>
            <button onclick="toggleSidebar()" class="p-2 text-slate-500 rounded-lg hover:bg-slate-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Spacer for Center Animation -->
        <div id="top-spacer" class="h-[25vh] transition-all duration-700 ease-in-out shrink-0 w-full hidden md:block">
        </div>

        <!-- HERO & SEARCH SECTION -->
        <div id="search-container"
            class="w-full max-w-4xl mx-auto px-4 sm:px-8 py-8 md:py-0 flex flex-col sticky top-0 z-20">

            <!-- Welcome Text -->
            <div id="welcome-section" class="text-center mb-8 overflow-hidden">
                <h1 class="font-poppins text-4xl sm:text-5xl font-bold text-slate-900 mb-4 tracking-tight">
                    Welcome back, {{ $userName }}
                </h1>
                <p class="text-lg text-slate-500">What would you like to research today?</p>
            </div>

            <!-- Search Box -->
            <form id="search-form" onsubmit="executeSearch(event)" class="relative w-full group">
                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                    <svg class="w-6 h-6 text-slate-400 group-focus-within:text-blue-600 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" id="search-input" autocomplete="off"
                    placeholder="Search papers, authors, DOI, journals..."
                    class="w-full py-5 pl-16 pr-32 text-lg bg-white border border-slate-200 rounded-3xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300">
                <button type="submit"
                    class="absolute inset-y-2 right-2 px-6 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-2xl transition-colors shadow-sm flex items-center gap-2">
                    Search <span class="hidden sm:inline">→</span>
                </button>
            </form>

            <!-- Suggestion Chips -->
            <div id="suggestion-chips" class="mt-8 flex flex-wrap justify-center gap-3 transition-opacity duration-300">
                @php
                    $chips = ['Artificial Intelligence', 'Machine Learning', 'Cybersecurity', 'Healthcare', 'Software Engineering', 'Blockchain'];
                @endphp
                @foreach($chips as $chip)
                    <button onclick="setSearch('{{ $chip }}')"
                        class="px-5 py-2.5 rounded-full border border-slate-200 bg-white text-slate-600 text-sm font-medium hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700 transition-all shadow-sm">
                        {{ $chip }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- MAIN RESULTS AREA (Hidden initially) -->
        <div id="main-content" class="hidden w-full max-w-5xl mx-auto px-4 sm:px-8 pb-20 flex-1">

            <!-- Toolbar (Filters & Sort) -->
            <div
                class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 bg-white p-4 rounded-2xl border border-slate-200 shadow-[0_2px_10px_rgb(0,0,0,0.02)]">

                <!-- Filters -->
                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center gap-2 mr-2 text-slate-500 hidden sm:flex">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                        <span class="text-xs font-bold tracking-wider uppercase">Filters</span>
                    </div>

                    <!-- Year -->
                    <select id="year-filter"
                        class="bg-slate-50 border border-slate-200 text-sm font-medium text-slate-700 rounded-xl px-4 py-2 hover:bg-slate-100 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all cursor-pointer">
                        <option value="">Publication Year</option>
                        <option value="2026">2026</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                    </select>

                    <!-- Open Access -->
                    <select id="oa-filter"
                        class="bg-slate-50 border border-slate-200 text-sm font-medium text-slate-700 rounded-xl px-4 py-2 hover:bg-slate-100 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all cursor-pointer">
                        <option value="">Open Access</option>
                        <option value="open">Only Open Access</option>
                    </select>

                    <!-- API -->
                    <select id="source-filter"
                        class="bg-slate-50 border border-slate-200 text-sm font-medium text-slate-700 rounded-xl px-4 py-2 hover:bg-slate-100 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all cursor-pointer">
                        <option value="">All Sources</option>
                        <option value="ArXiv">ArXiv</option>
                        <option value="OpenAlex">OpenAlex</option>
                        <option value="Crossref">Crossref</option>
                        <option value="CORE">CORE</option>
                        <option value="Europe PMC">Europe PMC</option>
                        <option value="DOAJ">DOAJ</option>
                        <option value="PubMed">PubMed</option>
                        <option value="Zenodo">Zenodo</option>
                        <option value="OpenAIRE">OpenAIRE</option>
                    </select>
                </div>

                <!-- Sort -->
                <div
                    class="flex items-center gap-3 pt-4 md:pt-0 border-t md:border-t-0 md:border-l border-slate-100 md:pl-4">
                    <div class="flex items-center gap-2 text-slate-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                        </svg>
                        <span class="text-xs font-bold tracking-wider uppercase">Sort</span>
                    </div>

                    <select id="sort-filter"
                        class="bg-blue-50 border border-blue-100 text-blue-700 text-sm font-semibold rounded-xl px-4 py-2 hover:bg-blue-100 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all cursor-pointer">
                        <option value="relevant">Most Relevant</option>
                        <option value="newest">Newest</option>
                        <option value="oldest">Oldest</option>
                        <option value="citations">Most Cited</option>
                    </select>
                </div>
            </div>
            <!-- Results Feed -->
            <div id="results-feed" class="space-y-5 fade-in-up">
                <!-- Skeleton / Results will be injected here via JS -->
            </div>

            <!-- Load More Section -->
            <div id="load-more-container" class="hidden mt-8 text-center fade-in-up">
                <button id="load-more-btn" onclick="loadMore()"
                    class="px-8 py-3 bg-white border border-slate-200 hover:border-blue-300 hover:bg-blue-50 text-slate-700 hover:text-blue-700 font-medium rounded-2xl shadow-sm transition-all duration-200 inline-flex items-center gap-2">
                    <span id="load-more-text">Load More Papers</span>
                    <svg id="load-more-spinner" class="w-5 h-5 text-blue-600 animate-spin hidden"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Post-Search Sections (Revealed after first search) -->
            <div id="post-search-sections" class="fade-in-up hidden mt-16 space-y-12 border-t border-slate-200 pt-12">

                <!-- Quick Actions Grid -->
                <div>
                    <h3 class="font-poppins text-xl font-semibold text-slate-900 mb-6">Quick Actions</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <button
                            class="flex flex-col items-center justify-center p-6 bg-white border border-slate-200 rounded-2xl hover:border-blue-400 hover:shadow-md transition-all group">
                            <div
                                class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-slate-700">Search Again</span>
                        </button>
                        <button
                            class="flex flex-col items-center justify-center p-6 bg-white border border-slate-200 rounded-2xl hover:border-blue-400 hover:shadow-md transition-all group">
                            <div
                                class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-slate-700">Create Collection</span>
                        </button>
                        <button
                            class="flex flex-col items-center justify-center p-6 bg-white border border-slate-200 rounded-2xl hover:border-blue-400 hover:shadow-md transition-all group">
                            <div
                                class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-slate-700">Generate Citation</span>
                        </button>
                        <button
                            class="flex flex-col items-center justify-center p-6 bg-white border border-slate-200 rounded-2xl hover:border-blue-400 hover:shadow-md transition-all group">
                            <div
                                class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-slate-700">AI Assistant</span>
                        </button>
                    </div>
                </div>

                <!-- Two Column Layout for Recommendations & Trending -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- AI Recommendations -->
                    <div>
                        <h3 class="font-poppins text-xl font-semibold text-slate-900 mb-6 flex items-center gap-2">
                            <span class="text-purple-500">✨</span> AI Recommendations
                        </h3>
                        <div class="space-y-4">
                            <!-- Dummy Rec Card -->
                            <div
                                class="p-5 bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-md transition-all cursor-pointer">
                                <h4 class="font-semibold text-slate-900 line-clamp-2 mb-1">Transformers in Healthcare: A
                                    systematic review of medical language models</h4>
                                <p class="text-sm text-slate-500">Chen et al. • 2023</p>
                            </div>
                            <div
                                class="p-5 bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-md transition-all cursor-pointer">
                                <h4 class="font-semibold text-slate-900 line-clamp-2 mb-1">Zero-shot learning
                                    capabilities in modern architectures</h4>
                                <p class="text-sm text-slate-500">Smith, J. • 2024</p>
                            </div>
                        </div>
                    </div>

                    <!-- Trending Papers -->
                    <div>
                        <h3 class="font-poppins text-xl font-semibold text-slate-900 mb-6 flex items-center gap-2">
                            <span class="text-orange-500">🔥</span> Trending Papers
                        </h3>
                        <div class="space-y-4">
                            <div
                                class="p-5 bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-md transition-all cursor-pointer">
                                <h4 class="font-semibold text-slate-900 line-clamp-2 mb-1">Attention Is All You Need
                                </h4>
                                <p class="text-sm text-slate-500 mb-2">Vaswani et al. • NIPS • 2017</p>
                                <div
                                    class="inline-flex items-center gap-1 text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                    Highly Cited (Top 1%)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- MODALS -->

    <!-- AI Summary Modal -->
    <div id="ai-modal"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4 transition-opacity opacity-0">
        <div
            class="bg-white rounded-3xl w-full max-w-2xl max-h-[85vh] overflow-hidden flex flex-col shadow-2xl transform scale-95 transition-transform duration-300 modal-content">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-white z-10">
                <h3 class="font-poppins text-lg font-semibold text-slate-900 flex items-center gap-2">
                    <span class="text-purple-500">✨</span> AI Paper Summary
                </h3>
                <button onclick="closeModal('ai-modal')"
                    class="p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="p-6 overflow-y-auto space-y-6">
                <div>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Summary</h4>
                    <p class="text-slate-700 leading-relaxed text-sm">This paper introduces a novel approach to
                        optimizing large language models for resource-constrained environments. By leveraging sparse
                        attention mechanisms, the authors achieve comparable accuracy while reducing compute
                        requirements by 40%.</p>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Key Findings</h4>
                    <ul class="list-disc list-inside text-slate-700 text-sm space-y-1">
                        <li>40% reduction in computational overhead.</li>
                        <li>Maintained 98% baseline accuracy on standard benchmarks.</li>
                        <li>Effective scaling laws demonstrated up to 70B parameters.</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Methodology</h4>
                    <p class="text-slate-700 leading-relaxed text-sm">The authors utilized a custom sparse attention
                        kernel combined with structured pruning techniques during the fine-tuning phase.</p>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Conclusion & Future Work
                    </h4>
                    <p class="text-slate-700 leading-relaxed text-sm">The architecture presents a viable path for
                        deploying advanced AI on edge devices. Future work will explore dynamic sparsity patterns based
                        on input context.</p>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                <button onclick="closeModal('ai-modal')"
                    class="px-5 py-2.5 text-slate-600 font-medium hover:bg-slate-200 rounded-xl transition-colors">Close</button>
                <button
                    class="px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-xl shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                        </path>
                    </svg>
                    Save Summary
                </button>
            </div>
        </div>
    </div>

    <!-- Citation Modal -->
    <div id="citation-modal"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4 transition-opacity opacity-0">
        <div
            class="bg-white rounded-3xl w-full max-w-lg overflow-hidden flex flex-col shadow-2xl transform scale-95 transition-transform duration-300 modal-content">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-poppins text-lg font-semibold text-slate-900">Generate Citation</h3>
                <button onclick="closeModal('citation-modal')"
                    class="p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <div class="flex gap-2 mb-4 overflow-x-auto no-scrollbar pb-2">
                    <button
                        class="px-4 py-1.5 rounded-full bg-blue-600 text-white text-sm font-medium whitespace-nowrap shadow-sm">APA</button>
                    <button
                        class="px-4 py-1.5 rounded-full border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium whitespace-nowrap">MLA</button>
                    <button
                        class="px-4 py-1.5 rounded-full border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium whitespace-nowrap">Chicago</button>
                    <button
                        class="px-4 py-1.5 rounded-full border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium whitespace-nowrap">IEEE</button>
                </div>
                <div class="bg-slate-50 border border-slate-200 p-4 rounded-2xl relative group">
                    <p class="text-slate-800 text-sm font-serif leading-relaxed" id="citation-text">
                        Doe, J., Smith, A., & Johnson, B. (2024). A comprehensive analysis of language models.
                        <i>Journal of Artificial Intelligence Research</i>, 45(2), 112-130.
                        https://doi.org/10.1234/jair.2024.45.2.112
                    </p>
                    <button onclick="copyCitation()"
                        class="absolute top-2 right-2 p-2 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-blue-600 shadow-sm opacity-0 group-hover:opacity-100 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                <button onclick="closeModal('citation-modal')"
                    class="px-5 py-2.5 text-slate-600 font-medium hover:bg-slate-200 rounded-xl transition-colors">Close</button>
                <button onclick="copyCitation()"
                    class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow-sm transition-colors flex items-center gap-2">
                    Copy Citation
                </button>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script>
        let hasSearched = false;
        let currentPage = 1;
        let currentQuery = '';
        let isFetching = false;

        // Mobile Sidebar Toggle
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

        // Chip click
        function setSearch(term) {
            document.getElementById('search-input').value = term;
            executeSearch(new Event('submit'));
        }

        // Initial Search Execution
        async function executeSearch(e) {
            e?.preventDefault();
            const query = document.getElementById('search-input').value.trim();
            if (!query) return;

            // Reset state for new query
            currentPage = 1;
            currentQuery = query;
            hideLoadMoreButton();

            // Trigger Animation if first search
            if (!hasSearched) {
                triggerLayoutShift();
                hasSearched = true;
            }

            const resultsContainer = document.getElementById('results-feed');
            resultsContainer.innerHTML = Array(3).fill(getSkeletonHTML()).join('');

            await fetchPapers(currentPage, false);
        }

        // Load More Execution
        async function loadMore() {
            if (isFetching) return;

            currentPage++;
            setLoadMoreLoading(true);
            await fetchPapers(currentPage, true);
            setLoadMoreLoading(false);
        }

        // Core API Fetch Function
        async function fetchPapers(page, isAppend = false) {
            isFetching = true;

            const resultsContainer = document.getElementById('results-feed');

            try {

                // Get filter values
                const year = document.getElementById('year-filter')?.value || "";
                const openAccess = document.getElementById('oa-filter')?.value || "";
                const source = document.getElementById('source-filter')?.value || "";
                const sort = document.getElementById('sort-filter')?.value || "relevant";

                // Build URL parameters
                const params = new URLSearchParams({
                    q: currentQuery,
                    page: page
                });

                if (year) params.append('year', year);
                if (openAccess) params.append('open_access', openAccess);
                if (source) params.append('source', source);
                if (sort) params.append('sort', sort);

                // Request
                const response = await fetch(`/search?${params.toString()}`);
                const data = await response.json();

                if (data.success && data.results.length > 0) {

                    renderResults(data.results, isAppend);

                    if (page * data.per_page < data.total) {
                        showLoadMoreButton();
                    } else {
                        hideLoadMoreButton();
                    }

                } else {

                    if (!isAppend) {
                        resultsContainer.innerHTML = `
                    <div class="text-center py-16 bg-white rounded-3xl border border-slate-100 shadow-sm">
                        <div class="text-slate-300 mb-4">
                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>

                        <h3 class="font-poppins text-xl font-medium text-slate-800 mb-2">
                            No papers found
                        </h3>

                        <p class="text-slate-500">
                            Try adjusting your search terms or keywords.
                        </p>
                    </div>
                `;
                    }

                    hideLoadMoreButton();
                }

            } catch (error) {

                console.error("Error fetching papers:", error);

                if (!isAppend) {
                    resultsContainer.innerHTML = `
                <div class="text-center py-12 bg-red-50 rounded-3xl border border-red-100">
                    <p class="text-red-600 font-medium">
                        Failed to retrieve data. Please try again later.
                    </p>
                </div>
            `;
                }

                hideLoadMoreButton();

            } finally {

                isFetching = false;

            }
        }

        // Render HTML for Cards
        function renderResults(papers, isAppend = false) {
            const resultsContainer = document.getElementById('results-feed');

            if (!isAppend) {
                resultsContainer.innerHTML = '';
            }

            papers.forEach((paper, index) => {

                const authors = paper.authors || "Unknown Authors";

                const abstract = paper.abstract
                    ? (paper.abstract.length > 250
                        ? paper.abstract.substring(0, 250) + "..."
                        : paper.abstract)
                    : "No abstract available.";

                const venue = paper.source || "Unknown Source";
                const year = paper.year || "N/A";
                const citations = paper.citations
                    ? paper.citations.toLocaleString()
                    : "0";

                // Build query string for Laravel route
                const params = new URLSearchParams({
                    title: paper.title || "",
                    authors: paper.authors || "",
                    abstract: paper.abstract || "",
                    year: paper.year || "",
                    source: paper.source || "",
                    citations: paper.citations || 0,
                    link: paper.link || ""
                });

                const animationStyle = `animation: fadeSlideUp 0.5s ease-out ${index * 0.05}s both;`;

                const cardHTML = `
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-lg transition-all duration-300" style="${animationStyle}">

            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-3">

                <h2 class="font-poppins text-xl font-bold text-slate-900 leading-tight md:pr-12">
                    ${paper.title}
                </h2>

                <div class="shrink-0">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-50 border border-slate-200 rounded-lg text-sm font-medium text-slate-600">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6">
                            </path>
                        </svg>
                        ${citations}
                    </span>
                </div>

            </div>

            <div class="flex flex-wrap items-center gap-x-2 gap-y-1 mb-4 text-sm">
                <span class="font-medium text-slate-700">${authors}</span>
                <span class="text-slate-300">•</span>
                <span class="text-blue-600 font-medium">${venue}</span>
                <span class="text-slate-300">•</span>
                <span class="text-slate-500">${year}</span>
            </div>

            <p class="text-slate-600 text-sm leading-relaxed mb-6">
                ${abstract}
            </p>

            <div class="flex flex-wrap items-center gap-3 pt-4 border-t border-slate-50">

                <a href="/paper?${params.toString()}"
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl shadow-sm transition-colors">
                    View Paper
                </a>

                <button class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-xl transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z">
                        </path>
                    </svg>
                    Save
                </button>

                <button onclick="openModal('ai-modal')"
                    class="px-4 py-2 bg-purple-50 hover:bg-purple-100 text-purple-700 text-sm font-medium rounded-xl transition-colors flex items-center gap-2 ml-auto md:ml-0">
                    <span class="text-purple-500">✨</span>
                    AI Summary
                </button>

                <button onclick="openModal('citation-modal')"
                    class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-xl transition-colors flex items-center gap-2">

                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>

                    Cite

                </button>

            </div>

        </div>
        `;

                resultsContainer.insertAdjacentHTML("beforeend", cardHTML);
            });
        }

        // Helper functions for Load More Button UI State
        function showLoadMoreButton() {
            const container = document.getElementById('load-more-container');
            if (container) container.classList.remove('hidden');
        }

        function hideLoadMoreButton() {
            const container = document.getElementById('load-more-container');
            if (container) container.classList.add('hidden');
        }

        function setLoadMoreLoading(isLoading) {
            const btn = document.getElementById('load-more-btn');
            const text = document.getElementById('load-more-text');
            const spinner = document.getElementById('load-more-spinner');

            if (isLoading) {
                btn.disabled = true;
                text.textContent = 'Loading...';
                spinner.classList.remove('hidden');
            } else {
                btn.disabled = false;
                text.textContent = 'Load More Papers';
                spinner.classList.add('hidden');
            }
        }

        // The Layout Animation (Center to Top)
        function triggerLayoutShift() {
            const spacer = document.getElementById('top-spacer');
            if (spacer) {
                spacer.classList.replace('h-[25vh]', 'h-0');
            }

            const welcome = document.getElementById('welcome-section');
            welcome.style.maxHeight = welcome.scrollHeight + 'px';
            setTimeout(() => {
                welcome.style.opacity = '0';
                welcome.style.maxHeight = '0';
                welcome.style.marginBottom = '0';
                welcome.style.transform = 'scale(0.95)';
            }, 10);

            const chips = document.getElementById('suggestion-chips');
            chips.style.opacity = '0';
            setTimeout(() => chips.classList.add('hidden'), 300);

            const searchContainer = document.getElementById('search-container');
            searchContainer.classList.add('bg-white/90', 'backdrop-blur-md', 'py-4', 'border-b', 'border-slate-100');
            searchContainer.classList.remove('py-8');

            const mainContent = document.getElementById('main-content');
            mainContent.classList.remove('hidden');

            setTimeout(() => {
                const elementsToFade = document.querySelectorAll('.fade-in-up');
                elementsToFade.forEach((el, index) => {
                    setTimeout(() => {
                        el.classList.remove('hidden');
                        setTimeout(() => el.classList.add('active'), 10);
                    }, index * 100);
                });
            }, 400);
        }

        function getSkeletonHTML() {
            return `
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm animate-pulse">
                    <div class="flex justify-between gap-4 mb-4">
                        <div class="h-6 bg-slate-200 rounded-md w-3/4"></div>
                        <div class="h-8 bg-slate-200 rounded-lg w-20"></div>
                    </div>
                    <div class="flex gap-2 mb-6">
                        <div class="h-4 bg-slate-200 rounded-md w-1/4"></div>
                        <div class="h-4 bg-slate-200 rounded-md w-1/4"></div>
                        <div class="h-4 bg-slate-200 rounded-md w-16"></div>
                    </div>
                    <div class="space-y-2 mb-6">
                        <div class="h-3.5 bg-slate-100 rounded-md w-full"></div>
                        <div class="h-3.5 bg-slate-100 rounded-md w-5/6"></div>
                        <div class="h-3.5 bg-slate-100 rounded-md w-4/6"></div>
                    </div>
                    <div class="flex gap-3 pt-4 border-t border-slate-50">
                        <div class="h-10 bg-slate-200 rounded-xl w-28"></div>
                        <div class="h-10 bg-slate-100 rounded-xl w-24"></div>
                        <div class="h-10 bg-slate-100 rounded-xl w-32 ml-auto md:ml-0"></div>
                        <div class="h-10 bg-slate-100 rounded-xl w-24"></div>
                    </div>
                </div>
            `;
        }

        // Modal Controls
        function openModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            void modal.offsetWidth;
            modal.classList.remove('opacity-0');
            modal.querySelector('.modal-content').classList.remove('scale-95');
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.add('opacity-0');
            modal.querySelector('.modal-content').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function copyCitation() {
            const text = document.getElementById('citation-text').innerText;
            navigator.clipboard.writeText(text).then(() => {
                alert('Citation copied to clipboard!');
            });
        }

        // Keyframe animations
        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes fadeSlideUp {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>

</html>