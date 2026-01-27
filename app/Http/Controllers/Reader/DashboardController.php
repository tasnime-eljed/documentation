<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SharedLinkController;
use App\Http\Controllers\Reader\DashboardController as ReaderDashboard;
// Renommage pour éviter les conflits
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;

/*
|--------------------------------------------------------------------------
| Routes Publiques
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home'); // appel de la vue welcome


// Authentification
Route::controller(AuthController::class)->group(function () {
//toutes les routes à l’intérieur utilisent AuthController
    Route::get('/login', 'showLoginForm')->name('login');
    //'showLoginForm' → méthode du contrôleur appelée.
    Route::post('/login', 'login')->name('login.post');
    //route('login.post') correspond au formulaire qui envoie les données pour se connecter.
    Route::get('/register', 'showRegisterForm')->name('register');
    // showRegisterForm affiche le formulaire d'inscription
    Route::post('/register', 'register')->name('register.post');
    // la route pour traiter les données d'inscription
    Route::post('/logout', 'logout')->name('logout');
    //logout methode de controller pour déconnecter l'utilisateur
});


// Accès via lien partagé (public)
Route::get('/shared/{token}', [SharedLinkController::class, 'accederViaLienPartage'])
// methode accederViaLienPartage dans SharedLinkController
    ->name('shared.link');

/*
|--------------------------------------------------------------------------
| Routes Reader (auth + reader)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'reader'])->prefix('reader')->name('reader.')->group(function ()
//prefix('reader') → toutes les URLs commencent par /reader/...
//name('reader.') → tous les noms de routes commencent par reader.
// 'auth' et 'reader' middleware pour s'assurer que l'utilisateur est authentifié et a le rôle de lecteur
 {
    // Dashboard Reader
    Route::get('/dashboard', [ReaderDashboard::class, 'index'])->name('dashboard');//nom complet : reader.dashboard.

    // Lecture des documentations
    Route::controller(DocumentationController::class)->prefix('documentations')->name('documentations.')->group(function () {
        //prefix('documentations') → URLs /reader/documentations/....
        Route::get('/{id}/lire', 'lireLaDocumentations')->name('lire');// nom complet : reader.documentations.lire
        //{id} → identifiant du doc à lire
        Route::post('/{id}/vues', 'mettreAJourNombreDesVues')->name('vues.update');
        // nom complet : reader.documentations.vues.update
        Route::get('/{id}/temps-lecture', 'calculerTempsLecture')->name('temps.calcul');
        // nom complet : reader.documentations.temps.calcul
    });

    // Favoris (lecture + ajouter/retirer)
    Route::controller(FavoriteController::class)->prefix('favoris')->name('favoris.')->group(function () {
        Route::get('/', 'index')->name('index');// nom complet : reader.favoris.index
        Route::post('/ajouter', 'ajouterAuxFavoris')->name('ajouter');// nom complet : reader.favoris.ajouter
        Route::delete('/{docId}', 'retirerFavori')->name('retirer');// nom complet : reader.favoris.retirer
    });
});

/*
|--------------------------------------------------------------------------
| Routes Admin (auth + admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Gestion Projets
    Route::controller(ProjectController::class)->prefix('projects')->name('projects.')->group(function () {
        Route::get('/', 'index')->name('index');//nom complet : admin.projects.index et le route complet : /admin/projects
        Route::get('/create', 'create')->name('create');//nom complet : admin.projects.create
        Route::post('/', 'store')->name('store');//nom complet : admin.projects.store pour stocker un nouveau projet
        Route::get('/{id}', 'show')->name('show');//nom complet : admin.projects.show pour afficher un projet spécifique
        Route::get('/{id}/edit', 'edit')->name('edit');//nom complet : admin.projects.edit formulaire d'édition
        Route::put('/{id}', 'update')->name('update');//nom complet : admin.projects.update pour mettre à jour un projet
        Route::delete('/{id}', 'destroy')->name('destroy');//nom complet : admin.projects.destroy pour supprimer un projet
    });

    // Gestion Catégories
    Route::controller(CategoryController::class)->prefix('categories')->name('categories.')->group(function () {
        Route::get('/', 'index')->name('index');// Liste des catégories
        Route::get('/create', 'create')->name('create');// Formulaire de création
        Route::post('/', 'store')->name('store');// Stocker une nouvelle catégorie
        Route::get('/{id}', 'show')->name('show');// Détails d'une catégorie
        Route::get('/{id}/edit', 'edit')->name('edit');// Formulaire d'édition
        Route::put('/{id}', 'update')->name('update');// Mettre à jour une catégorie
        Route::delete('/{id}', 'destroy')->name('destroy');// Supprimer une catégorie
    });

    // Gestion Documentations
    Route::controller(DocumentationController::class)->prefix('documentations')->name('documentations.')->group(function () {
        Route::get('/', 'index')->name('index');//nom complet : admin.documentations.index
        Route::get('/create', 'create')->name('create');//nom complet : admin.documentations.create
        Route::post('/', 'store')->name('store');//nom complet : admin.documentations.store
        Route::get('/{id}', 'show')->name('show');//nom complet : admin.documentations.show
        Route::get('/{id}/edit', 'edit')->name('edit');//nom complet : admin.documentations.edit
        Route::put('/{id}', 'update')->name('update');//nom complet : admin.documentations.update
        Route::delete('/{id}', 'destroy')->name('destroy');//nom complet : admin.documentations.destroy
    });

    // Gestion utilisateurs
    Route::controller(UserController::class)->prefix('users')->name('users.')->group(function () {
        Route::get('/', 'index')->name('index');// Liste des utilisateurs nom complet : admin.users.index
        Route::get('/{id}', 'show')->name('show');// Détails utilisateur nom complet : admin.users.show
    });
});
