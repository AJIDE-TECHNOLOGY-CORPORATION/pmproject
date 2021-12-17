<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Auth;

class AdminProjectController extends Controller
{
    /* project index*/
    public function projectsIndex(Request $request)
    {
        /* if the url has get method */
        $projects = Project::latest()->paginate(15);
        return view('admin.project.index', compact('projects'));
    }

    /* project creation*/
    public function createProject(Request $request)
    {
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.project.create');
        } else {
            /* if the url has post method */
            $project = new Project();
            $project->user_id = Auth::user()->id;
            $project->customer_id = $request->customer_id;
            $project->title = $request->title;
            $project->description = $request->description;
            $project->end_date= $request->end_date;
            $project->start_date= $request->start_date;
            $project->status = $request->status;
            $project->save();
            return redirect('/admin/projects')->with('message', 'Project created Successfully.');
        }
    }

    /* destroy project information*/
    public function destroyProject($id)
    {
        $project = Project::find($id);
        $project->delete();
        return redirect()->back()->with('message', 'Project Destroyed Successfully');
    }

    /* project updation */
    public function updateProject(Request $request, $id)
    {
        $project = Project::find($id);

        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.project.create', compact('project'));
        } else {

            /* if the url has post method */
            $project->customer_id = $request->customer_id;
            $project->user_id = Auth::user()->id;
            $project->title = $request->title;
            $project->description = $request->description;
            $project->end_date= $request->end_date;
            $project->start_date= $request->start_date;
            $project->status = $request->status;
            $project->save();
            return redirect('/admin/projects')->with('message', 'Project Updated Successfully');
        }
    }
}
