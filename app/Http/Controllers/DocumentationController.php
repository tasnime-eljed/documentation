<?php

namespace App\Http\Controllers;

use App\Models\Documentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentationController extends Controller
{
    public function index()
    {
        $documentations = Documentation::with(['category', 'user'])
                                       ->latest()
                                       ->paginate(12);
        return view('documentations.index', compact('documentations'));
    }

    public function show($id)
    {
        $documentation = Documentation::with(['category.project', 'user'])
                                     ->findOrFail($id);

        $documentation->incrementerVues();

        $isFavorite = false;
        if (Auth::check()) {
            $isFavorite = Auth::user()->favoris()->where('docId', $id)->exists();
        }

        return view('documentations.show', compact('documentation', 'isFavorite'));
    }

    public function lireLaDocumentations($id)
    {
        return $this->show($id);
    }

    public function mettreAJourNombreDesVues($id)
    {
        $documentation = Documentation::findOrFail($id);
        $documentation->mettreAJourNombreVues();

        return response()->json([
            'success' => true,
            'vues' => $documentation->vues,
        ]);
    }

    public function calculerTempsLecture($id)
    {
        $documentation = Documentation::findOrFail($id);
        $tempsLecture = $documentation->calculerTempsLecture();

        return response()->json([
            'success' => true,
            'temps_lecture' => $tempsLecture,
        ]);
    }
}
