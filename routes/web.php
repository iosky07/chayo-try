<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use Laravel\Jetstream\Jetstream;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [SiteController::class, 'home'])->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::name('admin.')->prefix('admin')->middleware(['auth:sanctum','web', 'verified'])->group(function() {
    Route::post('/summernote-upload',[SupportController::class,'upload'])->name('summernote_upload');
    Route::view('/dashboard', "dashboard")->name('dashboard');
//    Route::resource('blog', BlogController::class);
    Route::middleware(['checkRole:1,2'])->group(function () {
        Route::resource('member', MemberController::class);
    });
    Route::resource('student', StudentController::class);
    Route::resource('student-detail', StudentDetailController::class);
//    Route::post('student-detail/{id}', [StudentDetailController::class, 'update'])->name('student.update');
//    Route::post('student-detail/{id}', [StudentDetailController::class, 'destroy'])->name('student.destroy');
    Route::resource('offense', OffenseController::class);
    Route::resource('addition', AdditionController::class);
//    Route::middleware(['checkRole:1']){}
    Route::middleware(['checkRole:1'])->group(function () {
        Route::get('/user', [UserController::class, "index"])->name('user');
        Route::view('/user/new', "pages.user.create")->name('user.new');
        Route::view('/user/edit/{userId}', "pages.user.edit")->name('user.edit');
    });


    Route::group(['middleware' => config('jetstream.middleware', ['web'])], function () {
        Route::group(['middleware' => ['auth', 'verified']], function () {
            // User & Profile...
            Route::get('/user/profile', [UserController::class, 'show'])
                ->name('profile.show');

            // API...
            if (Jetstream::hasApiFeatures()) {
                Route::get('/user/api-tokens', [ApiTokenController::class, 'index'])->name('api-tokens.index');
            }

            // Teams...
            if (Jetstream::hasTeamFeatures()) {
                Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
                Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
                Route::put('/current-team', [CurrentTeamController::class, 'update'])->name('current-team.update');
            }
        });
    });

});
