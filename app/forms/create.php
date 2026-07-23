<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | ScholarFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">
    <!-- Increased max-w-lg to max-w-2xl for a wider, more spacious two-column layout -->
    <div class="w-full max-w-2xl bg-white border border-slate-200 rounded-2xl shadow-xl p-8">
        
        <div class="text-center mb-6">
            <a href="/" class="text-2xl font-bold text-blue-600">📘 ScholarFlow</a>
            <h1 class="text-xl font-bold text-slate-900 mt-2">Create Your Account</h1>
            <p class="text-sm text-slate-500">Start your research journey today.</p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 rounded-lg text-xs space-y-1">
                <?php foreach ($errors as $error): ?>
                    <p>• <?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="/ScholarFlow/app/forms/register_process.php" method="POST" class="space-y-4">
            
            <!-- Name Fields -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">First Name</label>
                    <input type="text" name="first_name" value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Last Name</label>
                    <input type="text" name="last_name" value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <!-- Username & Phone -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Username</label>
                    <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Phone Number</label>
                    <input type="text" name="phone" placeholder="09123456789" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" required pattern="09[0-9]{9}" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <!-- Email Address & Confirm Email (Balanced into 2 columns for length distribution) -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Email Address</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Confirm Email</label>
                    <input type="email" name="email_confirmation" value="<?= htmlspecialchars($_POST['email_confirmation'] ?? '') ?>" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <!-- Password & Confirm Password (Balanced into 2 columns) -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Password</label>
                    <input type="password" id="pwd" name="password" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <!-- Password Strength Bar -->
            <div>
                <div class="h-1.5 w-full bg-slate-200 rounded-full overflow-hidden">
                    <div id="strength-bar" class="h-full w-0 transition-all duration-300"></div>
                </div>
            </div>

            <!-- Terms & Conditions -->
            <div class="flex items-center pt-2">
                <input type="checkbox" name="terms" id="terms" required class="rounded border-slate-300 text-blue-600">
                <label for="terms" class="ml-2 text-xs text-slate-600">
                    I agree to the <a href="#" class="text-blue-600 underline">Terms & Conditions</a> and <a href="#" class="text-blue-600 underline">Privacy Policy</a>.
                </label>
            </div>

            <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm shadow-sm transition-colors mt-2">
                Create Account
            </button>
        </form>

        <p class="text-center text-sm text-slate-500 mt-6">
            Already have an account? <a href="login.php" class="text-blue-600 font-semibold hover:underline">Login</a>
        </p>
    </div>

    <script>
        const pwdInput = document.getElementById('pwd');
        const bar = document.getElementById('strength-bar');

        pwdInput.addEventListener('input', () => {
            const val = pwdInput.value;
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            if (score === 0) bar.style.width = '0%';
            else if (score <= 2) { bar.style.width = '33%'; bar.className = 'h-full bg-red-500'; }
            else if (score === 3) { bar.style.width = '66%'; bar.className = 'h-full bg-yellow-500'; }
            else { bar.style.width = '100%'; bar.className = 'h-full bg-green-500'; }
        });
    </script>
</body>
</html>