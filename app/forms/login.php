<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Generate CSRF token if it doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ScholarFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md bg-white border border-slate-200 rounded-2xl shadow-xl p-8">
        
        <!-- Logo Header -->
        <div class="text-center mb-8">
            <a href="/" class="text-2xl font-bold text-blue-600">📘 ScholarFlow</a>
            <h1 class="text-xl font-bold text-slate-900 mt-4">Welcome Back</h1>
            <p class="text-sm text-slate-500">Continue your research journey.</p>
        </div>

        <!-- Dynamic Error Alert Box for AJAX responses -->
        <div id="error-alert" class="hidden mb-4 p-3 bg-red-50 border border-red-200 text-red-600 rounded-lg text-sm"></div>

        <!-- Global Session Error Alert (fallback) -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 rounded-lg text-sm">
                <?php 
                    echo htmlspecialchars($_SESSION['error']); 
                    unset($_SESSION['error']); 
                ?>
            </div>
        <?php endif; ?>

        <!-- FIXED: Form tag remains open to wrap all inputs properly -->
        <form id="login-form" action="app/forms/login_process.php" method="POST" class="space-y-4">
            
            <!-- CSRF Token -->
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Email Address</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none">
            </div>

            <div>
                <div class="flex justify-between items-center mb-1">
                    <label class="text-xs font-semibold text-slate-700 uppercase">Password</label>
                    <a href="#" class="text-xs text-blue-600 hover:underline">Forgot Password?</a>
                </div>
                <div class="relative">
                    <input type="password" id="password" name="password" required class="w-full px-4 py-2.5 pr-10 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    <button type="button" id="toggle-password" class="absolute right-3 top-3 text-slate-400 hover:text-slate-600 focus:outline-none">
                        <!-- Eye Icon (Show) -->
                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <!-- Eye Slash Icon (Hide) - Hidden by default -->
                        <svg id="eye-slash-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.03 10.03 0 012.042-3.32m3.11-2.455A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex items-center">
                <input type="checkbox" id="remember" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                <label for="remember" class="ml-2 text-sm text-slate-600">Remember Me</label>
            </div>

            <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm shadow-sm transition-colors">
                Login
            </button>
        </form>

        <p class="text-center text-sm text-slate-500 mt-6">
            Don't have an account? <a href="<? url('/create') ?>" class="text-blue-600 font-semibold hover:underline">Create Account</a>
        </p>
    </div>

    <script>
        // Password visibility toggle
        document.getElementById('toggle-password').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeSlashIcon = document.getElementById('eye-slash-icon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        });

        // AJAX Form Handler to process login API seamlessly
        document.getElementById('login-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            const errorAlert = document.getElementById('error-alert');
            
            errorAlert.classList.add('hidden');
            errorAlert.textContent = '';

            try {
                // Pointing directly to the processor file in the same folder
                const response = await fetch('app/forms/login_process.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    window.location.href = result.redirect;
                } else {
                    errorAlert.textContent = result.message;
                    errorAlert.classList.remove('hidden');
                }
            } catch (err) {
                errorAlert.textContent = 'An unexpected error occurred. Please check your connection.';
                errorAlert.classList.remove('hidden');
                console.error('Error:', err);
            }
        });
    </script>
</body>
</html>