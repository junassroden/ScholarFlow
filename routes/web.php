    <?php

    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Http;
    use App\Http\Controllers\LandingController;
    use App\Http\Controllers\Auth\AuthController;
    use App\Http\Controllers\SearchController;
    use App\Http\Controllers\PaperController;
    use App\Http\Controllers\AIController;
    use App\Http\Controllers\SavedPaperController;
    use App\Http\Controllers\LibraryController;


    Route::get('/', [LandingController::class, 'index'])->name('home');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth')->group(function () {

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::get('/library', function () {
            return view('library');
        })->name('library');

        Route::get('/history', function () {
            return view('history');
        })->name('history');

        Route::get('/assistant', function () {
            return view('assistant');
        })->name('assistant');

    });


    Route::get('/search', [SearchController::class, 'search'])->name('search');


    Route::get('/paper', [PaperController::class, 'show'])->name('paper.show');


    Route::get('/auth/google', [AuthController::class, 'redirectGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [AuthController::class, 'callbackGoogle'])->name('google.callback');

    Route::get('/auth/github', [AuthController::class, 'redirectGithub'])->name('github.login');
    Route::get('/auth/github/callback', [AuthController::class, 'callbackGithub'])->name('github.callback');


    Route::get('/test-openaire', function () {

        $response = Http::get(
            'https://api.openaire.eu/search/publications',
            [
                'keywords' => 'artificial intelligence',
                'size' => 1,
            ]
        );

        dd([
            'status' => $response->status(),
            'headers' => $response->headers(),
            'body' => $response->body(),
        ]);
    });

    Route::post('/assistant/chat', [AIController::class, 'chat'])
        ->middleware('auth')
        ->name('assistant.chat');

Route::get('/test-groq', function () {
    return [
        'key' => env('GROQ_API_KEY'),
        'model' => env('GROQ_MODEL'),
    ];
});

Route::post('/library/save', [SavedPaperController::class, 'store'])
    ->middleware('auth')
    ->name('library.save');

Route::post('/library/save', [LibraryController::class, 'save'])
    ->middleware('auth');