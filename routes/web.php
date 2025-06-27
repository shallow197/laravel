<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::match(['get','post'], '/page_login', function () {
    return view('auth.login');
})->name('login');

Route::get('/dashboard', [AuthenticatedSessionController::class, 'showdashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/login', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/voirplus{id}', [AuthenticatedSessionController::class, 'affichage_infos_users'])->middleware(['auth', 'verified'])->name('voirplus');

Route::post('/multidelete', [AuthenticatedSessionController::class, 'multiDelete'])->middleware(['auth', 'verified'])->name('multidelete');


Route::put('/users/{id}', [ProfileController::class, 'updateinfo'])->name('users.update');

Route::post('/dashboard', [AuthenticatedSessionController::class, 'storetask'])->middleware(['auth', 'verified'])->name('ajouter.tache');

Route::get('/taches_form', [AuthenticatedSessionController::class, 'add_task'])->middleware(['auth', 'verified'])->name('add.task');

Route::get('update_task/{id}/edit', [AuthenticatedSessionController::class, 'edit_task'])->middleware(['auth', 'verified'])->name('update.form');

Route::post('update_task/{id}', [AuthenticatedSessionController::class, 'update_task'])->middleware(['auth', 'verified'])->name('update.save');

Route::get('delete_task/{id}', [AuthenticatedSessionController::class, 'delete_task'])->middleware(['auth', 'verified'])->name('delete');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

Route::get('/logout', function () {
    return view('auth.login');
})->name('deconnexion');

Route::get('/tasks', [AuthenticatedSessionController::class, 'showtaskstoadmin'])->middleware(['auth', 'verified'])->name('showtask.admin');
require __DIR__.'/auth.php';

Route::get('/', function() 
{
    return view('auth.admin');
})->name('admin.login');

Route::POST('/adminverif', [ProfileController::class, 'adminlogin'])->name('admin.verif');

Route::POST('adminlogin', [ProfileController::class, 'admindashboard'])
    ->name('admin.login.post')
    ->middleware('guest');