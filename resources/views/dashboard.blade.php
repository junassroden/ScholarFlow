@php
    use Illuminate\Support\Facades\Auth;

    $userName = Auth::user()->username;
    $userEmail = Auth::user()->email;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | ScholarFlow</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            500: '#2563EB',
                            600: '#1D4ED8',
                            bg: '#F8FAFC',
                            text: '#111827',
                            muted: '#6B7280',
                            border: '#E5E7EB'
                        }
                    },
                    fontFamily: {
                        heading: ['Poppins', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="font-body bg-brand-bg text-brand-text antialiased min-h-screen flex">

    <!-- Sidebar Navigation -->
    <aside class="w-64 bg-white border-r border-brand-border flex flex-col justify-between hidden md:flex">
        <div>
            <!-- Logo Header -->
            <div class="p-6 border-b border-brand-border">
                <a href="{{ route('home') }}" class="flex items-center gap-2 font-heading text-xl font-bold text-brand-500">
                    <span>📘 ScholarFlow</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-lg bg-blue-50 text-brand-500">
                    <span>📊</span> Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-lg text-brand-muted hover:bg-brand-bg hover:text-brand-text transition-colors">
                    <span>🔍</span> Search Papers
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-lg text-brand-muted hover:bg-brand-bg hover:text-brand-text transition-colors">
                    <span>📁</span> Collections
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-lg text-brand-muted hover:bg-brand-bg hover:text-brand-text transition-colors">
                    <span>📝</span> Citations & Notes
                </a>
            </nav>
        </div>

        <!-- User Profile Footer in Sidebar -->
        <div class="p-4 border-t border-brand-border">
            <div class="flex items-center gap-3 mb-3 px-2">
                <div class="w-9 h-9 rounded-full bg-blue-100 text-brand-500 font-bold flex items-center justify-center">
                    {{ strtoupper(substr($userName, 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-bold text-brand-text truncate">{{ $userName }}</p>
                    <p class="text-xs text-brand-muted truncate">{{ $userEmail }}</p>
                </div>
            </div>
            
            <!-- Laravel POST Logout Form -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="block w-full text-center px-4 py-2 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                    Log Out
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col min-w-0">
        
        <!-- Top Header Bar -->
        <header class="bg-white border-b border-brand-border h-16 flex items-center justify-between px-6">
            <h1 class="font-heading text-lg font-bold text-brand-text">Welcome back, {{ $userName }}! 👋</h1>
            <div class="flex items-center gap-4">
                <span class="text-xs font-semibold bg-blue-50 text-brand-500 px-3 py-1.5 rounded-full">Free Plan</span>
            </div>
        </header>

        <!-- Dashboard Body Content -->
        <div class="p-6 md:p-8 space-y-6 max-w-7xl w-full mx-auto">
            
            <!-- Quick Stat Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl border border-brand-border shadow-sm">
                    <p class="text-xs font-semibold text-brand-muted uppercase">Saved Papers</p>
                    <h3 class="text-3xl font-bold font-heading text-brand-text mt-2">12</h3>
                    <p class="text-xs text-green-600 mt-1 font-medium">+2 added this week</p>
                </div>
                <div class="bg-white p-6 rounded-xl border border-brand-border shadow-sm">
                    <p class="text-xs font-semibold text-brand-muted uppercase">Active Collections</p>
                    <h3 class="text-3xl font-bold font-heading text-brand-text mt-2">4</h3>
                    <p class="text-xs text-brand-muted mt-1">Across 3 research topics</p>
                </div>
                <div class="bg-white p-6 rounded-xl border border-brand-border shadow-sm">
                    <p class="text-xs font-semibold text-brand-muted uppercase">Citations Generated</p>
                    <h3 class="text-3xl font-bold font-heading text-brand-text mt-2">28</h3>
                    <p class="text-xs text-blue-600 mt-1 font-medium">APA, IEEE, MLA</p>
                </div>
            </div>

            <!-- Search Quick Bar -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 md:p-8 text-white shadow-md">
                <h2 class="font-heading text-xl md:text-2xl font-bold mb-2">Ready to explore new research?</h2>
                <p class="text-blue-100 text-sm mb-6 max-w-xl">Search instantly across Semantic Scholar, arXiv, and Crossref repositories.</p>
                
                <div class="flex gap-2 bg-white p-2 rounded-xl shadow-lg max-w-2xl">
                    <input type="text" placeholder="Search by paper title, keyword, or author..." class="flex-1 px-4 py-2 text-sm text-brand-text focus:outline-none">
                    <button class="bg-brand-500 hover:bg-brand-600 text-white font-medium px-6 py-2.5 rounded-lg text-sm transition-colors">
                        Search
                    </button>
                </div>
            </div>

            <!-- Recent Activity / Saved Papers Section -->
            <div class="bg-white border border-brand-border rounded-xl p-6 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-heading font-bold text-base text-brand-text">Recent Saved Papers</h3>
                    <a href="#" class="text-xs font-semibold text-brand-500 hover:underline">View All</a>
                </div>

                <div class="divide-y divide-brand-border">
                    <div class="py-3 flex justify-between items-center">
                        <div>
                            <h4 class="text-sm font-bold text-brand-text hover:text-brand-500 cursor-pointer">Deep Learning in Healthcare: A Comprehensive Survey</h4>
                            <p class="text-xs text-brand-muted mt-0.5">John Doe et al. • Published 2025</p>
                        </div>
                        <span class="text-xs bg-blue-50 text-brand-500 px-2.5 py-1 rounded-full font-semibold">1,245 Citations</span>
                    </div>
                    <div class="py-3 flex justify-between items-center">
                        <div>
                            <h4 class="text-sm font-bold text-brand-text hover:text-brand-500 cursor-pointer">Zero Trust Architecture implementation in Cloud Infrastructure</h4>
                            <p class="text-xs text-brand-muted mt-0.5">Alice Smith • Published 2026</p>
                        </div>
                        <span class="text-xs bg-blue-50 text-brand-500 px-2.5 py-1 rounded-full font-semibold">890 Citations</span>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>