<?php

namespace App\Http\Controllers\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');

    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:users,username',

            'email' => 'required|email|confirmed|unique:users,email',

            'phone' => [
                'required',
                'regex:/^09[0-9]{9}$/',
                'unique:users,phone'
            ],

            'password' => [
                'required',
                'confirmed',
                'min:8'
            ]
        ], [

            'username.unique' => 'Username already exists.',

            'email.unique' => 'Gmail is already used.',

            'phone.unique' => 'Phone number is already registered.',

            'phone.regex' => 'Phone number must start with 09 and contain 11 digits.',

            'password.confirmed' => 'Passwords do not match.'
        ]);

        $user = User::create([

            'username' => $request->username,

            'email' => $request->email,

            'phone' => $request->phone,

            'password' => Hash::make($request->password),

        ]);

        Auth::login($user);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful.',
            'redirect' => route('dashboard')
        ]);
    }
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $key = Str::lower($request->email) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {

            return response()->json([
                'success' => false,
                'message' => 'Too many failed login attempts. Please try again after 30 minutes.'
            ], 429);

        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {

            RateLimiter::hit($key, 1800);

            return response()->json([
                'success' => false,
                'message' => "Account doesn't exist."
            ], 404);

        }

        if (!Hash::check($request->password, $user->password)) {

            RateLimiter::hit($key, 1800);

            return response()->json([
                'success' => false,
                'message' => 'Wrong password.'
            ], 401);

        }

        RateLimiter::clear($key);

        // Login user
        Auth::login($user, $request->boolean('remember'));

        // Regenerate session
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'redirect' => route('dashboard')
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function redirectGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callbackGoogle()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'username' => Str::slug($googleUser->getName()) . rand(1000, 9999),
                'password' => bcrypt(Str::random(16)),
                'phone' => null, // Make sure this column is nullable
            ]
        );

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function callbackGithub()
    {
        $githubUser = Socialite::driver('github')->user();

        $email = $githubUser->getEmail();

        // GitHub users may not have a public email
        if (!$email) {
            return redirect()->route('login')
                ->with('error', 'Your GitHub account does not have a public email.');
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'username' => $githubUser->getNickname() ?? 'github_' . rand(1000, 9999),
                'password' => bcrypt(Str::random(16)),
                'phone' => null,
            ]
        );

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
