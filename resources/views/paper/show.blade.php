@php
    $userName = auth()->user()?->username ?? 'Researcher';
@endphp
<!DOCTYPE html>
<html lang="en" class="bg-[#F8FAFC] text-slate-800 antialiased">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $paper['title'] ?? 'Paper Details' }} - ScholarFlow</title>

    <!-- Fonts: Poppins for Headings, Inter for Body -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .font-poppins { font-family: 'Poppins', sans-serif; }
        .font-inter { font-family: 'Inter', sans-serif; }
        
        .fade-in-up {
            animation: fadeSlideUp 0.6s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Hide scrollbar for horizontal scrolling areas */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="font-inter min-h-screen overflow-x-hidden selection:bg-blue-100 selection:text-blue-900 flex flex-col">

    <!-- Top Navigation -->
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="javascript:history.back()" class="p-2 -ml-2 text-slate-400 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition-colors group">
                    <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                
                <div class="flex items-center gap-3 hidden sm:flex">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-lg shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <span class="font-poppins font-bold text-xl text-slate-900 tracking-tight">ScholarFlow</span>
                </div>
            </div>

            <!-- User Profile -->
            <div class="flex items-center gap-3 p-2 rounded-2xl hover:bg-slate-50 transition-colors cursor-pointer">
                <div class="hidden sm:block text-right">
                    <p class="text-sm font-semibold text-slate-900">{{ $userName }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                    {{ substr($userName, 0, 1) }}
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-8 py-8 md:py-12 fade-in-up">
        
        <!-- Hero Section -->
        <div class="bg-white p-6 md:p-10 rounded-3xl border border-slate-200 shadow-sm mb-8 relative">
            <div class="flex flex-wrap items-center gap-x-3 gap-y-2 mb-4 text-sm font-medium">
                <span class="px-3 py-1 bg-blue-50 text-blue-700 border border-blue-100 rounded-lg">{{ $paper['source'] ?? 'Unknown Source' }}</span>
                <span class="text-slate-400">•</span>
                <span class="text-slate-600">{{ $paper['year'] ?? 'N/A' }}</span>
                <span class="text-slate-400">•</span>
                <span class="inline-flex items-center gap-1.5 text-slate-600">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    {{ number_format($paper['citations'] ?? 0) }} Citations
                </span>
                
                @if(($paper['open_access'] ?? false) === true || ($paper['open_access'] ?? 'closed') === 'open')
                <span class="text-slate-400 hidden sm:inline">•</span>
                <span class="inline-flex items-center gap-1 text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md text-xs font-semibold">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                    Open Access
                </span>
                @endif
            </div>

            <h1 class="font-poppins text-3xl sm:text-4xl md:text-5xl font-bold text-slate-900 mb-6 leading-tight tracking-tight">
                {{ $paper['title'] ?? 'Untitled Paper' }}
            </h1>

            <div class="mb-10 text-lg text-slate-600 font-medium">
                {{ $paper['authors'] ?? 'Unknown Authors' }}
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-3 pt-6 border-t border-slate-100">
                <a href="{{ $paper['link'] ?? '#' }}" target="_blank" rel="noopener noreferrer" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    View Original
                </a>
                <button class="px-5 py-3 bg-white border border-slate-200 hover:border-blue-300 hover:bg-blue-50 text-slate-700 font-medium rounded-xl transition-all flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                    Save
                </button>
                <button class="px-5 py-3 bg-purple-50 border border-purple-100 hover:bg-purple-100 text-purple-700 font-medium rounded-xl transition-colors flex items-center gap-2 shadow-sm">
                    <span class="text-purple-500">✨</span> AI Summary
                </button>
                <button class="px-5 py-3 bg-white border border-slate-200 hover:border-blue-300 hover:bg-blue-50 text-slate-700 font-medium rounded-xl transition-all flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Cite
                </button>
                <button class="px-5 py-3 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium rounded-xl transition-colors flex items-center justify-center shadow-sm w-12 sm:w-auto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                    <span class="hidden sm:inline ml-2">Share</span>
                </button>
            </div>
        </div>

        <!-- 2-Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Content -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Abstract -->
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-200 shadow-sm">
                    <h2 class="font-poppins text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        Abstract
                    </h2>
                    <p class="text-slate-700 leading-loose">
                        {{ $paper['abstract'] ?? 'No abstract available for this paper.' }}
                    </p>
                </div>

                <!-- AI Summary Card Placeholder -->
                <div class="bg-gradient-to-br from-purple-50 to-white p-6 md:p-8 rounded-3xl border border-purple-100 shadow-sm relative overflow-hidden group cursor-pointer hover:shadow-md transition-shadow">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-purple-200 rounded-full blur-3xl opacity-50 group-hover:opacity-70 transition-opacity"></div>
                    <h2 class="font-poppins text-xl font-bold text-slate-900 mb-4 flex items-center gap-2 relative z-10">
                        <span class="text-purple-500">✨</span> AI Analysis
                    </h2>
                    <div class="relative z-10 bg-white/60 backdrop-blur-sm rounded-2xl p-6 border border-purple-50/50 text-center">
                        <p class="text-purple-600 font-medium mb-3">AI Summary coming soon...</p>
                        <p class="text-slate-500 text-sm">We're generating key insights, methodology breakdowns, and core findings for this paper.</p>
                    </div>
                </div>

                <!-- Keywords & DOI -->
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                    <div>
                        <h3 class="font-poppins text-lg font-semibold text-slate-900 mb-3">Keywords</h3>
                        <div class="flex flex-wrap gap-2">
                            @if(isset($paper['keywords']) && is_array($paper['keywords']))
                                @foreach($paper['keywords'] as $keyword)
                                    <span class="px-4 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-600 hover:bg-slate-100 cursor-pointer transition-colors">{{ $keyword }}</span>
                                @endforeach
                            @else
                                <span class="text-slate-500 text-sm italic">No keywords provided.</span>
                            @endif
                        </div>
                    </div>
                    
                    @if(isset($paper['doi']))
                    <div class="pt-6 border-t border-slate-100">
                        <h3 class="font-poppins text-lg font-semibold text-slate-900 mb-2">DOI</h3>
                        <a href="https://doi.org/{{ $paper['doi'] }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm break-all flex items-center gap-1">
                            {{ $paper['doi'] }}
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Meta Information & Citations -->
            <div class="space-y-8">
                
                <!-- Information Card -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                    <h3 class="font-poppins text-lg font-bold text-slate-900 mb-6">Paper Details</h3>
                    
                    <ul class="space-y-5">
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center shrink-0 text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-0.5">Publication Year</p>
                                <p class="text-sm font-medium text-slate-900">{{ $paper['year'] ?? 'N/A' }}</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center shrink-0 text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-0.5">Source / Venue</p>
                                <p class="text-sm font-medium text-slate-900">{{ $paper['source'] ?? 'Unknown' }}</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center shrink-0 text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-0.5">Citation Count</p>
                                <p class="text-sm font-medium text-slate-900">{{ number_format($paper['citations'] ?? 0) }}</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center shrink-0 text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-0.5">Authors</p>
                                <p class="text-sm font-medium text-slate-900 line-clamp-3">{{ $paper['authors'] ?? 'Unknown' }}</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center shrink-0 text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-0.5">Access Status</p>
                                <p class="text-sm font-medium text-slate-900">
                                    @if(($paper['open_access'] ?? false) === true || ($paper['open_access'] ?? 'closed') === 'open')
                                        <span class="text-emerald-600">Open Access</span>
                                    @else
                                        Closed / Paywall
                                    @endif
                                </p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center shrink-0 text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-0.5">API Provider</p>
                                <p class="text-sm font-medium text-slate-900">{{ $paper['api_source'] ?? 'ScholarFlow Aggregate' }}</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Citation Formats Placeholder -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                    <h3 class="font-poppins text-lg font-bold text-slate-900 mb-4">Quick Citations</h3>
                    <div class="space-y-4">
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs font-bold text-slate-500">APA</span>
                                <button class="text-blue-600 hover:text-blue-800 text-xs font-medium">Copy</button>
                            </div>
                            <p class="text-sm text-slate-700 font-serif line-clamp-2">Loading APA citation format...</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs font-bold text-slate-500">MLA</span>
                                <button class="text-blue-600 hover:text-blue-800 text-xs font-medium">Copy</button>
                            </div>
                            <p class="text-sm text-slate-700 font-serif line-clamp-2">Loading MLA citation format...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Papers Placeholder -->
        <div class="mt-16 pt-12 border-t border-slate-200">
            <h3 class="font-poppins text-2xl font-bold text-slate-900 mb-8">Related Papers</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Skeleton Card 1 -->
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm animate-pulse">
                    <div class="h-5 bg-slate-200 rounded-md w-3/4 mb-3"></div>
                    <div class="h-5 bg-slate-200 rounded-md w-1/2 mb-4"></div>
                    <div class="h-4 bg-slate-100 rounded-md w-full mb-2"></div>
                    <div class="h-4 bg-slate-100 rounded-md w-5/6 mb-6"></div>
                    <div class="flex justify-between items-center">
                        <div class="h-4 bg-slate-200 rounded-md w-1/4"></div>
                        <div class="h-8 bg-slate-100 rounded-xl w-20"></div>
                    </div>
                </div>
                <!-- Skeleton Card 2 -->
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm animate-pulse hidden md:block">
                    <div class="h-5 bg-slate-200 rounded-md w-5/6 mb-3"></div>
                    <div class="h-5 bg-slate-200 rounded-md w-2/3 mb-4"></div>
                    <div class="h-4 bg-slate-100 rounded-md w-full mb-2"></div>
                    <div class="h-4 bg-slate-100 rounded-md w-4/6 mb-6"></div>
                    <div class="flex justify-between items-center">
                        <div class="h-4 bg-slate-200 rounded-md w-1/3"></div>
                        <div class="h-8 bg-slate-100 rounded-xl w-20"></div>
                    </div>
                </div>
                <!-- Skeleton Card 3 -->
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm animate-pulse hidden md:block">
                    <div class="h-5 bg-slate-200 rounded-md w-4/5 mb-3"></div>
                    <div class="h-5 bg-slate-200 rounded-md w-1/2 mb-4"></div>
                    <div class="h-4 bg-slate-100 rounded-md w-full mb-2"></div>
                    <div class="h-4 bg-slate-100 rounded-md w-5/6 mb-6"></div>
                    <div class="flex justify-between items-center">
                        <div class="h-4 bg-slate-200 rounded-md w-1/4"></div>
                        <div class="h-8 bg-slate-100 rounded-xl w-20"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <span class="font-poppins font-bold text-slate-900">ScholarFlow</span>
            </div>
            <p class="text-sm text-slate-500">© {{ date('Y') }} ScholarFlow Research Platform. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>