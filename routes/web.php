<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    if (session()->has('user')) {
        return redirect('/dashboard');
    }
    return view('login');
});

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    // Static credentials
    $validEmail = 'admin@example.com';
    $validPassword = 'admin@123';

    if ($credentials['email'] === $validEmail && $credentials['password'] === $validPassword) {
        session(['user' => $credentials['email']]);
        return redirect('/dashboard');
    }

    return back()->with('error', 'Invalid credentials!');
});

Route::middleware(['check.session'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'));
    Route::get('/add-user', fn() => view('users.create'));
    Route::get('/list', fn() => view('users.index'))->name('users.index');
    Route::get('/ajax-list', [UserController::class,'list'])->name('users.list');
    Route::post('/store-user', [UserController::class,'store'])->name('users.store');
    Route::get('/destroy/{id}', [UserController::class,'delete'])->name('users.destroy');
    Route::get('/update/{id}', [UserController::class,'update'])->name('users.update');
    Route::post('/edit/{user}', [UserController::class,'edit'])->name('users.edit');
    Route::get('/logout', function () {
        session()->flush();
        return redirect('/');
    });
});


