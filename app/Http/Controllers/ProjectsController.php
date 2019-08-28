<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
//        $projects = Project::all();
        $projects = Project::where('owner_id', auth()->id())->get();

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store()
    {
//        Project::create(request()->validate([
//            'title' => ['required', 'min:3'],
//            'description' => ['required', 'min:4']
//        ]));

        $attributes = request()->validate([
            'title' => ['required', 'min:3'],
            'description' => ['required', 'min:3']
        ]);
        Project::create($attributes + ['owner_id' => auth()->id()]);

        return redirect('/projects');
    }

    public function show(Project $project)
    {

        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Project $project)
    {
        $project->update(request(['title', 'description']));

        return redirect('/projects');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect('/projects');
    }

}
