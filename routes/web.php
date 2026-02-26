<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SharedLinkController;

// Imports des Dashboards
use App\Http\Controllers\Reader\DashboardController as ReaderDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Routes Publiques
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentification
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'register')->name('register.post');
    Route::post('/logout', 'logout')->name('logout');
});



// --- Mot de passe oublié ---
// Afficher le formulaire de demande
Route::get('/forgot-password', [App\Http\Controllers\ForgotPasswordController::class, 'showLinkRequestForm'])
    ->middleware('guest')
    ->name('password.request');

// Envoyer le lien par email
Route::post('/forgot-password', [App\Http\Controllers\ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->middleware('guest')
    ->name('password.email');

// Afficher le formulaire de réinitialisation (après clic sur le lien email)
Route::get('/reset-password/{token}', [App\Http\Controllers\ForgotPasswordController::class, 'showResetForm'])
    ->middleware('guest')
    ->name('password.reset');

// Traiter le changement de mot de passe
Route::post('/reset-password', [App\Http\Controllers\ForgotPasswordController::class, 'reset'])
    ->middleware('guest')
    ->name('password.update');




// Accès via lien partagé
Route::get('/shared/{token}', [SharedLinkController::class, 'accederViaLienPartage'])
    ->name('shared.link');

/*
|--------------------------------------------------------------------------
| Routes Reader (Lecteur)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'reader'])->prefix('reader')->name('reader.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [ReaderDashboardController::class, 'index'])->name('dashboard');

    // Lecture Projets
    Route::controller(ProjectController::class)->prefix('projects')->name('projects.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{project}', 'show')->name('show');
    });

    // Lecture Catégories
    Route::controller(CategoryController::class)->prefix('categories')->name('categories.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{category}', 'show')->name('show');
    });

    // Lecture Documentations
    Route::controller(DocumentationController::class)->prefix('documentations')->name('documentations.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{documentation}', 'show')->name('show');
        // Actions spécifiques lecture
        Route::get('/{id}/lire', 'lireLaDocumentations')->name('lire');
        Route::post('/{id}/vues', 'mettreAJourNombreDesVues')->name('vues.update');
    });

    // Favoris
    Route::controller(FavoriteController::class)->prefix('favoris')->name('favoris.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/ajouter', 'ajouterAuxFavoris')->name('ajouter');
        Route::delete('/{docId}', 'retirerFavori')->name('retirer');
    });
    // --- GESTION DU PROFIL ---
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/profile/avatar', [UserController::class, 'deleteAvatar'])->name('profile.avatar.delete'); // Pour supprimer la photo
    Route::put('/password', [UserController::class, 'changePassword'])->name('password.update');
});


/*
|--------------------------------------------------------------------------
| Routes Admin (Administrateur)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Gestion Projets
    Route::controller(ProjectController::class)->prefix('projects')->name('projects.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{project}', 'show')->name('show');
        Route::get('/{project}/edit', 'edit')->name('edit');
        Route::put('/{project}', 'update')->name('update');
        Route::delete('/{project}', 'destroy')->name('destroy');
    });

    // Gestion Catégories
    Route::controller(CategoryController::class)->prefix('categories')->name('categories.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{category}', 'show')->name('show');
        Route::get('/{category}/edit', 'edit')->name('edit');
        Route::put('/{category}', 'update')->name('update');
        Route::delete('/{category}', 'destroy')->name('destroy');
    });

    // Gestion Documentations
    Route::controller(DocumentationController::class)->prefix('documentations')->name('documentations.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{documentation}', 'show')->name('show');
        Route::get('/{documentation}/edit', 'edit')->name('edit');
        Route::put('/{documentation}', 'update')->name('update');
        Route::delete('/{documentation}', 'destroy')->name('destroy');
    });

    // Liens partagés
    Route::post('/shared-links/{docId}', [SharedLinkController::class, 'genererLienPartage'])
        ->name('shared.generate');

    // Gestion Utilisateurs
    Route::controller(UserController::class)->prefix('users')->name('users.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{user}', 'show')->name('show');
    });
});
