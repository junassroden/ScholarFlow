<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | ScholarFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body
    class="min-h-screen flex items-center justify-center p-4 sm:p-6 bg-slate-50 text-slate-900 selection:bg-blue-500 selection:text-white">

    <!-- Toast Notification Container (Initial Hidden State) -->
    <div id="error-toast"
        class="fixed top-4 right-4 z-50 flex items-start gap-3 p-4 pr-10 border border-red-200 bg-red-50 text-red-700 text-sm rounded-2xl shadow-xl transition-all duration-300 translate-x-[150%] opacity-0 selection:bg-red-200"
        role="alert">
        <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <div>
            <span class="font-semibold block mb-1">There was a problem with your submission:</span>
            <span id="toast-message" class="text-xs text-red-600 block leading-relaxed"></span>
        </div>
        <button type="button" onclick="hideErrorToast()"
            class="absolute top-3 right-3 text-red-400 hover:text-red-600 p-0.5 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Main Card container with full split panels -->
    <div
        class="w-full max-w-7xl flex flex-col md:flex-row bg-white border border-slate-200/80 rounded-3xl shadow-xl overflow-hidden relative z-10 animate-fade-in-up">

        <!-- Left Panel: Form Content -->
        <div class="flex-1 p-8 sm:p-12 md:p-16 flex flex-col justify-center">

            <!-- Branding and Header -->
            <div class="mb-10 text-center">
                <a href="/"
                    class="inline-flex items-center gap-2.5 text-2xl font-extrabold text-slate-900 hover:opacity-90 transition-opacity">
                    <!-- Pen Logo -->
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    <span>ScholarFlow</span>
                </a>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight mt-5">Join the community</h1>
                <p class="text-sm text-slate-600 mt-2 font-medium">Create your account to start organizing your
                    research.
                </p>
            </div>

            <!-- Social Login -->
            <div class="flex items-center gap-3 mb-10">
                <a href="{{ route('google.login') }}"
                    class="flex-1 flex justify-center items-center gap-2 px-4 py-3 bg-white border border-slate-200 hover:bg-slate-50 rounded-xl text-sm font-semibold text-slate-700 transition-colors shadow-sm">
                    <!-- Google Outline SVG -->
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12.48 10.92v3.28h7.84c-.24 1.84-1.92 5.16-7.84 5.16-4.08 0-7.4-3.32-7.4-7.4s3.32-7.4 7.4-7.4c2.32 0 3.88.96 4.76 1.8l2.6-2.6c-1.84-1.72-4.24-2.8-7.36-2.8-6.08 0-11 4.92-11 11s4.92 11 11 11c5.96 0 11.36-4.28 11.36-11.36 0-.76-.08-1.32-.16-1.88h-11.2z" />
                    </svg>
                    Google
                </a>

                <a href="{{ route('github.login') }}"
                    class="flex-1 flex justify-center items-center gap-2 px-4 py-3 bg-white border border-slate-200 hover:bg-slate-50 rounded-xl text-sm font-semibold text-slate-700 transition-colors shadow-sm">
                    <!-- GitHub Outline SVG -->
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107.775.418 1.305.762 1.604-2.665.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 6.231-5.477 6.526.43.372.814 1.106.814 2.228v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                    </svg>
                    GitHub
                </a>
            </div>

            <div class="relative flex items-center mb-10">
                <div class="flex-grow border-t border-slate-200"></div>
                <span class="flex-shrink-0 mx-5 text-slate-400 text-xs uppercase tracking-widest font-semibold">Or
                    register with email</span>
                <div class="flex-grow border-t border-slate-200"></div>
            </div>

            <form id="register-form" action="{{ route('register.post') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Name Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">First Name</label>
                        <div class="relative group mt-4">
                            <div
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                <!-- User Outline Icon -->
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" required
                                class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm text-slate-900 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all outline-none placeholder:text-slate-400 shadow-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Last Name</label>
                        <div class="relative group mt-4">
                            <div
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                <!-- User Outline Icon -->
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" required
                                class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm text-slate-900 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all outline-none placeholder:text-slate-400 shadow-sm">
                        </div>
                    </div>
                </div>

                <!-- Username & Phone -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Username</label>
                        <div class="relative group mt-4">
                            <div
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                <!-- User Outline Icon -->
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="username" value="{{ old('username') }}" required
                                placeholder="researcher_01"
                                class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm text-slate-900 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all outline-none placeholder:text-slate-400 shadow-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Phone Number</label>
                        <div class="relative group mt-4">
                            <div
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                <!-- Phone Outline Icon -->
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <input type="tel" name="phone" placeholder="09123456789" value="{{ old('phone') }}" required
                                pattern="09[0-9]{9}"
                                class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm text-slate-900 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all outline-none placeholder:text-slate-400 shadow-sm">
                        </div>
                    </div>
                </div>

                <!-- Email Address -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Email Address</label>
                        <div class="relative group mt-4">
                            <div
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                <!-- Mail Outline Icon -->
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                placeholder="you@university.edu"
                                class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm text-slate-900 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all outline-none placeholder:text-slate-400 shadow-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Confirm Email</label>
                        <div class="relative group mt-4">
                            <div
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                <!-- Mail Outline Icon -->
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" name="email_confirmation" value="{{ old('email_confirmation') }}"
                                required placeholder="you@university.edu"
                                class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm text-slate-900 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all outline-none placeholder:text-slate-400 shadow-sm">
                        </div>
                    </div>
                </div>

                <!-- Password Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                        <div class="relative group mt-4">
                            <div
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                <!-- Lock Outline Icon -->
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" id="pwd" name="password" required placeholder="••••••••"
                                class="w-full pl-12 pr-14 py-3 bg-white border border-slate-200 rounded-xl text-sm text-slate-900 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all outline-none placeholder:text-slate-400 shadow-sm">
                            <button type="button" onclick="togglePasswordVisibility('pwd', this)"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400 hover:text-blue-600 transition-colors focus:outline-none bg-transparent">
                                SHOW
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Confirm Password</label>
                        <div class="relative group mt-4">
                            <div
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                <!-- Lock Outline Icon -->
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" id="pwd_confirm" name="password_confirmation" required
                                placeholder="••••••••"
                                class="w-full pl-12 pr-14 py-3 bg-white border border-slate-200 rounded-xl text-sm text-slate-900 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all outline-none placeholder:text-slate-400 shadow-sm">
                            <button type="button" onclick="togglePasswordVisibility('pwd_confirm', this)"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400 hover:text-blue-600 transition-colors focus:outline-none bg-transparent">
                                SHOW
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Password Strength Indicator -->
                <div class="space-y-2 pt-2 mb-2">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-600 font-bold">Password strength</span>
                        <span id="strength-text" class="font-bold text-slate-400">Too short</span>
                    </div>
                    <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden border border-slate-200">
                        <div id="strength-bar"
                            class="h-full w-0 rounded-full transition-all duration-500 ease-out bg-slate-400"></div>
                    </div>
                </div>

                <!-- Terms & Conditions -->
                <div class="flex items-start pt-3">
                    <div class="flex items-center h-5">
                        <input type="checkbox" name="terms" id="terms" required
                            class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-600 transition-all cursor-pointer">
                    </div>
                    <label for="terms" class="ml-3 text-sm text-slate-700 leading-tight select-none">
                        By creating an account, you agree to our
                        <a href="#" class="text-blue-600 font-bold hover:underline transition-colors">Terms of
                            Service</a>
                        and
                        <a href="#" class="text-blue-600 font-bold hover:underline transition-colors">Privacy
                            Policy</a>.
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="submit-btn"
                    class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 active:scale-[0.99] text-white font-bold rounded-xl text-sm shadow-md transition-all duration-200 focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 mt-4 outline-none flex items-center justify-center">
                    <span>Create Account</span>
                </button>
            </form>

            <!-- Footer -->
            <p class="text-center text-sm text-slate-600 mt-10 font-medium leading-loose">
                Already have an account?
                <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline transition-colors">Log in
                    here</a>
            </p>
        </div>

        <!-- Right Panel: Whimsical Illustration and Background -->
        <div class="flex-1 bg-slate-100 p-12 md:p-16 flex flex-col items-center justify-center relative">

            <!-- Replace this SVG with the crayon-style illustration asset if available -->
            <img src="{{ asset('images/scholarflow.png') }}" alt="ScholarFlow Logo"
                class="absolute inset-0 w-full h-full object-cover" />
            <!-- Flowing Banner Text integrated into illustration spill -->
            <div class="absolute bottom-16 right-16 z-20 transform rotate-[-5deg]">
                <div class="bg-blue-600 text-white px-5 py-2 font-black text-lg rounded-full shadow-lg">SCHOLARFLOW
                </div>
            </div>

            <!-- Background subtle pattern/gradient -->
            <div class="absolute inset-0 bg-gradient-to-br from-slate-100 to-slate-200/50"></div>
        </div>
    </div>

    <!-- Script Section -->
    <script>
        // Form & Toast Elements
        const form = document.getElementById('register-form');
        const submitBtn = document.getElementById('submit-btn');
        const toast = document.getElementById('error-toast');
        const toastMessage = document.getElementById('toast-message');
        let toastTimeout;

        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                btn.textContent = 'HIDE';
                btn.classList.add('text-blue-600');
            } else {
                input.type = 'password';
                btn.textContent = 'SHOW';
                btn.classList.remove('text-blue-600');
            }
        }

        const pwdInput = document.getElementById('pwd');
        const bar = document.getElementById('strength-bar');
        const text = document.getElementById('strength-text');

        pwdInput.addEventListener('input', () => {
            const val = pwdInput.value;
            let score = 0;

            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const baseClass = 'h-full rounded-full transition-all duration-500 ease-out';

            if (val.length === 0) {
                bar.className = `${baseClass} w-0 bg-slate-400`;
                text.textContent = 'Too short';
                text.className = 'font-bold text-slate-400';
            } else if (score <= 2) {
                bar.className = `${baseClass} w-1/3 bg-red-500`;
                text.textContent = 'Weak';
                text.className = 'font-bold text-red-500';
            } else if (score === 3) {
                bar.className = `${baseClass} w-2/3 bg-amber-500`;
                text.textContent = 'Good';
                text.className = 'font-bold text-amber-500';
            } else {
                bar.className = `${baseClass} w-full bg-emerald-500`;
                text.textContent = 'Strong';
                text.className = 'font-bold text-emerald-500';
            }
        });

        function showErrorToast(message) {
            toastMessage.textContent = message;
            // Slide in
            toast.classList.remove("translate-x-[150%]", "opacity-0");
            toast.classList.add("translate-x-0", "opacity-100");

            // Auto hide after 5 seconds
            clearTimeout(toastTimeout);
            toastTimeout = setTimeout(() => {
                hideErrorToast();
            }, 5000);
        }

        function hideErrorToast() {
            toast.classList.remove("translate-x-0", "opacity-100");
            toast.classList.add("translate-x-[150%]", "opacity-0");
        }

        // Form Submission with Loading State
        form.addEventListener("submit", async function (e) {
            e.preventDefault();
            hideErrorToast(); // Reset any existing errors

            // Add loading state to button
            const originalBtnHTML = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
            submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Verifying...</span>
        `;

            const data = new FormData(form);

            try {
                // In a real application, update the endpoint to handle registration (e.g., /register)
                const response = await fetch("/register.post", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    },
                    body: data
                });

                const result = await response.json();

                if (result.success) {
                    window.location.href = result.redirect;
                } else {
                    showErrorToast(result.message || "Invalid details provided.");
                    // Revert button state
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                    submitBtn.innerHTML = originalBtnHTML;
                }
            } catch (err) {
                console.error(err);
                showErrorToast("Server Error. Please try again later.");
                // Revert button state
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                submitBtn.innerHTML = originalBtnHTML;
            }
        });
    </script>
</body>

</html>
