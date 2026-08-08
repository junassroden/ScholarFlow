@php
    $userName = auth()->user()?->username ?? 'Researcher';
@endphp
<!DOCTYPE html>
<html lang="en" class="bg-[#F8FAFC] text-slate-800 antialiased">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $paper['title'] ?? 'Paper Details' }} - ScholarFlow</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .font-poppins { font-family: 'Poppins', sans-serif; }
        .font-inter { font-family: 'Inter', sans-serif; }
        .fade-in-up { animation: fadeSlideUp 0.6s cubic-bezier(0.25, 1, 0.5, 1) forwards; }
        @keyframes fadeSlideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .toast { transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55); }
        .toast.show { transform: translateX(0); opacity: 1; }
        .toast.hide { transform: translateX(100%); opacity: 0; }
        .citation-btn.active { background-color: #2563eb; color: white; border-color: #2563eb; }
        .citation-btn { transition: all 0.2s; }
    </style>
</head>

<body class="font-inter min-h-screen overflow-x-hidden selection:bg-blue-100 selection:text-blue-900 flex flex-col">

    <!-- TOAST -->
    <div id="toast" class="fixed top-6 right-6 z-[100] transform translate-x-full opacity-0 toast">
        <div class="flex items-start gap-3 bg-white border border-slate-200 shadow-xl rounded-2xl px-5 py-4 min-w-[280px] max-w-sm">
            <div id="toast-icon" class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div class="flex-1">
                <p id="toast-title" class="font-semibold text-slate-900 text-sm">Success</p>
                <p id="toast-message" class="text-slate-500 text-sm leading-relaxed"></p>
            </div>
            <button onclick="hideToast()" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>

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
                @if($paper['open_access'] ?? false)
                <span class="text-slate-400 hidden sm:inline">•</span>
                <span class="inline-flex items-center gap-1 text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md text-xs font-semibold">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                    Open Access
                </span>
                @endif
            </div>

            <h1 class="font-poppins text-3xl sm:text-4xl md:text-5xl font-bold text-slate-900 mb-6 leading-tight tracking-tight">{{ $paper['title'] ?? 'Untitled Paper' }}</h1>
            <div class="mb-10 text-lg text-slate-600 font-medium">{{ $paper['authors'] ?? 'Unknown Authors' }}</div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-3 pt-6 border-t border-slate-100">
                @if(!empty($paper['pdf_url']))
                <a href="{{ $paper['pdf_url'] }}" target="_blank" rel="noopener noreferrer" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Download PDF
                </a>
                @endif
                <a href="{{ $paper['link'] ?? '#' }}" target="_blank" rel="noopener noreferrer" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    View Original
                </a>

                <!-- Save Button -->
                <button onclick="savePaper()" id="save-btn" data-doi="{{ $paper['doi'] ?? '' }}"
                        class="px-5 py-3 font-medium rounded-xl transition-all flex items-center gap-2 shadow-sm disabled:opacity-70 disabled:cursor-not-allowed
                        {{ ($isSaved ?? false) ? 'bg-emerald-600 border-emerald-600 text-white hover:bg-emerald-700' : 'bg-white border border-slate-200 hover:border-blue-300 hover:bg-blue-50 text-slate-700' }}">
                    <span id="save-icon">
                        @if($isSaved ?? false)
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                        @endif
                    </span>
                    <span id="save-text">{{ ($isSaved ?? false) ? 'Saved' : 'Save' }}</span>
                    <span id="save-spinner" class="hidden w-4 h-4 border-2 border-slate-300 border-t-blue-600 rounded-full animate-spin"></span>
                </button>

                <!-- AI Summary -->
                <button onclick="generateAISummary()" class="px-5 py-3 bg-purple-50 border border-purple-100 hover:bg-purple-100 text-purple-700 font-medium rounded-xl transition-colors flex items-center gap-2 shadow-sm">
                    <span class="text-purple-500">✨</span> <span id="ai-summary-text">AI Summary</span>
                    <span id="ai-spinner" class="hidden w-4 h-4 border-2 border-purple-300 border-t-purple-600 rounded-full animate-spin"></span>
                </button>

                <!-- Cite -->
                <button onclick="openModal('citation-modal')" class="px-5 py-3 bg-white border border-slate-200 hover:border-blue-300 hover:bg-blue-50 text-slate-700 font-medium rounded-xl transition-all flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Cite
                </button>

                <!-- Share -->
                <button onclick="sharePaper()" class="px-5 py-3 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium rounded-xl transition-colors flex items-center justify-center shadow-sm w-12 sm:w-auto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                    <span class="hidden sm:inline ml-2">Share</span>
                </button>
            </div>
        </div>

        <!-- 2-Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-8">

                <!-- Abstract -->
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-200 shadow-sm">
                    <h2 class="font-poppins text-xl font-bold text-slate-900 mb-4">Abstract</h2>
                    @if(!empty($paper['abstract']) && $paper['abstract'] !== 'No abstract available.')
                        <p class="text-slate-700 leading-loose">{{ $paper['abstract'] }}</p>
                    @else
                        <p class="text-slate-500 italic">No abstract available for this paper.</p>
                    @endif
                </div>

                <!-- PDF Viewer -->
                @if(!empty($paper['pdf_url']))
                <div class="bg-white p-4 md:p-6 rounded-3xl border border-slate-200 shadow-sm">
                    <h2 class="font-poppins text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Full Text PDF
                    </h2>
                    <div class="relative w-full" style="height: 600px;">
                        <iframe src="{{ $paper['pdf_url'] }}" class="w-full h-full rounded-xl border border-slate-200" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <p class="text-sm text-slate-500 mt-3">
                        <a href="{{ $paper['pdf_url'] }}" target="_blank" class="text-blue-600 hover:underline">Open PDF in new tab</a>
                    </p>
                </div>
                @else
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm text-center py-12">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <h3 class="font-poppins text-xl font-semibold text-slate-800 mb-2">Full Text Not Available</h3>
                    <p class="text-slate-500">We couldn't find a freely accessible version of this paper.
                        <a href="{{ $paper['link'] ?? '#' }}" target="_blank" class="text-blue-600 hover:underline">View on publisher's site</a>.
                    </p>
                </div>
                @endif

                <!-- AI Summary Display -->
                <div id="ai-summary-container" class="bg-gradient-to-br from-purple-50 to-white p-6 md:p-8 rounded-3xl border border-purple-100 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-purple-200 rounded-full blur-3xl opacity-50"></div>
                    <h2 class="font-poppins text-xl font-bold text-slate-900 mb-4 flex items-center gap-2 relative z-10">
                        <span class="text-purple-500">✨</span> AI Analysis
                    </h2>
                    <div id="ai-summary-content" class="relative z-10 bg-white/60 backdrop-blur-sm rounded-2xl p-6 border border-purple-50/50 text-center">
                        <p class="text-purple-600 font-medium mb-3">AI Summary coming soon...</p>
                        <p class="text-slate-500 text-sm">Click the "AI Summary" button above to generate key insights.</p>
                    </div>
                </div>

                <!-- Keywords & DOI -->
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                    @if(!empty($paper['keywords']) && is_array($paper['keywords']) && count($paper['keywords']) > 0)
                    <div>
                        <h3 class="font-poppins text-lg font-semibold text-slate-900 mb-3">Keywords</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($paper['keywords'] as $keyword)
                                <span class="px-4 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-600 hover:bg-slate-100 cursor-pointer transition-colors">{{ $keyword }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if(!empty($paper['doi']))
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

            <!-- Right Column -->
            <div class="space-y-8">
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                    <h3 class="font-poppins text-lg font-bold text-slate-900 mb-6">Paper Details</h3>
                    <ul class="space-y-5">
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center shrink-0 text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-0.5">Publication Year</p><p class="text-sm font-medium text-slate-900">{{ $paper['year'] ?? 'N/A' }}</p></div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center shrink-0 text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                            </div>
                            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-0.5">Source / Venue</p><p class="text-sm font-medium text-slate-900">{{ $paper['source'] ?? 'Unknown' }}</p></div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center shrink-0 text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            </div>
                            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-0.5">Citation Count</p><p class="text-sm font-medium text-slate-900">{{ number_format($paper['citations'] ?? 0) }}</p></div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center shrink-0 text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-0.5">Authors</p><p class="text-sm font-medium text-slate-900 line-clamp-3">{{ $paper['authors'] ?? 'Unknown' }}</p></div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center shrink-0 text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                            </div>
                            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-0.5">Access Status</p>
                                <p class="text-sm font-medium text-slate-900">
                                    @if($paper['open_access'] ?? false) <span class="text-emerald-600">Open Access</span> @else Closed / Paywall @endif
                                </p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center shrink-0 text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                            </div>
                            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-0.5">API Provider</p><p class="text-sm font-medium text-slate-900">{{ $paper['api_source'] ?? 'ScholarFlow Aggregate' }}</p></div>
                        </li>
                    </ul>
                </div>

                <!-- Citation Formats -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                    <h3 class="font-poppins text-lg font-bold text-slate-900 mb-4">Quick Citations</h3>
                    <div class="space-y-4">
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs font-bold text-slate-500">APA</span>
                                <button onclick="copyCitation('apa')" class="text-blue-600 hover:text-blue-800 text-xs font-medium">Copy</button>
                            </div>
                            <p id="citation-preview-apa" class="text-sm text-slate-700 font-serif line-clamp-2">Loading...</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs font-bold text-slate-500">MLA</span>
                                <button onclick="copyCitation('mla')" class="text-blue-600 hover:text-blue-800 text-xs font-medium">Copy</button>
                            </div>
                            <p id="citation-preview-mla" class="text-sm text-slate-700 font-serif line-clamp-2">Loading...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Papers -->
        <div class="mt-16 pt-12 border-t border-slate-200">
            <h3 class="font-poppins text-2xl font-bold text-slate-900 mb-8">Related Papers</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm animate-pulse">
                    <div class="h-5 bg-slate-200 rounded-md w-3/4 mb-3"></div>
                    <div class="h-5 bg-slate-200 rounded-md w-1/2 mb-4"></div>
                    <div class="h-4 bg-slate-100 rounded-md w-full mb-2"></div>
                    <div class="h-4 bg-slate-100 rounded-md w-5/6 mb-6"></div>
                    <div class="flex justify-between items-center"><div class="h-4 bg-slate-200 rounded-md w-1/4"></div><div class="h-8 bg-slate-100 rounded-xl w-20"></div></div>
                </div>
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm animate-pulse hidden md:block">
                    <div class="h-5 bg-slate-200 rounded-md w-5/6 mb-3"></div>
                    <div class="h-5 bg-slate-200 rounded-md w-2/3 mb-4"></div>
                    <div class="h-4 bg-slate-100 rounded-md w-full mb-2"></div>
                    <div class="h-4 bg-slate-100 rounded-md w-4/6 mb-6"></div>
                    <div class="flex justify-between items-center"><div class="h-4 bg-slate-200 rounded-md w-1/3"></div><div class="h-8 bg-slate-100 rounded-xl w-20"></div></div>
                </div>
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm animate-pulse hidden md:block">
                    <div class="h-5 bg-slate-200 rounded-md w-4/5 mb-3"></div>
                    <div class="h-5 bg-slate-200 rounded-md w-1/2 mb-4"></div>
                    <div class="h-4 bg-slate-100 rounded-md w-full mb-2"></div>
                    <div class="h-4 bg-slate-100 rounded-md w-5/6 mb-6"></div>
                    <div class="flex justify-between items-center"><div class="h-4 bg-slate-200 rounded-md w-1/4"></div><div class="h-8 bg-slate-100 rounded-xl w-20"></div></div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span class="font-poppins font-bold text-slate-900">ScholarFlow</span>
            </div>
            <p class="text-sm text-slate-500">© {{ date('Y') }} ScholarFlow Research Platform. All rights reserved.</p>
        </div>
    </footer>

    <!-- Citation Modal -->
    <div id="citation-modal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4 transition-opacity opacity-0">
        <div class="bg-white rounded-3xl w-full max-w-lg overflow-hidden flex flex-col shadow-2xl transform scale-95 transition-transform duration-300 modal-content">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-poppins text-lg font-semibold text-slate-900">Generate Citation</h3>
                <button onclick="closeModal('citation-modal')" class="p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6">
                <div class="flex gap-2 mb-4 overflow-x-auto no-scrollbar pb-2" id="citation-style-tabs">
                    <button onclick="switchCitationStyle('apa')" class="citation-btn px-4 py-1.5 rounded-full border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium whitespace-nowrap active">APA</button>
                    <button onclick="switchCitationStyle('mla')" class="citation-btn px-4 py-1.5 rounded-full border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium whitespace-nowrap">MLA</button>
                    <button onclick="switchCitationStyle('chicago')" class="citation-btn px-4 py-1.5 rounded-full border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium whitespace-nowrap">Chicago</button>
                    <button onclick="switchCitationStyle('ieee')" class="citation-btn px-4 py-1.5 rounded-full border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium whitespace-nowrap">IEEE</button>
                </div>
                <div class="bg-slate-50 border border-slate-200 p-4 rounded-2xl relative group">
                    <p id="citation-text" class="text-slate-800 text-sm font-serif leading-relaxed">Select a citation style above.</p>
                    <button onclick="copyCitationText()" class="absolute top-2 right-2 p-2 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-blue-600 shadow-sm opacity-0 group-hover:opacity-100 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    </button>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                <button onclick="closeModal('citation-modal')" class="px-5 py-2.5 text-slate-600 font-medium hover:bg-slate-200 rounded-xl transition-colors">Close</button>
                <button onclick="copyCitationText()" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow-sm transition-colors flex items-center gap-2">Copy Citation</button>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script>
        // ============================================
        // PAPER DATA AND INITIAL SAVED STATE
        // ============================================
        const paperData = @json($paper);
        const isSaved = @json($isSaved ?? false);

        // ============================================
        // TOAST FUNCTIONS
        // ============================================
        function showToast(title, message, type = 'success') {
            const toast = document.getElementById('toast');
            const icon = document.getElementById('toast-icon');
            const titleEl = document.getElementById('toast-title');
            const msgEl = document.getElementById('toast-message');

            toast.className = 'fixed top-6 right-6 z-[100] transform translate-x-full opacity-0 toast';
            icon.className = 'w-8 h-8 rounded-full flex items-center justify-center shrink-0 mt-0.5';

            if (type === 'success') {
                icon.classList.add('bg-emerald-50', 'text-emerald-600');
                titleEl.textContent = title || 'Success';
            } else if (type === 'error') {
                icon.classList.add('bg-rose-50', 'text-rose-600');
                titleEl.textContent = title || 'Error';
            } else if (type === 'info') {
                icon.classList.add('bg-blue-50', 'text-blue-600');
                titleEl.textContent = title || 'Info';
            }
            msgEl.textContent = message;

            toast.classList.remove('translate-x-full', 'opacity-0');
            toast.classList.add('translate-x-0', 'opacity-100');
            clearTimeout(window.toastTimer);
            window.toastTimer = setTimeout(hideToast, 4500);
        }

        function hideToast() {
            const toast = document.getElementById('toast');
            toast.classList.remove('translate-x-0', 'opacity-100');
            toast.classList.add('translate-x-full', 'opacity-0');
        }

        // ============================================
        // MODAL CONTROLS
        // ============================================
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
            setTimeout(() => modal.classList.add('hidden'), 300);
        }

        // ============================================
        // SAVE PAPER – TOGGLE WITH DOI
        // ============================================
        async function savePaper() {
            const btn = document.getElementById('save-btn');
            const text = document.getElementById('save-text');
            const spinner = document.getElementById('save-spinner');
            const icon = document.getElementById('save-icon');

            if (btn.disabled) return;

            const doi = btn.dataset.doi;
            if (!doi) {
                showToast('Error', 'No DOI found for this paper.', 'error');
                return;
            }

            const isCurrentlySaved = text.textContent === 'Saved' || btn.classList.contains('bg-emerald-600');
            const url = isCurrentlySaved ? `/library/remove/${encodeURIComponent(doi)}` : '/library/save';
            const method = isCurrentlySaved ? 'DELETE' : 'POST';

            btn.disabled = true;
            text.textContent = isCurrentlySaved ? 'Removing...' : 'Saving...';
            spinner.classList.remove('hidden');
            icon.innerHTML = '';

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: isCurrentlySaved ? null : JSON.stringify(paperData)
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    if (isCurrentlySaved) {
                        // Unsave
                        btn.classList.remove('bg-emerald-600', 'border-emerald-600', 'text-white', 'hover:bg-emerald-700');
                        btn.classList.add('bg-white', 'border', 'border-slate-200', 'hover:border-blue-300', 'hover:bg-blue-50', 'text-slate-700');
                        text.textContent = 'Save';
                        icon.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>`;
                        showToast('Removed', 'Paper removed from your library.', 'info');
                    } else {
                        // Save
                        btn.classList.remove('bg-white', 'border-slate-200', 'hover:border-blue-300', 'hover:bg-blue-50', 'text-slate-700');
                        btn.classList.add('bg-emerald-600', 'border-emerald-600', 'text-white', 'hover:bg-emerald-700');
                        text.textContent = 'Saved';
                        icon.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
                        showToast('Saved!', 'Paper added to your library.', 'success');
                    }
                    btn.disabled = false;
                    spinner.classList.add('hidden');
                } else {
                    // Revert
                    btn.disabled = false;
                    text.textContent = isCurrentlySaved ? 'Saved' : 'Save';
                    spinner.classList.add('hidden');
                    if (isCurrentlySaved) {
                        icon.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
                    } else {
                        icon.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>`;
                    }
                    showToast('Error', result.message || 'Something went wrong.', 'error');
                }
            } catch (err) {
                console.error('Save/Unsave error:', err);
                btn.disabled = false;
                text.textContent = isCurrentlySaved ? 'Saved' : 'Save';
                spinner.classList.add('hidden');
                if (isCurrentlySaved) {
                    icon.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
                } else {
                    icon.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>`;
                }
                showToast('Error', 'Network error. Please try again.', 'error');
            }
        }

        // ============================================
        // AI SUMMARY
        // ============================================
        async function generateAISummary() {
            const btn = document.getElementById('ai-summary-text');
            const spinner = document.getElementById('ai-spinner');
            const container = document.getElementById('ai-summary-content');

            btn.textContent = 'Generating...';
            spinner.classList.remove('hidden');

            try {
                const prompt = `Summarize the following research paper:\nTitle: ${paperData.title}\nAuthors: ${paperData.authors}\nAbstract: ${paperData.abstract || 'N/A'}\nProvide a concise summary with key findings and methodology.`;

                const response = await fetch('/assistant/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ message: prompt })
                });

                const data = await response.json();

                if (response.ok && data.reply) {
                    container.innerHTML = `<div class="text-left text-slate-700 leading-relaxed whitespace-pre-wrap">${data.reply}</div>`;
                    showToast('Summary ready!', 'AI analysis generated successfully.', 'success');
                } else {
                    container.innerHTML = `<div class="text-center text-red-600"><p class="font-medium">Failed to generate summary.</p><p class="text-sm">Please try again later.</p></div>`;
                    showToast('Error', 'Unable to generate AI summary.', 'error');
                }
            } catch (err) {
                console.error('AI Summary error:', err);
                container.innerHTML = `<div class="text-center text-red-600"><p class="font-medium">Network error.</p><p class="text-sm">Please check your connection.</p></div>`;
                showToast('Error', 'Network error. Please try again.', 'error');
            } finally {
                btn.textContent = 'AI Summary';
                spinner.classList.add('hidden');
            }
        }

        // ============================================
        // CITATION GENERATION
        // ============================================
        let currentStyle = 'apa';

        function formatCitation(style) {
            const authors = paperData.authors || 'Unknown Author';
            const year = paperData.year || 'n.d.';
            const title = paperData.title || 'Untitled';
            const source = paperData.source || 'Unknown Source';
            const doi = paperData.doi ? `https://doi.org/${paperData.doi}` : '';

            const authorList = authors.split(',').map(a => a.trim());
            let formattedAuthors = '';

            switch (style) {
                case 'apa':
                    if (authorList.length === 1) formattedAuthors = authorList[0];
                    else if (authorList.length === 2) formattedAuthors = authorList.join(' & ');
                    else if (authorList.length > 2) formattedAuthors = authorList[0] + ' et al.';
                    else formattedAuthors = 'Unknown Author';
                    return `${formattedAuthors} (${year}). ${title}. ${source}.${doi ? ' ' + doi : ''}`;
                case 'mla':
                    if (authorList.length === 1) formattedAuthors = authorList[0];
                    else if (authorList.length === 2) formattedAuthors = authorList.join(' and ');
                    else if (authorList.length > 2) formattedAuthors = authorList[0] + ', et al.';
                    else formattedAuthors = 'Unknown Author';
                    return `${formattedAuthors}. "${title}." ${source}, ${year}.${doi ? ' ' + doi : ''}`;
                case 'chicago':
                    if (authorList.length === 1) formattedAuthors = authorList[0];
                    else if (authorList.length === 2) formattedAuthors = authorList.join(' and ');
                    else if (authorList.length > 2) formattedAuthors = authorList[0] + ' et al.';
                    else formattedAuthors = 'Unknown Author';
                    return `${formattedAuthors}. "${title}." ${source} ${year}.${doi ? ' ' + doi : ''}`;
                case 'ieee':
                    if (authorList.length === 1) formattedAuthors = authorList[0];
                    else if (authorList.length === 2) formattedAuthors = authorList.join(' and ');
                    else if (authorList.length > 2) formattedAuthors = authorList[0] + ' et al.';
                    else formattedAuthors = 'Unknown Author';
                    return `${formattedAuthors}, "${title}," ${source}, vol. ${year}, ${year}.${doi ? ' doi: ' + paperData.doi : ''}`;
                default:
                    return title;
            }
        }

        function switchCitationStyle(style) {
            currentStyle = style;
            document.querySelectorAll('.citation-btn').forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white', 'border-blue-600');
                btn.classList.add('border-slate-200', 'text-slate-600');
                if (btn.textContent.trim().toLowerCase() === style) {
                    btn.classList.remove('border-slate-200', 'text-slate-600');
                    btn.classList.add('bg-blue-600', 'text-white', 'border-blue-600');
                }
            });
            document.getElementById('citation-text').textContent = formatCitation(style);
        }

        function copyCitationText() {
            const text = document.getElementById('citation-text').textContent;
            navigator.clipboard.writeText(text).then(() => showToast('Copied!', 'Citation copied to clipboard.', 'success'))
                .catch(() => {
                    const textarea = document.createElement('textarea');
                    textarea.value = text;
                    document.body.appendChild(textarea);
                    textarea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textarea);
                    showToast('Copied!', 'Citation copied to clipboard.', 'success');
                });
        }

        function copyCitation(style) {
            const text = formatCitation(style);
            navigator.clipboard.writeText(text).then(() => showToast('Copied!', `${style.toUpperCase()} citation copied.`, 'success'))
                .catch(() => {
                    const textarea = document.createElement('textarea');
                    textarea.value = text;
                    document.body.appendChild(textarea);
                    textarea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textarea);
                    showToast('Copied!', `${style.toUpperCase()} citation copied.`, 'success');
                });
        }

        // ============================================
        // SHARE PAPER
        // ============================================
        function sharePaper() {
            const url = window.location.href;
            const title = paperData.title || 'Paper';
            const text = `Check out this paper: ${title} - ${paperData.authors || ''}`;
            if (navigator.share) {
                navigator.share({ title, text, url }).then(() => showToast('Shared!', 'Paper shared successfully.', 'success'))
                    .catch(() => {});
            } else {
                navigator.clipboard.writeText(url).then(() => showToast('Link copied!', 'Share link copied to clipboard.', 'success'))
                    .catch(() => prompt('Copy this link to share:', url));
            }
        }

        // ============================================
        // INITIALIZATION
        // ============================================
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('citation-preview-apa').textContent = formatCitation('apa');
            document.getElementById('citation-preview-mla').textContent = formatCitation('mla');

            document.querySelectorAll('.citation-btn').forEach(btn => {
                if (btn.textContent.trim().toLowerCase() === 'apa') {
                    btn.classList.add('bg-blue-600', 'text-white', 'border-blue-600');
                    btn.classList.remove('border-slate-200', 'text-slate-600');
                }
            });
            document.getElementById('citation-text').textContent = formatCitation('apa');
        });
    </script>
</body>
</html>