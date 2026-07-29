<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScholarFlow | Discover. Organize. Understand.</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#EFF6FF',
                            100: '#DBEAFE',
                            500: '#2563EB',
                            600: '#1D4ED8',
                            700: '#1E40AF',
                            bg: '#F8FAFC',
                            text: '#0F172A',
                            muted: '#64748B',
                            border: '#E2E8F0'
                        }
                    },
                    fontFamily: {
                        heading: ['Poppins', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="font-body bg-brand-bg text-brand-text antialiased selection:bg-blue-200 selection:text-blue-900 overflow-x-hidden relative">

    <!-- Ambient Background Lighting -->
    <div class="fixed top-[-10%] left-[-10%] w-[32rem] h-[32rem] bg-blue-100/50 rounded-full mix-blend-multiply filter blur-3xl pointer-events-none animate-float"></div>
    <div class="fixed top-[40%] right-[-10%] w-[28rem] h-[28rem] bg-indigo-100/40 rounded-full mix-blend-multiply filter blur-3xl pointer-events-none animate-float" style="animation-delay: 3s;"></div>

    <!-- Sticky Navigation Bar -->
    <nav id="navbar" class="fixed top-0 left-0 w-full z-50 transition-all duration-300 py-4 bg-transparent">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            
            <!-- Brand Logo -->
            <a href="#home" class="group flex items-center gap-2.5 font-heading text-xl md:text-2xl font-extrabold text-brand-500 tracking-tight">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-brand-500 group-hover:scale-105 group-hover:bg-brand-500 group-hover:text-white transition-all duration-300 shadow-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <span>Scholar<span class="text-slate-900">Flow</span></span>
            </a>

            <!-- Nav Links -->
            <div class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
                <a href="#home" class="hover:text-brand-500 transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-brand-500 hover:after:w-full after:transition-all">Home</a>
                <a href="#about" class="hover:text-brand-500 transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-brand-500 hover:after:w-full after:transition-all">About Us</a>
                <a href="#features" class="hover:text-brand-500 transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-brand-500 hover:after:w-full after:transition-all">Features</a>
                <a href="#faq" class="hover:text-brand-500 transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-brand-500 hover:after:w-full after:transition-all">FAQ</a>
            </div>

            <!-- Auth Buttons -->
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-brand-500 rounded-xl hover:bg-slate-100/60 transition-all duration-200">
                    Login
                </a>
                <a href="{{ route('register') }}" class="group relative inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-brand-500 hover:bg-brand-600 rounded-xl shadow-md hover:shadow-lg hover:shadow-blue-500/20 active:scale-95 transition-all duration-200">
                    <span>Create Account</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="pt-36 pb-20 relative z-10">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 lg:gap-16 items-center">
            
            <div class="space-y-6 text-left">
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-100 text-brand-500 text-xs font-bold uppercase tracking-wider shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                    Next-Gen Academic Workspace
                </span>

                <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-[1.15] text-slate-900 tracking-tight">
                    Discover. Organize. <br class="hidden sm:inline" />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Understand.</span>
                </h1>

                <p class="text-slate-600 text-base sm:text-lg leading-relaxed max-w-xl">
                    ScholarFlow is an intelligent research workspace designed to help students and researchers aggregate academic papers, structure materials, generate precision citations, and accelerate insight with AI.
                </p>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3.5 pt-2">
                    <a href="{{ route('register') }}" class="group flex items-center justify-center gap-2 px-7 py-3.5 bg-brand-500 hover:bg-brand-600 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/35 hover:-translate-y-0.5 active:scale-95 transition-all duration-200">
                        <span>Get Started Free</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                    <a href="#about" class="flex items-center justify-center px-7 py-3.5 bg-white border border-slate-200 hover:border-slate-300 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 hover:-translate-y-0.5 active:scale-95 transition-all duration-200 shadow-xs">
                        Learn More
                    </a>
                </div>
            </div>

            <!-- Dashboard Interactive Mockup -->
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl blur-xl opacity-20 group-hover:opacity-30 transition duration-500"></div>
                
                <div class="relative bg-white/95 backdrop-blur-md p-6 sm:p-7 rounded-2xl shadow-2xl border border-slate-200/80">
                    <!-- Top Window Bar -->
                    <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-rose-400"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                        </div>
                        <span class="text-xs font-semibold text-slate-400 font-mono">scholarflow.app/search</span>
                    </div>

                    <!-- Search Mock -->
                    <div class="relative mb-6">
                        <div class="flex items-center border border-slate-200 rounded-xl px-4 py-3.5 bg-slate-50/80 shadow-inner group-focus-within:border-brand-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <span id="typing-text" class="text-sm text-slate-800 font-mono border-r-2 border-brand-500 pr-1 min-h-[20px]"></span>
                        </div>
                    </div>

                    <!-- Dynamic Card Result -->
                    <div id="mock-result" class="p-5 rounded-xl border border-slate-200/80 bg-white shadow-xs transition-all duration-300 hover:border-blue-300 hover:shadow-md">
                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <span class="inline-block px-2.5 py-0.5 bg-blue-50 text-brand-500 text-[11px] font-bold rounded-md uppercase tracking-wider mb-2">Peer Reviewed</span>
                                <h3 id="card-title" class="font-bold text-slate-900 text-base leading-snug">Deep Learning in Healthcare</h3>
                            </div>
                            <button class="p-2 text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-all" title="Bookmark Paper">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            </button>
                        </div>
                        <p id="card-author" class="text-xs font-medium text-slate-500 mt-2 flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            John Doe • 2025
                        </p>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                            <span id="card-citations" class="inline-flex items-center gap-1 text-xs font-semibold text-brand-600 bg-blue-50 border border-blue-100 px-3 py-1 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                1,245 Citations
                            </span>
                            <span class="text-xs text-slate-400 font-medium">arXiv / Crossref</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Trusted APIs -->
    <section id="about" class="py-12 bg-white border-y border-slate-200/80 relative z-10">
        <div class="max-w-7xl mx-auto px-6">
            <p class="text-center text-xs font-bold uppercase tracking-widest text-slate-400 mb-8">Integrated with Trusted Academic Sources</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                
                <div class="p-5 border border-slate-200/80 rounded-2xl text-center hover:border-blue-300 hover:shadow-md hover:-translate-y-1 transition-all duration-300 bg-slate-50/50 group">
                    <div class="w-8 h-8 mx-auto mb-2.5 rounded-lg bg-blue-100/60 text-brand-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm">Semantic Scholar</h4>
                    <p class="text-xs text-slate-500 mt-1">AI-driven literature graph</p>
                </div>

                <div class="p-5 border border-slate-200/80 rounded-2xl text-center hover:border-indigo-300 hover:shadow-md hover:-translate-y-1 transition-all duration-300 bg-slate-50/50 group">
                    <div class="w-8 h-8 mx-auto mb-2.5 rounded-lg bg-indigo-100/60 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm">Crossref</h4>
                    <p class="text-xs text-slate-500 mt-1">Digital object identifiers</p>
                </div>

                <div class="p-5 border border-slate-200/80 rounded-2xl text-center hover:border-cyan-300 hover:shadow-md hover:-translate-y-1 transition-all duration-300 bg-slate-50/50 group">
                    <div class="w-8 h-8 mx-auto mb-2.5 rounded-lg bg-cyan-100/60 text-cyan-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm">arXiv</h4>
                    <p class="text-xs text-slate-500 mt-1">Open-access preprint archive</p>
                </div>

                <div class="p-5 border border-slate-200/80 rounded-2xl text-center hover:border-violet-300 hover:shadow-md hover:-translate-y-1 transition-all duration-300 bg-slate-50/50 group">
                    <div class="w-8 h-8 mx-auto mb-2.5 rounded-lg bg-violet-100/60 text-violet-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm">OpenAI</h4>
                    <p class="text-xs text-slate-500 mt-1">AI synthesis & gap analysis</p>
                </div>

            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-16 bg-gradient-to-b from-slate-50 to-white relative z-10">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            
            <div class="p-6 rounded-2xl bg-white border border-slate-200/70 shadow-xs hover:border-blue-200 transition-colors">
                <div class="text-3xl sm:text-4xl font-extrabold font-heading text-brand-500 count" data-target="3">0</div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mt-2">Integrated APIs</p>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-slate-200/70 shadow-xs hover:border-blue-200 transition-colors">
                <div class="text-3xl sm:text-4xl font-extrabold font-heading text-brand-500"><span class="count" data-target="10">0</span>M+</div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mt-2">Indexed Papers</p>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-slate-200/70 shadow-xs hover:border-blue-200 transition-colors">
                <div class="text-3xl sm:text-4xl font-extrabold font-heading text-brand-500"><span class="count" data-target="1000">0</span>+</div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mt-2">Daily Queries</p>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-slate-200/70 shadow-xs hover:border-blue-200 transition-colors">
                <div class="text-3xl sm:text-4xl font-extrabold font-heading text-brand-500"><span class="count" data-target="99">0</span>%</div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mt-2">Citation Accuracy</p>
            </div>

        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white relative z-10">
        <div class="max-w-7xl mx-auto px-6">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-14 space-y-3">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-blue-50 border border-blue-100 text-brand-500 text-xs font-bold uppercase tracking-wider">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Core Capabilities
                </span>
                <h2 class="font-heading text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Everything you need to master your research
                </h2>
                <p class="text-slate-500 text-base leading-relaxed">
                    A unified suite of intelligent tools designed to streamline your paper discovery, citation workflow, and analytical note-taking.
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Card 1: Smart Research Search -->
                <div class="group relative bg-white p-7 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-blue-300 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white group-hover:scale-105 transition-all duration-300 shadow-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-heading font-bold text-lg text-slate-900 group-hover:text-blue-600 transition-colors">
                                Smart Research Search
                            </h3>
                            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                                Search research papers across multiple APIs instantly from a unified bar.
                            </p>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-slate-400 group-hover:text-blue-600 transition-colors">
                        <span>Multi-source index</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </div>

                <!-- Card 2: Research Collections -->
                <div class="group relative bg-white p-7 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-amber-300 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white group-hover:scale-105 transition-all duration-300 shadow-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-heading font-bold text-lg text-slate-900 group-hover:text-amber-600 transition-colors">
                                Research Collections
                            </h3>
                            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                                Organize papers into dedicated project and subject folders effortlessly.
                            </p>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-slate-400 group-hover:text-amber-600 transition-colors">
                        <span>Structured taxonomy</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </div>

                <!-- Card 3: Smart Notes -->
                <div class="group relative bg-white p-7 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-emerald-300 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white group-hover:scale-105 transition-all duration-300 shadow-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-heading font-bold text-lg text-slate-900 group-hover:text-emerald-600 transition-colors">
                                Smart Notes
                            </h3>
                            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                                Attach persistent, formatted notes directly to individual paper records.
                            </p>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-slate-400 group-hover:text-emerald-600 transition-colors">
                        <span>Rich text support</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </div>

                <!-- Card 4: Citation Generator -->
                <div class="group relative bg-white p-7 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-violet-300 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center group-hover:bg-violet-600 group-hover:text-white group-hover:scale-105 transition-all duration-300 shadow-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-heading font-bold text-lg text-slate-900 group-hover:text-violet-600 transition-colors">
                                Citation Generator
                            </h3>
                            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                                Generate error-free APA, MLA, IEEE, and Chicago style citations in one click.
                            </p>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-slate-400 group-hover:text-violet-600 transition-colors">
                        <span>APA, MLA, IEEE & BibTeX</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </div>

                <!-- Card 5: AI Assistant -->
                <div class="group relative bg-white p-7 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-indigo-300 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white group-hover:scale-105 transition-all duration-300 shadow-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-heading font-bold text-lg text-slate-900 group-hover:text-indigo-600 transition-colors">
                                AI Assistant
                            </h3>
                            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                                Generate paper summaries, explanations, gap analyses, and thesis suggestions.
                            </p>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-slate-400 group-hover:text-indigo-600 transition-colors">
                        <span>Automated synthesis</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </div>

                <!-- Card 6: Analytics -->
                <div class="group relative bg-white p-7 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-cyan-300 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center group-hover:bg-cyan-600 group-hover:text-white group-hover:scale-105 transition-all duration-300 shadow-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-heading font-bold text-lg text-slate-900 group-hover:text-cyan-600 transition-colors">
                                Analytics
                            </h3>
                            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                                Track reading status, saved counts, active collections, and study habits.
                            </p>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-slate-400 group-hover:text-cyan-600 transition-colors">
                        <span>Real-time metrics</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-20 bg-brand-bg relative z-10 border-t border-slate-200/80">
        <div class="max-w-3xl mx-auto px-6">
            
            <div class="text-center mb-12 space-y-3">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-blue-50 border border-blue-100 text-brand-500 text-xs font-bold uppercase tracking-wider">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Got Questions?
                </span>
                <h2 class="font-heading text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Frequently Asked Questions</h2>
                <p class="text-slate-500 text-sm sm:text-base">Everything you need to know about getting started with ScholarFlow.</p>
            </div>

            <div class="space-y-3.5">
                
                <!-- FAQ 1 -->
                <div class="bg-white border border-slate-200/80 rounded-2xl overflow-hidden shadow-xs hover:border-blue-200 transition-colors">
                    <button class="faq-btn w-full px-6 py-4 text-left font-bold text-slate-800 flex justify-between items-center group">
                        <span class="text-sm sm:text-base font-bold group-hover:text-brand-500 transition-colors">What is ScholarFlow?</span>
                        <div class="faq-icon-bg w-7 h-7 rounded-full bg-slate-50 text-slate-400 group-hover:bg-blue-50 group-hover:text-brand-500 flex items-center justify-center transition-all duration-300 shrink-0">
                            <svg class="faq-chevron h-4 w-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div class="faq-answer hidden px-6 pb-5 text-sm text-slate-500 leading-relaxed border-t border-slate-100 pt-3">
                        ScholarFlow is a web workspace that helps users discover, organize, and understand academic research papers from multiple scholarly sources directly in one centralized platform.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white border border-slate-200/80 rounded-2xl overflow-hidden shadow-xs hover:border-blue-200 transition-colors">
                    <button class="faq-btn w-full px-6 py-4 text-left font-bold text-slate-800 flex justify-between items-center group">
                        <span class="text-sm sm:text-base font-bold group-hover:text-brand-500 transition-colors">Is ScholarFlow free to use?</span>
                        <div class="faq-icon-bg w-7 h-7 rounded-full bg-slate-50 text-slate-400 group-hover:bg-blue-50 group-hover:text-brand-500 flex items-center justify-center transition-all duration-300 shrink-0">
                            <svg class="faq-chevron h-4 w-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div class="faq-answer hidden px-6 pb-5 text-sm text-slate-500 leading-relaxed border-t border-slate-100 pt-3">
                        Yes! Core paper discovery, organization, and citation features are 100% free for researchers and students.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white border border-slate-200/80 rounded-2xl overflow-hidden shadow-xs hover:border-blue-200 transition-colors">
                    <button class="faq-btn w-full px-6 py-4 text-left font-bold text-slate-800 flex justify-between items-center group">
                        <span class="text-sm sm:text-base font-bold group-hover:text-brand-500 transition-colors">Does ScholarFlow host or re-publish PDF papers?</span>
                        <div class="faq-icon-bg w-7 h-7 rounded-full bg-slate-50 text-slate-400 group-hover:bg-blue-50 group-hover:text-brand-500 flex items-center justify-center transition-all duration-300 shrink-0">
                            <svg class="faq-chevron h-4 w-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div class="faq-answer hidden px-6 pb-5 text-sm text-slate-500 leading-relaxed border-t border-slate-100 pt-3">
                        No. ScholarFlow connects directly to trusted external academic APIs (like arXiv and Semantic Scholar) to retrieve metadata and open-access links. It securely saves your notes, tags, and collections.
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Call to Action Banner -->
    <section class="py-16 bg-white relative z-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 rounded-3xl p-8 sm:p-12 text-center text-white shadow-xl shadow-blue-500/10 relative overflow-hidden group">
                <div class="absolute -left-10 -bottom-10 w-60 h-60 bg-white/10 rounded-full blur-2xl group-hover:scale-125 transition-transform duration-700 pointer-events-none"></div>
                
                <div class="relative z-10 max-w-2xl mx-auto space-y-4">
                    <h2 class="font-heading text-3xl sm:text-4xl font-extrabold">Supercharge your research workflow today</h2>
                    <p class="text-blue-100 text-sm sm:text-base leading-relaxed">
                        Join thousands of researchers and students streamlining literature reviews with AI-assisted insights.
                    </p>
                    <div class="pt-4 flex flex-col sm:flex-row justify-center gap-3">
                        <a href="{{ route('register') }}" class="px-8 py-3.5 bg-white text-brand-700 font-bold rounded-xl shadow-md hover:bg-blue-50 active:scale-95 transition-all">
                            Create Free Account
                        </a>
                        <a href="{{ route('login') }}" class="px-8 py-3.5 bg-blue-800/40 border border-white/20 text-white font-semibold rounded-xl hover:bg-blue-800/60 active:scale-95 transition-all">
                            Sign In
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200/80 py-10 relative z-10">
        <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            
            <a href="#home" class="flex items-center gap-2 font-heading text-lg font-bold text-slate-800">
                <div class="w-7 h-7 rounded-lg bg-blue-50 text-brand-500 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                ScholarFlow
            </a>

            <p class="text-xs font-medium text-slate-400">© 2026 ScholarFlow. All rights reserved.</p>

            <div class="flex gap-6 text-xs font-semibold text-slate-500">
                <a href="#" class="hover:text-brand-500 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-brand-500 transition-colors">Terms & Conditions</a>
                <a href="#" class="hover:text-brand-500 transition-colors">Contact Us</a>
            </div>
        </div>
    </footer>

    <!-- Interactive Scripts -->
    <script>
        // Sticky Navbar Transition
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 20) {
                nav.classList.add('bg-white/90', 'backdrop-blur-md', 'shadow-xs', 'border-b', 'border-slate-200/80', 'py-3');
                nav.classList.remove('bg-transparent', 'py-4');
            } else {
                nav.classList.remove('bg-white/90', 'backdrop-blur-md', 'shadow-xs', 'border-b', 'border-slate-200/80', 'py-3');
                nav.classList.add('bg-transparent', 'py-4');
            }
        });

        // Typing Animation & Dynamic Mock Cards
        const topics = [
            { query: "Machine Learning", title: "Deep Learning in Healthcare", author: "John Doe • 2025", citations: "1,245 Citations" },
            { query: "Cybersecurity", title: "Zero Trust Architecture in Cloud", author: "Alice Smith • 2026", citations: "890 Citations" },
            { query: "Artificial Intelligence", title: "Generative Transformers Review", author: "R. Johnson • 2024", citations: "3,410 Citations" },
            { query: "Healthcare AI", title: "AI-Assisted Diagnostic Systems", author: "M. Patel • 2025", citations: "620 Citations" }
        ];

        let index = 0;
        let charIndex = 0;
        const typingText = document.getElementById('typing-text');
        const cardResult = document.getElementById('mock-result');

        function typeEffect() {
            const current = topics[index];
            if (charIndex < current.query.length) {
                typingText.textContent += current.query.charAt(charIndex);
                charIndex++;
                setTimeout(typeEffect, 90);
            } else {
                setTimeout(eraseEffect, 2200);
            }
        }

        function eraseEffect() {
            if (charIndex > 0) {
                typingText.textContent = topics[index].query.substring(0, charIndex - 1);
                charIndex--;
                setTimeout(eraseEffect, 40);
            } else {
                index = (index + 1) % topics.length;
                
                // Card fade-out & fade-in dynamic transition
                cardResult.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    updateCard(topics[index]);
                    cardResult.classList.remove('opacity-0', 'scale-95');
                }, 200);

                setTimeout(typeEffect, 400);
            }
        }

        function updateCard(data) {
            document.getElementById('card-title').textContent = data.title;
            document.getElementById('card-author').textContent = data.author;
            document.getElementById('card-citations').innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                ${data.citations}
            `;
        }

        document.addEventListener("DOMContentLoaded", typeEffect);

        // Accordion Toggle
        document.querySelectorAll('.faq-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const answer = btn.nextElementSibling;
                const chevron = btn.querySelector('.faq-chevron');
                const iconBg = btn.querySelector('.faq-icon-bg');
                
                const isOpen = !answer.classList.contains('hidden');

                // Close all
                document.querySelectorAll('.faq-answer').forEach(el => el.classList.add('hidden'));
                document.querySelectorAll('.faq-chevron').forEach(el => el.classList.remove('rotate-180'));
                document.querySelectorAll('.faq-icon-bg').forEach(el => el.classList.remove('bg-blue-50', 'text-brand-500'));

                // Open active
                if (!isOpen) {
                    answer.classList.remove('hidden');
                    chevron.classList.add('rotate-180');
                    iconBg.classList.add('bg-blue-50', 'text-brand-500');
                }
            });
        });

        // Animated Counters
        const counters = document.querySelectorAll('.count');
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            let count = 0;
            const updateCount = () => {
                const inc = target / 40;
                if (count < target) {
                    count += inc;
                    counter.innerText = Math.ceil(count);
                    setTimeout(updateCount, 30);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        });
    </script>
</body>
</html>