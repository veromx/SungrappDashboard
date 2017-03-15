<?php

namespace Sungrapp\Http\Controllers;

use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Project::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Some view to create
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        // Create a Project 
        return Project::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \Sungrapp\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return $project;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Sungrapp\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Sungrapp\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProjectRequest $request, Project $project)
    {
		// Update with the request info
		$project->update($request->all());
		return $project;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Sungrapp\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // deletes a Project
		Project::findOrFail($id)->delete();

        // returns all the active Projects
		return Project::all();
    }
}
