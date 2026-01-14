<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SharedLinkController;

/*
|--------------------------------------------------------------------------
| Routes Publiques
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Routes d'authentification
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
| Routes Protégées (Authentification requise)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard utilisateur
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profil utilisateur
    Route::controller(UserController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'profile')->name('index');
        Route::put('/update', 'updateProfile')->name('update');
        Route::put('/password', 'changePassword')->name('password');
    });

    // Projets (Consultation)
    Route::controller(ProjectController::class)->prefix('projects')->name('projects.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/consulter/liste', 'consulterLesProjets')->name('consulter');
    });

    // Catégories (Consultation)
    Route::controller(CategoryController::class)->prefix('categories')->name('categories.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/consulter/liste', 'consulterLesCategories')->name('consulter');
    });

    // Documentations (Consultation + Actions)
    Route::controller(DocumentationController::class)->prefix('documentations')->name('documentations.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/lire', 'lireLaDocumentations')->name('lire');
        Route::post('/{id}/vues', 'mettreAJourNombreDesVues')->name('vues.update');
        Route::get('/{id}/temps-lecture', 'calculerTempsLecture')->name('temps.calcul');
    });

    // Favoris
    Route::controller(FavoriteController::class)->prefix('favoris')->name('favoris.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/ajouter', 'ajouterAuxFavoris')->name('ajouter');
        Route::delete('/{docId}', 'retirerFavori')->name('retirer');
    });
});

/*
|--------------------------------------------------------------------------
| Routes Admin (Authentification + Role Admin requis)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Gestion des Projets
    Route::controller(AdminController::class)->prefix('projects')->name('projects.')->group(function () {
        Route::get('/', function () {
            return view('admin.projects.index', [
                'projects' => \App\Models\Project::with('user')->latest()->paginate(10)
            ]);
        })->name('index');

        Route::get('/create', function () {
            return view('admin.projects.create');
        })->name('create');

        Route::post('/', 'ajouterProjet')->name('store');

        Route::get('/{id}', function ($id) {
            return view('admin.projects.show', [
                'project' => \App\Models\Project::with('categories')->findOrFail($id)
            ]);
        })->name('show');

        Route::get('/{id}/edit', function ($id) {
            return view('admin.projects.edit', [
                'project' => \App\Models\Project::findOrFail($id)
            ]);
        })->name('edit');

        Route::put('/{id}', 'modifierProjet')->name('update');
        Route::delete('/{id}', 'supprimerProjet')->name('destroy');
    });

    // Gestion des Catégories
    Route::controller(AdminController::class)->prefix('categories')->name('categories.')->group(function () {
        Route::get('/', function () {
            return view('admin.categories.index', [
                'categories' => \App\Models\Category::with('project')->latest()->paginate(15)
            ]);
        })->name('index');

        Route::get('/create', function () {
            return view('admin.categories.create', [
                'projects' => \App\Models\Project::all()
            ]);
        })->name('create');

        Route::post('/', 'ajouterCategorie')->name('store');

        Route::get('/{id}', function ($id) {
            return view('admin.categories.show', [
                'category' => \App\Models\Category::with('documentations')->findOrFail($id)
            ]);
        })->name('show');

        Route::get('/{id}/edit', function ($id) {
            return view('admin.categories.edit', [
                'category' => \App\Models\Category::findOrFail($id),
                'projects' => \App\Models\Project::all()
            ]);
        })->name('edit');

        Route::put('/{id}', 'modifierCategorie')->name('update');
        Route::delete('/{id}', 'supprimerCategorie')->name('destroy');
    });

    // Gestion des Documentations
    Route::controller(AdminController::class)->prefix('documentations')->name('documentations.')->group(function () {
        Route::get('/', function () {
            return view('admin.documentations.index', [
                'documentations' => \App\Models\Documentation::with('category')->latest()->paginate(15)
            ]);
        })->name('index');

        Route::get('/create', function () {
            return view('admin.documentations.create', [
                'categories' => \App\Models\Category::with('project')->get()
            ]);
        })->name('create');

        Route::post('/', 'ajouterDocumentation')->name('store');

        Route::get('/{id}', function ($id) {
            return view('admin.documentations.show', [
                'documentation' => \App\Models\Documentation::with('category.project')->findOrFail($id)
            ]);
        })->name('show');

        Route::get('/{id}/edit', function ($id) {
            return view('admin.documentations.edit', [
                'documentation' => \App\Models\Documentation::findOrFail($id),
                'categories' => \App\Models\Category::with('project')->get()
            ]);
        })->name('edit');

        Route::put('/{id}', 'modifierDocumentation')->name('update');
        Route::delete('/{id}', 'supprimerDocumentation')->name('destroy');
    });

    // Génération de liens partagés
    Route::post('/shared-links/{docId}', [AdminController::class, 'genererLienPartage'])
        ->name('shared.generate');

    // Gestion des utilisateurs
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', function () {
            return view('admin.users.index', [
                'users' => \App\Models\User::latest()->paginate(20)
            ]);
        })->name('index');

        Route::get('/{id}', function ($id) {
            return view('admin.users.show', [
                'user' => \App\Models\User::with('documentations', 'projects')->findOrFail($id)
            ]);
        })->name('show');
    });
});

/*
|--------------------------------------------------------------------------
| Routes API (Optionnel - pour AJAX)
|--------------------------------------------------------------------------
*/

Route::prefix('api')->middleware(['auth'])->name('api.')->group(function () {

    // Favoris API
    Route::post('/favoris/toggle', function (\Illuminate\Http\Request $request) {
        $userId = auth()->id();
        $docId = $request->input('docId');

        $exists = \App\Models\Favorite::where('userId', $userId)
            ->where('docId', $docId)
            ->exists();

        if ($exists) {
            \App\Models\Favorite::where('userId', $userId)
                ->where('docId', $docId)
                ->delete();
            return response()->json(['status' => 'removed', 'message' => 'Retiré des favoris']);
        } else {
            \App\Models\Favorite::create([
                'userId' => $userId,
                'docId' => $docId
            ]);
            return response()->json(['status' => 'added', 'message' => 'Ajouté aux favoris']);
        }
    })->name('favoris.toggle');

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
