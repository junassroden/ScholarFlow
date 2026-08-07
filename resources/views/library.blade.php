@php
    $userName = Auth::user()->username ?? 'Researcher';
@endphp
<!DOCTYPE html>
<html lang="en" class="bg-[#F8FAFC] text-slate-800 antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScholarFlow - My Library</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .font-poppins { font-family: 'Poppins', sans-serif; }
        .font-inter { font-family: 'Inter', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        #toast { transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55); }
        #toast.show { transform: translateX(0); opacity: 1; }
        #toast.hide { transform: translateX(100%); opacity: 0; }
        .modal-overlay { background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px); transition: opacity 0.2s; }
        .modal-content { transition: transform 0.2s ease-out; }
    </style>
</head>
<body class="font-inter flex min-h-screen overflow-x-hidden selection:bg-blue-100 selection:text-blue-900">

    <!-- ====== TOAST ====== -->
    <div id="toast" class="fixed top-6 right-6 z-[100] transform translate-x-full opacity-0">
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

    <!-- ====== VIEW PAPER MODAL ====== -->
    <div id="view-modal" class="fixed inset-0 z-50 flex items-center justify-center modal-overlay hidden p-4">
        <div class="bg-white rounded-3xl max-w-2xl w-full max-h-[90vh] overflow-y-auto p-6 shadow-2xl modal-content">
            <div class="flex justify-between items-start mb-4">
                <h2 id="view-title" class="font-poppins text-2xl font-bold text-slate-900 pr-8"></h2>
                <button onclick="closeViewModal()" class="p-2 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="space-y-3 text-sm">
                <p><span class="font-semibold">Authors:</span> <span id="view-authors"></span></p>
                <p><span class="font-semibold">Year:</span> <span id="view-year"></span></p>
                <p><span class="font-semibold">Journal:</span> <span id="view-journal"></span></p>
                <p><span class="font-semibold">DOI:</span> <span id="view-doi"></span></p>
                <div>
                    <p class="font-semibold">Abstract:</p>
                    <p id="view-abstract" class="text-slate-600 leading-relaxed mt-1"></p>
                </div>
                <div id="view-external" class="pt-2">
                    <a href="#" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 font-medium text-sm">
                        Read Original Paper ↗
                    </a>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button onclick="closeViewModal()" class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl transition-colors">Close</button>
            </div>
        </div>
    </div>

    <!-- ====== DELETE CONFIRMATION MODAL ====== -->
    <div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center modal-overlay hidden p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl modal-content">
            <div class="flex items-center gap-3 text-red-600 mb-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                <h3 class="font-poppins text-xl font-bold">Remove from Library?</h3>
            </div>
            <p class="text-slate-600 text-sm mb-6">
                Are you sure you want to remove <strong id="delete-title" class="text-slate-900"></strong> from your library?
            </p>
            <div class="flex justify-end gap-3">
                <button onclick="closeDeleteModal()" class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl transition-colors">Cancel</button>
                <button id="confirm-delete-btn" class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl transition-colors">Remove Paper</button>
            </div>
        </div>
    </div>

    <!-- ====== MOBILE OVERLAY ====== -->
    <div id="mobile-overlay" class="fixed inset-0 bg-slate-900/20 z-40 hidden transition-opacity opacity-0 backdrop-blur-sm lg:hidden" onclick="toggleSidebar()"></div>

    <!-- ====== SIDEBAR ====== -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-white border-r border-slate-100 z-50 flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-300 shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
        <div class="h-20 flex items-center px-8 border-b border-slate-50">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <span class="font-poppins font-bold text-xl text-slate-900 tracking-tight">ScholarFlow</span>
            </div>
        </div>
        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
            <p class="px-4 text-xs font-semibold text-slate-400 tracking-wider uppercase mb-3">Menu</p>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                Dashboard
            </a>
            <a href="{{ route('library') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl bg-blue-50 text-blue-700 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                My Library
            </a>
            <a href="{{ route('assistant') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-colors">
                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                AI Assistant
            </a>
            <a href="{{ route('history') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-colors">
                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                History
            </a>
        </nav>
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

    <!-- ====== MAIN CONTENT ====== -->
    <main class="flex-1 lg:ml-72 flex flex-col relative w-full h-screen overflow-y-auto">
        <!-- Mobile Header -->
        <div class="lg:hidden flex items-center justify-between p-4 bg-white/80 backdrop-blur-md sticky top-0 z-30 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                </div>
                <span class="font-poppins font-bold text-lg text-slate-900">ScholarFlow</span>
            </div>
            <button onclick="toggleSidebar()" class="p-2 text-slate-500 rounded-lg hover:bg-slate-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
            </button>
        </div>

        <!-- Library Container -->
        <div class="w-full max-w-5xl mx-auto px-4 sm:px-8 py-8 flex-1">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="font-poppins text-3xl font-bold text-slate-900 tracking-tight">My Library</h1>
                    <p class="text-sm text-slate-500 mt-1">Organize and read your saved research papers.</p>
                </div>
                <div class="flex items-center gap-3">
                    <button class="px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-xl shadow-sm transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                        Export
                    </button>
                    <button class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl shadow-sm transition-colors flex items-center gap-2">
                        + New Collection
                    </button>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 bg-white p-4 rounded-2xl border border-slate-200 shadow-[0_2px_10px_rgb(0,0,0,0.02)]">
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar">
                    <button id="all-saved-count" class="px-4 py-2 bg-blue-50 text-blue-700 font-semibold text-sm rounded-xl whitespace-nowrap">All Saved ({{ $savedPapers->count() }})</button>
                    <button class="px-4 py-2 hover:bg-slate-50 text-slate-600 font-medium text-sm rounded-xl whitespace-nowrap transition-colors">Favorites</button>
                    <button class="px-4 py-2 hover:bg-slate-50 text-slate-600 font-medium text-sm rounded-xl whitespace-nowrap transition-colors">Unread</button>
                </div>
                <div class="flex items-center gap-2 pt-4 md:pt-0 border-t md:border-t-0 md:border-l border-slate-100 md:pl-4">
                    <div class="relative flex-1 md:w-56">
                        <svg class="w-4 h-4 absolute left-3 top-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        <input type="text" placeholder="Filter library..." class="w-full pl-9 pr-3 py-1.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <select class="bg-blue-50 border border-blue-100 text-blue-700 text-sm font-semibold rounded-xl px-3 py-1.5 focus:outline-none cursor-pointer">
                        <option>Recently Added</option>
                        <option>Title (A-Z)</option>
                    </select>
                </div>
            </div>

            <!-- Papers Feed -->
            <div id="library-feed">
                @if($savedPapers->isEmpty())
                    <div id="empty-state" class="bg-white p-12 rounded-3xl border-2 border-dashed border-slate-200 text-center">
                        <div class="flex flex-col items-center justify-center gap-4">
                            <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center text-blue-400">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                            </div>
                            <div>
                                <h3 class="font-poppins text-2xl font-bold text-slate-800">No Saved Papers Yet</h3>
                                <p class="text-slate-500 text-sm max-w-md mt-1">Your saved research papers will appear here.</p>
                            </div>
                            <a href="{{ route('dashboard') }}" class="mt-4 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-sm transition-colors">
                                Explore Research
                            </a>
                        </div>
                    </div>
                @else
                    @foreach($savedPapers as $paper)
                        <div class="library-card bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300" data-paper-id="{{ $paper->id }}">
                            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-3">
                                <div>
                                    <span class="inline-block px-2.5 py-1 mb-2 bg-purple-50 text-purple-700 font-semibold text-xs rounded-md">
                                        {{ $paper->api_source ?? 'Saved' }}
                                    </span>
                                    <h2 class="font-poppins text-lg font-bold text-slate-900 leading-tight">{{ $paper->title }}</h2>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <!-- View Button -->
                                    <button class="view-paper-btn p-2 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors" title="View Paper" data-paper='@json($paper)'>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </button>
                                    <!-- Delete Button -->
                                    <button class="delete-btn p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" data-paper-id="{{ $paper->id }}" data-paper-title="{{ $paper->title }}" title="Remove from Library">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center gap-x-2 gap-y-1 mb-3 text-sm">
                                <span class="font-medium text-slate-700">{{ $paper->authors ?? 'Unknown author' }}</span>
                                <span class="text-slate-300">•</span>
                                <span class="text-blue-600 font-medium">{{ $paper->journal ?? 'Preprint' }}</span>
                                @if($paper->publication_year)
                                    <span class="text-slate-300">•</span>
                                    <span class="text-slate-500">{{ $paper->publication_year }}</span>
                                @endif
                            </div>
                            <p class="text-slate-600 text-sm leading-relaxed mb-6 line-clamp-2">
                                {{ $paper->abstract ?? 'No abstract available.' }}
                            </p>
                            <div class="flex flex-wrap items-center gap-3 pt-4 border-t border-slate-50">
                                @if($paper->pdf_url)
                                    <a href="{{ $paper->pdf_url }}" target="_blank" rel="noopener" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl shadow-sm transition-colors">View PDF</a>
                                @else
                                    <span class="px-4 py-2 bg-slate-100 text-slate-400 text-sm font-medium rounded-xl cursor-not-allowed">No PDF</span>
                                @endif
                                <button class="px-4 py-2 bg-purple-50 hover:bg-purple-100 text-purple-700 text-sm font-medium rounded-xl transition-colors flex items-center gap-2">
                                    <span class="text-purple-500">✨</span> Notes
                                </button>
                                <button class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-xl transition-colors ml-auto">Cite</button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </main>

    <script>
        // ============================================
        // TOAST (same as dashboard)
        // ============================================
        function showToast(title, message, type = 'success') {
            const toast = document.getElementById('toast');
            const icon = document.getElementById('toast-icon');
            const titleEl = document.getElementById('toast-title');
            const msgEl = document.getElementById('toast-message');

            toast.className = 'fixed top-6 right-6 z-[100] transform translate-x-full opacity-0';
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
        // VIEW PAPER MODAL
        // ============================================
        function openViewModal(paper) {
            document.getElementById('view-title').textContent = paper.title;
            document.getElementById('view-authors').textContent = paper.authors || 'Unknown';
            document.getElementById('view-year').textContent = paper.publication_year || 'N/A';
            document.getElementById('view-journal').textContent = paper.journal || 'Preprint';
            document.getElementById('view-abstract').textContent = paper.abstract || 'No abstract available.';

            const doiEl = document.getElementById('view-doi');
            if (paper.doi) {
                doiEl.innerHTML = `<a href="https://doi.org/${paper.doi}" target="_blank" rel="noopener" class="text-blue-600 hover:underline">${paper.doi}</a>`;
            } else {
                doiEl.textContent = 'N/A';
            }

            const externalEl = document.getElementById('view-external');
            if (paper.pdf_url || paper.link) {
                const url = paper.pdf_url || paper.link;
                externalEl.innerHTML = `<a href="${url}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 font-medium text-sm">Read Original Paper ↗</a>`;
                externalEl.style.display = 'block';
            } else {
                externalEl.style.display = 'none';
            }

            document.getElementById('view-modal').classList.remove('hidden');
        }

        function closeViewModal() {
            document.getElementById('view-modal').classList.add('hidden');
        }

        // ============================================
        // DELETE CONFIRMATION
        // ============================================
        let deleteTargetId = null;

        function openDeleteModal(paperId, paperTitle) {
            deleteTargetId = paperId;
            document.getElementById('delete-title').textContent = paperTitle;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            deleteTargetId = null;
            document.getElementById('delete-modal').classList.add('hidden');
        }

        // ============================================
        // EVENT LISTENERS
        // ============================================
        document.addEventListener('DOMContentLoaded', function() {
            // View buttons
            document.querySelectorAll('.view-paper-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const paper = JSON.parse(this.dataset.paper);
                    openViewModal(paper);
                });
            });

            // Delete buttons – open confirmation modal
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.paperId;
                    const title = this.dataset.paperTitle;
                    openDeleteModal(id, title);
                });
            });

            // Confirm delete – FIXED URL & COUNT UPDATE
            document.getElementById('confirm-delete-btn').addEventListener('click', async function() {
                const id = deleteTargetId;
                if (!id) return;

                this.disabled = true;
                this.textContent = 'Removing...';

                try {
                    const response = await fetch(`/library/remove/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });
                    const data = await response.json();

                    if (response.ok) {
                        // Remove card from DOM
                        const card = document.querySelector(`.library-card[data-paper-id="${id}"]`);
                        if (card) card.remove();

                        // Update the "All Saved" count safely
                        const countEl = document.getElementById('all-saved-count');
                        if (countEl) {
                            const currentText = countEl.textContent;
                            const match = currentText.match(/\d+/);
                            if (match) {
                                let currentCount = parseInt(match[0]);
                                if (currentCount > 0) {
                                    const newCount = currentCount - 1;
                                    countEl.textContent = `All Saved (${newCount})`;
                                }
                            }
                        }

                        showToast('Removed', data.message, 'success');

                        // If no cards left, show the empty state
                        if (!document.querySelector('.library-card')) {
                            const feed = document.getElementById('library-feed');
                            if (feed) {
                                feed.innerHTML = `
                                    <div id="empty-state" class="bg-white p-12 rounded-3xl border-2 border-dashed border-slate-200 text-center">
                                        <div class="flex flex-col items-center justify-center gap-4">
                                            <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center text-blue-400">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                            </div>
                                            <div>
                                                <h3 class="font-poppins text-2xl font-bold text-slate-800">No Saved Papers Yet</h3>
                                                <p class="text-slate-500 text-sm max-w-md mt-1">Your saved research papers will appear here.</p>
                                            </div>
                                            <a href="{{ route('dashboard') }}" class="mt-4 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-sm transition-colors">
                                                Explore Research
                                            </a>
                                        </div>
                                    </div>
                                `;
                            }
                        }

                        closeDeleteModal();
                    } else {
                        showToast('Error', data.message || 'Failed to remove.', 'error');
                    }
                } catch (e) {
                    console.error('Delete error:', e);
                    showToast('Error', 'Network error. Please try again.', 'error');
                } finally {
                    this.disabled = false;
                    this.textContent = 'Remove Paper';
                }
            });

            // Close modals on overlay click
            document.getElementById('view-modal').addEventListener('click', function(e) {
                if (e.target === this) closeViewModal();
            });
            document.getElementById('delete-modal').addEventListener('click', function(e) {
                if (e.target === this) closeDeleteModal();
            });
        });

        // ============================================
        // SIDEBAR TOGGLE
        // ============================================
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