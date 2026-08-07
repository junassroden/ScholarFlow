@php
    $userName = Auth::user()->username ?? 'Researcher';
    $history = collect($history); // <-- FIX: ensures Collection methods work
@endphp
<!DOCTYPE html>
<html lang="en" class="bg-[#F8FAFC] text-slate-800 antialiased">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScholarFlow - Search History</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .font-poppins { font-family: 'Poppins', sans-serif; }
        .font-inter { font-family: 'Inter', sans-serif; }
        #toast {
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        #toast.show { transform: translateX(0); opacity: 1; }
        #toast.hide { transform: translateX(100%); opacity: 0; }
        .modal-overlay { background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px); }
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

    <!-- ====== CONFIRMATION MODAL ====== -->
    <div id="confirm-modal" class="fixed inset-0 z-50 flex items-center justify-center modal-overlay hidden p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl">
            <div class="flex items-center gap-3 text-red-600 mb-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                <h3 class="font-poppins text-xl font-bold">Clear History?</h3>
            </div>
            <p class="text-slate-600 text-sm mb-6">This will permanently remove all your search history. This action cannot be undone.</p>
            <div class="flex justify-end gap-3">
                <button onclick="closeConfirmModal()" class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl transition-colors">Cancel</button>
                <button id="confirm-clear-btn" class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl transition-colors">Clear All History</button>
            </div>
        </div>
    </div>

    <!-- ====== MOBILE OVERLAY ====== -->
    <div id="mobile-overlay" class="fixed inset-0 bg-slate-900/20 z-40 hidden transition-opacity opacity-0 backdrop-blur-sm lg:hidden" onclick="toggleSidebar()"></div>

    <!-- ====== SIDEBAR ====== -->
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

        <!-- User Profile -->
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

            <!-- Header -->
            <div class="flex items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="font-poppins text-3xl font-bold text-slate-900 tracking-tight">Search History</h1>
                    <p class="text-sm text-slate-500 mt-1">Review your recent queries, filter settings, and viewed papers.</p>
                </div>
                @if($history->count() > 0)
                    <button onclick="openConfirmModal()" class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-medium rounded-xl transition-colors">
                        Clear History
                    </button>
                @endif
            </div>

            <!-- History Entries -->
            @if($history->isEmpty())
                <!-- Empty State -->
                <div class="bg-white p-12 rounded-3xl border-2 border-dashed border-slate-200 text-center">
                    <div class="flex flex-col items-center justify-center gap-4">
                        <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center text-blue-400">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <h3 class="font-poppins text-2xl font-bold text-slate-800">No Search History</h3>
                            <p class="text-slate-500 text-sm max-w-md mt-1">Your search queries will appear here. Start exploring research papers on the Dashboard.</p>
                        </div>
                        <a href="{{ route('dashboard') }}" class="mt-4 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-sm transition-colors">
                            Go to Dashboard
                        </a>
                    </div>
                </div>
            @else
                <!-- Group by date -->
                @php
                    $groups = $history->groupBy(function($item) {
                        return \Carbon\Carbon::parse($item->searched_at)->format('Y-m-d');
                    });
                @endphp

                @foreach($groups as $date => $items)
                    <div class="mb-8">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">
                            {{ \Carbon\Carbon::parse($date)->isToday() ? 'Today' : (\Carbon\Carbon::parse($date)->isYesterday() ? 'Yesterday' : \Carbon\Carbon::parse($date)->format('F j, Y')) }}
                        </h3>
                        <div class="space-y-3">
                            @foreach($items as $item)
                                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div class="flex items-center gap-4 min-w-0">
                                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-medium text-slate-900 truncate">"{{ $item->keyword }}"</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Searched on {{ \Carbon\Carbon::parse($item->searched_at)->format('M j, Y g:i A') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 shrink-0">
                                        <span class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($item->searched_at)->diffForHumans() }}</span>
                                        <a href="{{ route('dashboard') }}?q={{ urlencode($item->keyword) }}&year={{ $item->filters['year'] ?? '' }}&source={{ $item->filters['source'] ?? '' }}&open_access={{ $item->filters['open_access'] ?? '' }}&sort={{ $item->filters['sort'] ?? '' }}"
                                           class="px-3.5 py-1.5 bg-slate-50 hover:bg-blue-50 text-slate-700 hover:text-blue-700 text-xs font-medium rounded-lg border border-slate-200 transition-colors">
                                            Rerun Search
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </main>

    <!-- SCRIPTS -->
    <script>
        // ===== TOAST =====
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

        // ===== CONFIRM MODAL =====
        function openConfirmModal() {
            document.getElementById('confirm-modal').classList.remove('hidden');
        }

        function closeConfirmModal() {
            document.getElementById('confirm-modal').classList.add('hidden');
        }

        // ===== SIDEBAR TOGGLE =====
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

        // ===== CLEAR HISTORY =====
        document.getElementById('confirm-clear-btn').addEventListener('click', async function() {
            try {
                const response = await fetch('/history/clear', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();

                if (response.ok) {
                    showToast('Cleared', data.message, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast('Error', data.message || 'Failed to clear history.', 'error');
                }
            } catch (e) {
                showToast('Error', 'Network error. Please try again.', 'error');
            }
            closeConfirmModal();
        });

        // Close modal on overlay click
        document.getElementById('confirm-modal').addEventListener('click', function(e) {
            if (e.target === this) closeConfirmModal();
        });
    </script>
</body>
</html>