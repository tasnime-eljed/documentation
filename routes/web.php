<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SharedLinkController;
use App\Http\Controllers\Reader\DashboardController as ReaderDashboardController;

/*
|--------------------------------------------------------------------------
| Routes Publiques
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Routes Authentification
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'register')->name('register.post');
    Route::post('/logout', 'logout')->name('logout');
});

// Accès via lien partagé (public)
Route::get('/shared/{token}', [SharedLinkController::class, 'accederViaLienPartage'])
    ->name('shared.link');

/*
|--------------------------------------------------------------------------
| Routes Reader (Authentification + Role Reader)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'reader'])->prefix('reader')->name('reader.')->group(function () {

    // Dashboard Reader
    Route::get('/dashboard', [ReaderDashboardController::class, 'index'])->name('dashboard');

    // Lecture des projets, catégories et documentations (lecture seule)
    Route::controller(ProjectController::class)->prefix('projects')->name('projects.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
    });

    Route::controller(CategoryController::class)->prefix('categories')->name('categories.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
    });

    Route::controller(DocumentationController::class)->prefix('documentations')->name('documentations.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/lire', 'lireLaDocumentations')->name('lire');
        Route::post('/{id}/vues', 'mettreAJourNombreDesVues')->name('vues.update');
        Route::get('/{id}/temps-lecture', 'calculerTempsLecture')->name('temps.calcul');
    });

    // Favoris (ajouter ou retirer uniquement)
    Route::controller(FavoriteController::class)->prefix('favoris')->name('favoris.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/ajouter', 'ajouterAuxFavoris')->name('ajouter');
        Route::delete('/{docId}', 'retirerFavori')->name('retirer');
    });
});

/*
|--------------------------------------------------------------------------
| Routes Admin (Authentification + Role Admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Gestion des Projets
    Route::controller(AdminController::class)->prefix('projects')->name('projects.')->group(function () {
        Route::get('/', 'listeProjets')->name('index');
        Route::get('/create', 'createProjet')->name('create');
        Route::post('/', 'ajouterProjet')->name('store');
        Route::get('/{id}', 'showProjet')->name('show');
        Route::get('/{id}/edit', 'editProjet')->name('edit');
        Route::put('/{id}', 'modifierProjet')->name('update');
        Route::delete('/{id}', 'supprimerProjet')->name('destroy');
    });

    // Gestion des Catégories
    Route::controller(AdminController::class)->prefix('categories')->name('categories.')->group(function () {
        Route::get('/', 'listeCategories')->name('index');
        Route::get('/create', 'createCategorie')->name('create');
        Route::post('/', 'ajouterCategorie')->name('store');
        Route::get('/{id}', 'showCategorie')->name('show');
        Route::get('/{id}/edit', 'editCategorie')->name('edit');
        Route::put('/{id}', 'modifierCategorie')->name('update');
        Route::delete('/{id}', 'supprimerCategorie')->name('destroy');
    });

    // Gestion des Documentations
    Route::controller(AdminController::class)->prefix('documentations')->name('documentations.')->group(function () {
        Route::get('/', 'listeDocumentations')->name('index');
        Route::get('/create', 'createDocumentation')->name('create');
        Route::post('/', 'ajouterDocumentation')->name('store');
        Route::get('/{id}', 'showDocumentation')->name('show');
        Route::get('/{id}/edit', 'editDocumentation')->name('edit');
        Route::put('/{id}', 'modifierDocumentation')->name('update');
        Route::delete('/{id}', 'supprimerDocumentation')->name('destroy');
    });

    // Génération de liens partagés
    Route::post('/shared-links/{docId}', [AdminController::class, 'genererLienPartage'])
        ->name('shared.generate');

    // Gestion des utilisateurs
  Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [AdminController::class, 'listeUsers'])->name('index');//nom complet : admin.users.index
    Route::get('/{id}', [AdminController::class, 'showUser'])->name('show');
});
});

/*
|--------------------------------------------------------------------------
| Routes API (AJAX / Favoris)
|--------------------------------------------------------------------------
*/

Route::prefix('api')->middleware(['auth'])->name('api.')->group(function () {

    // Favoris toggle
    Route::post('/favoris/toggle', [FavoriteController::class, 'toggle'])->name('favoris.toggle');

    // Statistiques pour Admin Dashboard
    Route::get('/stats', function () {
        return response()->json([
            'users' => \App\Models\User::count(),
            'projects' => \App\Models\Project::count(),
            'categories' => \App\Models\Category::count(),
            'documentations' => \App\Models\Documentation::count(),
            'favoris' => \App\Models\Favorite::count(),
            'shared_links' => \App\Models\SharedLink::count(),
        ]);
    })->name('stats');
});
