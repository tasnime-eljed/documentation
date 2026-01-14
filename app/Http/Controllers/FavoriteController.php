<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Documentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $favoris = Auth::user()->favoris()->with('category')->get();
        return view('favoris.index', compact('favoris'));
    }

    public function ajouterAuxFavoris(Request $request)
    {
        $request->validate([
            'docId' => 'required|exists:documentations,id',
        ]);

        $favorite = Favorite::ajouterAuxFavoris(Auth::id(), $request->docId);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Ajouté aux favoris',
            ]);
        }

        return back()->with('success', 'Ajouté aux favoris');
    }

    public function retirerFavori($docId)
    {
        Favorite::retirerFavori(Auth::id(), $docId);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Retiré des favoris',
            ]);
        }

        return back()->with('success', 'Retiré des favoris');
    }
}
