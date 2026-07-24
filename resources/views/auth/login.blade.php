<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ScholarFlow</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">

<div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-200 p-8">

    <!-- Logo -->
    <div class="text-center mb-8">

        <a href="{{ route('home') }}" class="text-3xl font-bold text-blue-600">
            📘 ScholarFlow
        </a>

        <h1 class="text-2xl font-bold text-slate-900 mt-4">
            Welcome Back
        </h1>

        <p class="text-slate-500 text-sm mt-2">
            Continue your research journey.
        </p>

    </div>

    <!-- Error Message -->

    <div
        id="error-message"
        class="hidden mb-4 bg-red-50 border border-red-200 text-red-600 rounded-lg p-3 text-sm">
    </div>

    <form id="loginForm">

        @csrf

        <div class="mb-4">

            <label class="block text-xs font-semibold uppercase text-slate-700 mb-2">
                Email Address
            </label>

            <input
                type="email"
                name="email"
                class="w-full border border-slate-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-600 outline-none"
                required>

        </div>

        <div class="mb-5">

            <div class="flex justify-between mb-2">

                <label class="text-xs font-semibold uppercase text-slate-700">
                    Password
                </label>

                <a href="#" class="text-xs text-blue-600 hover:underline">
                    Forgot Password?
                </a>

            </div>

            <div class="relative">

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="w-full border border-slate-300 rounded-lg px-4 py-3 pr-12 focus:ring-2 focus:ring-blue-600 outline-none"
                    required>

                <button
                    type="button"
                    id="togglePassword"
                    class="absolute top-3 right-4 text-slate-500">

                    👁

                </button>

            </div>

        </div>

        <div class="flex items-center mb-5">

            <input
                type="checkbox"
                id="remember"
                name="remember"
                class="rounded">

            <label for="remember" class="ml-2 text-sm text-slate-600">

                Remember Me

            </label>

        </div>

        <button
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg transition">

            Login

        </button>

    </form>

    <p class="text-center text-sm text-slate-500 mt-6">

        Don't have an account?

        <a
            href="{{ route('register') }}"
            class="text-blue-600 font-semibold hover:underline">

            Create Account

        </a>

    </p>

</div>

<script>
const form = document.getElementById("loginForm");
const error = document.getElementById("error-message");

const password = document.getElementById("password");

document.getElementById("togglePassword").onclick = () => {
    password.type = password.type === "password" ? "text" : "password";
};

form.addEventListener("submit", async function(e){

    e.preventDefault();

    error.classList.add("hidden");

    const data = new FormData(form);

    try{

        const response = await fetch("/login",{

            method:"POST",

            headers:{
                "X-CSRF-TOKEN":"{{ csrf_token() }}",
                "Accept":"application/json"
            },

            body:data

        });

        console.log(response);

        const result = await response.json();

        console.log(result);

        if(result.success){

            window.location.href=result.redirect;

        }else{

            error.innerHTML=result.message;
            error.classList.remove("hidden");

        }

    }catch(err){

        console.log(err);
        error.innerHTML="Server Error";
        error.classList.remove("hidden");

    }

});
</script>

</body>
</html>