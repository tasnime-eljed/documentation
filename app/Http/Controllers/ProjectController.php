<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('user')->latest()->paginate(10);
        return view('projects.index', compact('projects'));
    }

    public function show($id)
    {
        $project = Project::with(['categories.documentations'])->findOrFail($id);
        return view('projects.show', compact('project'));
    }

    public function consulterLesProjets()
    {
        return $this->index();
    }
}
