@php
    $userName = Auth::user()->username ?? 'Researcher';
@endphp
<!DOCTYPE html>
<html lang="en" class="bg-[#F8FAFC] text-slate-800 antialiased">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ScholarFlow - AI Assistant</title>

    <!-- Fonts: Poppins for Headings, Inter for Body -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS CDN ONLY -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }

        .font-inter {
            font-family: 'Inter', sans-serif;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Custom Chat Message Animations */
        @keyframes messageAppear {
            from {
                opacity: 0;
                transform: translateY(12px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .animate-message {
            animation: messageAppear 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Custom Scrollbar Styling for Chat Stream */
        #chat-stream::-webkit-scrollbar {
            width: 6px;
        }
        #chat-stream::-webkit-scrollbar-track {
            background: transparent;
        }
        #chat-stream::-webkit-scrollbar-thumb {
            background: rgba(203, 213, 225, 0.5);
            border-radius: 9999px;
        }
        #chat-stream::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 0.8);
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
                    class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-lg shadow-md shadow-blue-600/20">
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
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('search') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Search Papers
            </a>
            <a href="{{ route('library') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
                My Library
            </a>
            <a href="{{ route('assistant') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl bg-blue-50 text-blue-700 font-medium transition-colors">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                AI Assistant
            </a>
            <a href="{{ route('history') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-colors">
                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                History
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
            </div>
        </div>
    </aside>

    <!-- Main Chat Workspace -->
    <main class="flex-1 lg:ml-72 flex flex-col relative w-full h-screen overflow-hidden bg-[#F8FAFC]">

        <!-- Header -->
        <header
            class="flex items-center justify-between px-6 py-4 bg-white/80 backdrop-blur-md border-b border-slate-200/60 shrink-0 z-10 shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-500 rounded-lg hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="flex items-center gap-3">
                    <!-- Updated Header Logo Avatar -->
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-blue-600/25">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h1 class="font-poppins font-bold text-base text-slate-900 leading-tight">ScholarFlow Copilot</h1>
                            <span class="px-2 py-0.5 bg-blue-50 border border-blue-100 text-blue-700 text-[10px] font-semibold rounded-full">Gemini 1.5 Pro</span>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mt-0.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                            Active Context: 14 Library Papers
                        </p>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="clearChat()"
                    class="flex items-center gap-2 px-3.5 py-2 border border-slate-200/80 bg-white text-slate-600 hover:bg-slate-50 hover:text-slate-900 text-xs font-semibold rounded-xl transition-all shadow-sm">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                    Clear Chat
                </button>
            </div>
        </header>

        <!-- Conversation Scroll Area -->
        <div id="chat-stream" class="flex-1 overflow-y-auto px-4 sm:px-8 py-8 space-y-6">
            <div id="messages" class="max-w-4xl mx-auto space-y-6">

                <!-- Assistant Welcome Card with Bot Logo -->
                <div class="flex items-start gap-4 animate-message">
                    <!-- Bot Logo Icon -->
                    <div
                        class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center shrink-0 shadow-lg shadow-blue-600/20 mt-1 ring-4 ring-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    
                    <div class="flex-1 bg-white p-6 rounded-2xl rounded-tl-sm border border-slate-200/80 shadow-[0_4px_20px_rgba(0,0,0,0.03)] space-y-4">
                        <div class="space-y-1">
                            <div class="flex items-center justify-between">
                                <h2 class="font-poppins font-semibold text-slate-900 text-base">Welcome back, {{ $userName }}</h2>
                                <span class="text-[11px] font-medium text-slate-400">Just now</span>
                            </div>
                            <p class="text-sm text-slate-600 leading-relaxed font-inter">
                                I am ready to assist with literature synthesis, methodology validation, citation alignment, and abstract drafting. How can we accelerate your research today?
                            </p>
                        </div>

                        <!-- Quick Prompts Grid -->
                        <div class="pt-3 border-t border-slate-100">
                            <p class="text-[11px] font-semibold text-slate-400 tracking-wider uppercase mb-3">Suggested Workflows</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <button onclick="fillPrompt('Summarize key findings across my saved library items')"
                                    class="flex items-start gap-3 p-3.5 text-left rounded-xl border border-slate-200/80 bg-slate-50/50 hover:bg-blue-50/40 hover:border-blue-300 transition-all group">
                                    <div
                                        class="p-2 bg-white group-hover:bg-blue-100/70 rounded-lg text-slate-600 group-hover:text-blue-700 shadow-xs transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-slate-900 group-hover:text-blue-900">Summarize Recent Papers</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">Synthesize key findings across saved items</p>
                                    </div>
                                </button>

                                <button onclick="fillPrompt('Benchmark transformer architecture tradeoffs')"
                                    class="flex items-start gap-3 p-3.5 text-left rounded-xl border border-slate-200/80 bg-slate-50/50 hover:bg-blue-50/40 hover:border-blue-300 transition-all group">
                                    <div
                                        class="p-2 bg-white group-hover:bg-blue-100/70 rounded-lg text-slate-600 group-hover:text-blue-700 shadow-xs transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-slate-900 group-hover:text-blue-900">Compare Methodologies</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">Benchmark transformer architecture tradeoffs</p>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Chat Prompt Input Box -->
        <div class="p-4 sm:p-6 bg-white border-t border-slate-200/60 shrink-0 shadow-[0_-4px_20px_rgba(0,0,0,0.02)]">
            <div class="max-w-4xl mx-auto space-y-3">
                <div class="relative flex items-center">
                    <button
                        class="absolute left-4 p-2 text-slate-400 hover:text-blue-600 rounded-xl hover:bg-slate-100 transition-colors"
                        title="Attach Literature File">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                            </path>
                        </svg>
                    </button>

                    <input id="message" type="text" placeholder="Ask anything about research papers, methodologies, or citations..."
                        class="w-full py-4 pl-14 pr-32 text-sm bg-slate-50/80 border border-slate-200 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 focus:bg-white transition-all shadow-inner">

                    <button id="sendBtn"
                        class="absolute right-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 active:scale-95 text-white text-xs font-semibold rounded-xl transition-all shadow-md shadow-blue-600/20 flex items-center gap-2">
                        <span>Send</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </div>

                <div class="flex items-center justify-between text-[11px] text-slate-400 px-1">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Press <kbd
                            class="px-1.5 py-0.5 bg-slate-100 border border-slate-200 rounded text-slate-600 font-mono text-[10px]">Enter</kbd>
                        to send message
                    </span>
                    <span class="font-medium text-slate-400">ScholarFlow Assistant v2.5</span>
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

        function fillPrompt(text) {
            const messageInput = document.getElementById("message");
            messageInput.value = text;
            messageInput.focus();
        }

        function clearChat() {
            const messages = document.getElementById("messages");
            messages.innerHTML = `
                <div class="flex items-start gap-4 animate-message">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center shrink-0 shadow-lg shadow-blue-600/20 mt-1 ring-4 ring-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1 bg-white p-6 rounded-2xl rounded-tl-sm border border-slate-200/80 shadow-[0_4px_20px_rgba(0,0,0,0.03)] space-y-2">
                        <h2 class="font-poppins font-semibold text-slate-900 text-base">Chat history cleared</h2>
                        <p class="text-sm text-slate-600">How can I assist your research next?</p>
                    </div>
                </div>
            `;
        }

        const messageInput = document.getElementById("message");
        const sendBtn = document.getElementById("sendBtn");
        const messages = document.getElementById("messages");

        function addUserMessage(text) {
            messages.insertAdjacentHTML('beforeend', `
                <div class="flex justify-end animate-message">
                    <div class="bg-blue-600 text-white px-5 py-3.5 rounded-2xl rounded-tr-sm max-w-2xl shadow-md shadow-blue-600/10 text-sm leading-relaxed font-inter">
                        ${text}
                    </div>
                </div>
            `);
            const chatStream = document.getElementById("chat-stream");
            chatStream.scrollTop = chatStream.scrollHeight;
        }

        function showTypingIndicator() {
            const id = 'typing-' + Date.now();
            messages.insertAdjacentHTML('beforeend', `
                <div id="${id}" class="flex items-start gap-4 animate-message">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center shrink-0 shadow-lg shadow-blue-600/20 mt-1 ring-4 ring-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <div class="bg-white border border-slate-200/80 rounded-2xl rounded-tl-sm shadow-[0_4px_20px_rgba(0,0,0,0.03)] p-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                        <div class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                    </div>
                </div>
            `);
            const chatStream = document.getElementById("chat-stream");
            chatStream.scrollTop = chatStream.scrollHeight;
            return id;
        }

        function addAIMessage(text) {
            messages.insertAdjacentHTML('beforeend', `
                <div class="flex items-start gap-4 animate-message">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center shrink-0 shadow-lg shadow-blue-600/20 mt-1 ring-4 ring-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1 bg-white border border-slate-200/80 rounded-2xl rounded-tl-sm shadow-[0_4px_20px_rgba(0,0,0,0.03)] p-6 text-slate-700 text-sm leading-relaxed space-y-3 font-inter">
                        ${text.replace(/\n/g, "<br>")}
                    </div>
                </div>
            `);
            const chatStream = document.getElementById("chat-stream");
            chatStream.scrollTop = chatStream.scrollHeight;
        }

        async function sendMessage() {
            const message = messageInput.value.trim();
            if (message === "") return;

            addUserMessage(message);
            messageInput.value = "";

            const typingId = showTypingIndicator();

            try {
                const response = await fetch("/assistant/chat", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ message: message })
                });

                const data = await response.json();
                document.getElementById(typingId)?.remove();

                if (data.reply) {
                    addAIMessage(data.reply);
                } else {
                    addAIMessage("No response from Gemini.");
                }
            } catch (error) {
                document.getElementById(typingId)?.remove();
                addAIMessage("Error connecting to Gemini API.");
                console.log(error);
            }
        }

        sendBtn.addEventListener("click", sendMessage);
        messageInput.addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
                sendMessage();
            }
        });
    </script>
</body>

</html>