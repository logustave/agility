<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResourceRequest\StoreResourceRequest;
use App\Http\Requests\ResourceRequest\UpdateResourceRequest;
use App\Http\Resources\ResourceResource;
use App\Models\Resource;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class ResourceController extends Controller
{
    private Resource $resource;

    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $resources = ResourceResource::collection(
            $this->resource::query()->paginate(config('app.default_pagination_size'))
        );
        return view('pages.pages.resources.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('resources.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResourceRequest $request): RedirectResponse
    {
        $this->resource::create($request->resourceAttributes());

        return redirect()->route('resources.index')->with('success', 'Operation successfully completed');
    }

    /**
     * Display the specified resource.
     */
    public function show(Resource $resource): \Illuminate\Contracts\Foundation\Application|Factory|View|Application
    {
        $resource = new ResourceResource($resource);
        return view('resources.show', compact('resource'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resource $resource): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $resource = new ResourceResource($resource);
        return view('resources.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResourceRequest $request, Resource $resource): RedirectResponse
    {
        $resource->update($request->resourceAttributes());
        return redirect()->route('resources.index')->with('success', 'Operation successfully completed');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource): RedirectResponse
    {
        $resource->delete();
        return redirect()->route('resources.index')->with('success', 'Operation successfully completed');
    }
}
