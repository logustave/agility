<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest\StoreTaskRequest;
use App\Http\Requests\TaskRequest\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{
    private Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $tasks = TaskResource::collection(
            $this->task::query()->paginate(config('app.default_pagination_size'))
        );
        return view('pages.pages.task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $this->task::create($request->taskAttributes());
        return redirect()->route('tasks.index')->with('success', 'Operation effectuée');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): \Illuminate\Contracts\Foundation\Application|Factory|View|Application
    {
        $task = new TaskResource($task);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $task = new TaskResource($task);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $task->update($request->taskAttributes());
        return redirect()->route('tasks.index')->with('success', 'Operation effectuée');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Operation effectuée');
    }
}
