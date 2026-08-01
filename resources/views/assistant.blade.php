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
    </style>
</head>

<body class="font-inter flex min-h-screen overflow-x-hidden selection:bg-blue-100 selection:text-blue-900">

    <!-- Mobile Overlay -->
    <div id="mobile-overlay"
        class="fixed inset-0 bg-slate-900/20 z-40 hidden transition-opacity opacity-0 backdrop-blur-sm lg:hidden"
        onclick="toggleSidebar()"></div>

    <!-- Sidebar (Exact Original Design Preserved) -->
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
        <div
            class="flex items-center justify-between px-6 py-4 bg-white/90 backdrop-blur-md border-b border-slate-200/80 shrink-0 z-10">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-500 rounded-lg hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="flex items-center gap-3">
                    <div
                        class="w-9 h-9 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-poppins font-bold text-base text-slate-900 leading-none">Research Copilot</h1>
                        <p class="text-xs text-slate-500 mt-1 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                            Active Context: 14 Library Papers
                        </p>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button
                    class="flex items-center gap-2 px-3.5 py-1.5 border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900 text-xs font-semibold rounded-xl transition-all shadow-sm">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                    Clear Chat
                </button>
            </div>
        </div>

        <!-- Conversation Scroll Area -->
        <div id="chat-stream" class="flex-1 overflow-y-auto px-4 sm:px-8 py-8 space-y-6">
            <div id="messages" class="max-w-4xl mx-auto space-y-6">

                <!-- Assistant Welcome Card -->
                <div class="flex items-start gap-4">
                    <div
                        class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-blue-600/10 mt-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                        <div class="space-y-1">
                            <h2 class="font-poppins font-semibold text-slate-900 text-base">Welcome back,
                                {{ $userName }}
                            </h2>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                I am ready to assist with literature synthesis, methodology validation, citation
                                alignment, and abstract drafting. How can we accelerate your research today?
                            </p>
                        </div>

                        <!-- Quick Prompts Grid -->
                        <div class="pt-2 border-t border-slate-100">
                            <p class="text-[11px] font-semibold text-slate-400 tracking-wider uppercase mb-3">Suggested
                                Workflows</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <button
                                    class="flex items-start gap-3 p-3 text-left rounded-xl border border-slate-200/80 hover:border-blue-300 hover:bg-blue-50/50 transition-all group">
                                    <div
                                        class="p-2 bg-slate-100 group-hover:bg-blue-100/60 rounded-lg text-slate-600 group-hover:text-blue-700 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-slate-900 group-hover:text-blue-900">
                                            Summarize Recent Papers</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">Synthesize key findings across
                                            saved library items</p>
                                    </div>
                                </button>

                                <button
                                    class="flex items-start gap-3 p-3 text-left rounded-xl border border-slate-200/80 hover:border-blue-300 hover:bg-blue-50/50 transition-all group">
                                    <div
                                        class="p-2 bg-slate-100 group-hover:bg-blue-100/60 rounded-lg text-slate-600 group-hover:text-blue-700 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-slate-900 group-hover:text-blue-900">
                                            Compare Methodologies</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">Benchmark transformer architecture
                                            tradeoffs</p>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sample User Query -->
                <div class="flex items-start justify-end gap-3 pl-12">
                    <div
                        class="bg-blue-600 text-white px-5 py-4 rounded-2xl rounded-tr-none shadow-sm shadow-blue-600/10 max-w-2xl">
                        <p class="text-sm leading-relaxed">
                            Can you explain how sparse attention mechanisms reduce compute requirements?
                        </p>
                    </div>
                </div>

                <!-- Assistant Technical Reply -->
                <div class="flex items-start gap-4 pr-12">
                    <div
                        class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-blue-600/10 mt-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                        <p class="text-sm text-slate-700 leading-relaxed">
                            Standard attention scales quadratically $O(N^2)$ with input sequence length. <span
                                class="font-semibold text-slate-900">Sparse attention mechanisms</span> reduce this
                            overhead by selectively evaluating token dependencies rather than computing full attention
                            matrices.
                        </p>

                        <p class="text-sm text-slate-700 leading-relaxed">
                            Common implementation patterns include:
                        </p>

                        <div class="grid grid-cols-1 gap-2.5">
                            <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl">
                                <span class="text-xs font-semibold text-slate-900 block mb-0.5">1. Local Windows</span>
                                <span class="text-xs text-slate-600">Restricts attention computation strictly to
                                    neighboring tokens within a fixed radius $k$.</span>
                            </div>
                            <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl">
                                <span class="text-xs font-semibold text-slate-900 block mb-0.5">2. Strided / Fixed
                                    Patterns</span>
                                <span class="text-xs text-slate-600">Evaluates attention at regular interval steps to
                                    gather global context across long sequences.</span>
                            </div>
                            <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl">
                                <span class="text-xs font-semibold text-slate-900 block mb-0.5">3. Global Anchor
                                    Tokens</span>
                                <span class="text-xs text-slate-600">Designates specific tokens that interact with the
                                    entire sequence to propagate high-level context.</span>
                            </div>
                        </div>

                        <!-- Response Toolbar -->
                        <div class="flex items-center gap-3 pt-3 border-t border-slate-100 text-xs text-slate-400">
                            <button class="flex items-center gap-1.5 hover:text-slate-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Copy
                            </button>
                            <button class="flex items-center gap-1.5 hover:text-slate-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                                Regenerate
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Chat Prompt Input Box -->
        <div class="p-4 sm:p-6 bg-white border-t border-slate-200/80 shrink-0">
            <div class="max-w-4xl mx-auto space-y-3">
                <div class="relative flex items-center">
                    <button
                        class="absolute left-4 p-1.5 text-slate-400 hover:text-blue-600 rounded-lg hover:bg-slate-100 transition-colors"
                        title="Attach Literature File">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                            </path>
                        </svg>
                    </button>

                    <input id="message" type="text" placeholder="Ask anything about research papers..."
                        class="w-full py-4 pl-12 pr-28 text-sm bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 focus:bg-white transition-all">

                    <button id="sendBtn"
                        class="absolute right-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl transition-colors shadow-sm shadow-blue-600/20 flex items-center gap-2">
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
                            class="px-1.5 py-0.5 bg-slate-100 border border-slate-200 rounded text-slate-600 font-mono">Enter</kbd>
                        to send
                    </span>
                    <span>ScholarFlow Assistant v2.4</span>
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

        const messageInput = document.getElementById("message");
        const sendBtn = document.getElementById("sendBtn");
        const messages = document.getElementById("messages");

        function addUserMessage(text) {

            messages.innerHTML += `
        <div class="flex justify-end">
            <div class="bg-blue-600 text-white px-5 py-4 rounded-2xl rounded-tr-none max-w-2xl shadow">
                ${text}
            </div>
        </div>
    `;

            messages.scrollTop = messages.scrollHeight;
        }

        function addAIMessage(text) {

            messages.innerHTML += `
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0">
                AI
            </div>

            <div class="bg-white border rounded-2xl shadow-sm p-5 max-w-3xl">
                ${text.replace(/\n/g, "<br>")}
            </div>
        </div>
    `;

            messages.scrollTop = messages.scrollHeight;
        }

        async function sendMessage() {

            const message = messageInput.value.trim();

            if (message === "") return;

            addUserMessage(message);

            messageInput.value = "";

            try {

                const response = await fetch("/assistant/chat", {

                    method: "POST",

                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },

                    body: JSON.stringify({
                        message: message
                    })

                });

                const data = await response.json();

                if (data.reply) {

                    addAIMessage(data.reply);

                } else {

                    addAIMessage("No response from Gemini.");

                }

            } catch (error) {

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