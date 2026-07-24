<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScholarFlow | Discover. Organize. Understand.</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
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
<body class="font-body bg-white text-brand-text antialiased">

    <!-- Sticky Navigation Bar -->
    <nav id="navbar" class="fixed top-0 left-0 w-full z-50 transition-all duration-300 bg-transparent py-4">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <a href="#" class="flex items-center gap-2 font-heading text-2xl font-bold text-brand-500">
                <span>📘 ScholarFlow</span>
            </a>
            <div class="hidden md:flex items-center gap-8 text-sm font-medium">
                <a href="#home" class="hover:text-brand-500 transition-colors">Home</a>
                <a href="#about" class="hover:text-brand-500 transition-colors">About Us</a>
                <a href="#features" class="hover:text-brand-500 transition-colors">Features</a>
                <a href="#faq" class="hover:text-brand-500 transition-colors">FAQ</a>
            </div>
            <div class="hidden md:flex items-center gap-4">
                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-brand-text hover:text-brand-500">Login</a>
                <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-medium text-white bg-brand-500 hover:bg-brand-600 rounded-lg shadow-sm transition-all">Create Account</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="pt-32 pb-20 bg-gradient-to-b from-brand-bg to-white">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="font-heading text-4xl md:text-6xl font-bold leading-tight mb-6">
                    Discover. Organize. <span class="text-brand-500">Understand.</span>
                </h1>
                <p class="text-brand-muted text-lg mb-8 leading-relaxed">
                    ScholarFlow is an intelligent research workspace that helps students and researchers discover academic papers, organize research materials, generate citations, and understand complex studies using AI-powered assistance.
                </p>
                <div class="flex gap-4">
                    <a href="{{ route('register') }}" class="px-6 py-3 bg-brand-500 hover:bg-brand-600 text-white font-medium rounded-lg shadow-md transition-all">Get Started</a>
                    <a href="#about" class="px-6 py-3 bg-white border border-brand-border hover:border-brand-500 text-brand-text font-medium rounded-lg transition-all">Learn More</a>
                </div>
            </div>

            <!-- Dashboard Interactive Mockup -->
            <div class="bg-white p-6 rounded-2xl shadow-xl border border-brand-border">
                <div class="relative mb-6">
                    <div class="flex items-center border border-brand-border rounded-lg px-4 py-3 bg-brand-bg">
                        <span class="mr-3">🔍</span>
                        <span id="typing-text" class="text-sm text-brand-text font-mono border-r-2 border-brand-500 pr-1"></span>
                    </div>
                </div>

                <!-- Changing Mock Result -->
                <div id="mock-result" class="p-4 rounded-xl border border-brand-border bg-white transition-all duration-500">
                    <div class="flex justify-between items-start">
                        <h3 id="card-title" class="font-bold text-brand-text text-base">Deep Learning in Healthcare</h3>
                        <button class="text-brand-500">⭐</button>
                    </div>
                    <p id="card-author" class="text-xs text-brand-muted mt-1">John Doe • 2025</p>
                    <span id="card-citations" class="inline-block mt-3 text-xs font-semibold text-brand-500 bg-blue-50 px-2.5 py-1 rounded-full">1,245 Citations</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Trusted APIs -->
    <section class="py-12 bg-white border-y border-brand-border">
        <div class="max-w-7xl mx-auto px-6">
            <p class="text-center text-xs font-bold uppercase tracking-wider text-brand-muted mb-8">Integrated with Trusted Academic Sources</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="p-4 border border-brand-border rounded-xl text-center hover:-translate-y-1 transition-transform bg-brand-bg">
                    <h4 class="font-bold text-brand-text">Semantic Scholar</h4>
                    <p class="text-xs text-brand-muted mt-1">AI-driven academic search</p>
                </div>
                <div class="p-4 border border-brand-border rounded-xl text-center hover:-translate-y-1 transition-transform bg-brand-bg">
                    <h4 class="font-bold text-brand-text">Crossref</h4>
                    <p class="text-xs text-brand-muted mt-1">Digital object identifiers</p>
                </div>
                <div class="p-4 border border-brand-border rounded-xl text-center hover:-translate-y-1 transition-transform bg-brand-bg">
                    <h4 class="font-bold text-brand-text">arXiv</h4>
                    <p class="text-xs text-brand-muted mt-1">Open-access archive</p>
                </div>
                <div class="p-4 border border-brand-border rounded-xl text-center hover:-translate-y-1 transition-transform bg-brand-bg">
                    <h4 class="font-bold text-brand-text">OpenAI</h4>
                    <p class="text-xs text-brand-muted mt-1">AI synthesis & insights</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-16 bg-brand-bg">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold font-heading text-brand-500 count" data-target="3">0</div>
                <p class="text-xs text-brand-muted mt-1">Research APIs</p>
            </div>
            <div>
                <div class="text-4xl font-bold font-heading text-brand-500"><span class="count" data-target="10">0</span>M+</div>
                <p class="text-xs text-brand-muted mt-1">Research Papers</p>
            </div>
            <div>
                <div class="text-4xl font-bold font-heading text-brand-500"><span class="count" data-target="1000">0</span>+</div>
                <p class="text-xs text-brand-muted mt-1">Daily Searches</p>
            </div>
            <div>
                <div class="text-4xl font-bold font-heading text-brand-500"><span class="count" data-target="99">0</span>%</div>
                <p class="text-xs text-brand-muted mt-1">Research Accuracy</p>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="font-heading text-3xl font-bold text-center mb-12">Everything you need to master your research</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-6 border border-brand-border rounded-xl hover:shadow-lg transition-shadow">
                    <div class="text-2xl mb-3">🔍</div>
                    <h3 class="font-bold text-lg mb-2">Smart Research Search</h3>
                    <p class="text-sm text-brand-muted">Search research papers across multiple APIs instantly from a unified bar.</p>
                </div>
                <div class="p-6 border border-brand-border rounded-xl hover:shadow-lg transition-shadow">
                    <div class="text-2xl mb-3">📁</div>
                    <h3 class="font-bold text-lg mb-2">Research Collections</h3>
                    <p class="text-sm text-brand-muted">Organize papers into dedicated project and subject folders effortless.</p>
                </div>
                <div class="p-6 border border-brand-border rounded-xl hover:shadow-lg transition-shadow">
                    <div class="text-2xl mb-3">📝</div>
                    <h3 class="font-bold text-lg mb-2">Smart Notes</h3>
                    <p class="text-sm text-brand-muted">Attach persistent, formatted notes directly to individual paper records.</p>
                </div>
                <div class="p-6 border border-brand-border rounded-xl hover:shadow-lg transition-shadow">
                    <div class="text-2xl mb-3">📄</div>
                    <h3 class="font-bold text-lg mb-2">Citation Generator</h3>
                    <p class="text-sm text-brand-muted">Generate error-free APA, MLA, IEEE, and Chicago style citations in one click.</p>
                </div>
                <div class="p-6 border border-brand-border rounded-xl hover:shadow-lg transition-shadow">
                    <div class="text-2xl mb-3">🤖</div>
                    <h3 class="font-bold text-lg mb-2">AI Assistant</h3>
                    <p class="text-sm text-brand-muted">Generate paper summaries, explanations, gap analyses, and thesis suggestions.</p>
                </div>
                <div class="p-6 border border-brand-border rounded-xl hover:shadow-lg transition-shadow">
                    <div class="text-2xl mb-3">📊</div>
                    <h3 class="font-bold text-lg mb-2">Analytics</h3>
                    <p class="text-sm text-brand-muted">Track reading status, saved counts, active collections, and study habits.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-20 bg-brand-bg">
        <div class="max-w-3xl mx-auto px-6">
            <h2 class="font-heading text-3xl font-bold text-center mb-12">Frequently Asked Questions</h2>
            <div class="space-y-4">
                <div class="bg-white border border-brand-border rounded-lg overflow-hidden">
                    <button class="faq-btn w-full px-6 py-4 text-left font-bold flex justify-between items-center">
                        <span>What is ScholarFlow?</span>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer hidden px-6 pb-4 text-sm text-brand-muted">
                        ScholarFlow is a web workspace that helps users discover, organize, and understand academic research papers from multiple scholarly sources.
                    </div>
                </div>
                <div class="bg-white border border-brand-border rounded-lg overflow-hidden">
                    <button class="faq-btn w-full px-6 py-4 text-left font-bold flex justify-between items-center">
                        <span>Is ScholarFlow free?</span>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer hidden px-6 pb-4 text-sm text-brand-muted">
                        Yes. Core research, organization, and citation tools are completely free to use.
                    </div>
                </div>
                <div class="bg-white border border-brand-border rounded-lg overflow-hidden">
                    <button class="faq-btn w-full px-6 py-4 text-left font-bold flex justify-between items-center">
                        <span>Does ScholarFlow store research papers?</span>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer hidden px-6 pb-4 text-sm text-brand-muted">
                        No. It fetches paper metadata from external APIs and stores only your personal notes, bookmarks, and collection folders.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-brand-border py-12">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-xs text-brand-muted">© 2026 ScholarFlow. All rights reserved.</p>
            <div class="flex gap-6 text-xs text-brand-muted">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms & Conditions</a>
                <a href="#">Contact Us</a>
            </div>
        </div>
    </footer>

    <!-- Interactive Scripts -->
    <script>
        // Sticky Navbar Transition
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 20) {
                nav.classList.add('bg-white', 'shadow-sm', 'py-3');
                nav.classList.remove('bg-transparent', 'py-4');
            } else {
                nav.classList.remove('bg-white', 'shadow-sm', 'py-3');
                nav.classList.add('bg-transparent', 'py-4');
            }
        });

        // Typing Animation & Dynamic Mock Cards
        const topics = [
            { query: "Machine Learning", title: "Deep Learning in Healthcare", author: "John Doe • 2025", citations: "1,245 Citations" },
            { query: "Cybersecurity", title: "Zero Trust Architecture in Cloud", author: "Alice Smith • 2026", citations: "890 Citations" },
            { query: "Artificial Intelligence", title: "Generative Transformers Review", author: "R. Johnson • 2024", citations: "3,410 Citations" },
            { query: "Healthcare", title: "AI-Assisted Diagnostic Systems", author: "M. Patel • 2025", citations: "620 Citations" }
        ];

        let index = 0;
        let charIndex = 0;
        const typingText = document.getElementById('typing-text');

        function typeEffect() {
            const current = topics[index];
            if (charIndex < current.query.length) {
                typingText.textContent += current.query.charAt(charIndex);
                charIndex++;
                setTimeout(typeEffect, 100);
            } else {
                setTimeout(eraseEffect, 2000);
            }
        }

        function eraseEffect() {
            if (charIndex > 0) {
                typingText.textContent = topics[index].query.substring(0, charIndex - 1);
                charIndex--;
                setTimeout(eraseEffect, 50);
            } else {
                index = (index + 1) % topics.length;
                updateCard(topics[index]);
                setTimeout(typeEffect, 500);
            }
        }

        function updateCard(data) {
            document.getElementById('card-title').textContent = data.title;
            document.getElementById('card-author').textContent = data.author;
            document.getElementById('card-citations').textContent = data.citations;
        }

        document.addEventListener("DOMContentLoaded", typeEffect);

        // Accordion Toggle
        document.querySelectorAll('.faq-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const answer = btn.nextElementSibling;
                const icon = btn.querySelector('.faq-icon');
                answer.classList.toggle('hidden');
                icon.textContent = answer.classList.contains('hidden') ? '+' : '−';
            });
        });

        // Animated Counters
        const counters = document.querySelectorAll('.count');
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            let count = 0;
            const updateCount = () => {
                const inc = target / 50;
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