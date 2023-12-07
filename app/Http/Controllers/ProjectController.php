<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest\StoreProjectRequest;
use App\Http\Requests\ProjectRequest\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\Status;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class ProjectController extends Controller
{
    private User $user;
    private Project $project;
    private Status $status;

    public function __construct(User $user, Project $project, Status $status)
    {
        $this->user = $user;
        $this->project = $project;
        $this->status = $status;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $status = $this->status::all();
        $projects = ProjectResource::collection(
            $this->project::query()->paginate(config('app.default_pagination_size'))
        );
        return view('pages.pages.project.index', compact('projects', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $this->project::create($request->projectAttributes());
        return redirect()->route('projects.index')->with('success', 'opération éffectuée');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project): \Illuminate\Contracts\Foundation\Application|Factory|View|Application
    {
        $project = new ProjectResource($project);
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $status = $this->status::all();
        $project = new ProjectResource($project);
        return view('pages.pages.project.index', compact('project', 'status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $project->update($request->projectAttributes());
        return redirect()->route('projects.index')->with('success', 'opération éffectuée');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'opération éffectuée');
    }
}
