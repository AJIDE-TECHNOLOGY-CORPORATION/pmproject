<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Auth;

class AdminTaskController extends Controller
{
    /* task index*/
    public function tasksIndex(Request $request)
    {
        /* if the url has get method */
        $tasks = Task::latest()->paginate(15);
        return view('admin.task.index', compact('tasks'));
    }

    /* task creation*/
    public function createTask(Request $request)
    {
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.task.create');
        } else {
            /* if the url has post method */
            $task = new Task();
            $task->project_id = $request->project_id;
            $task->user_id = Auth::user()->id;
            $task->title = $request->title;
            $task->description = $request->description;
            $task->deadline_date= $request->deadline_date;
            $task->start_date= $request->start_date;
            $task->status = $request->status;
            $task->save();
            return redirect('/admin/tasks')->with('message', 'Task created Successfully.');
        }
    }

    /* destroy task information*/
    public function destroyTask($id)
    {
        $task = Task::find($id);
        $task->delete();
        return redirect()->back()->with('message', 'Task Destroyed Successfully');
    }

    /* task updation */
    public function updateTask(Request $request, $id)
    {
        $task = Task::find($id);

        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.task.create', compact('task'));
        } else {

            /* if the url has post method */
            $task->project_id = $request->project_id;
            $task->title = $request->title;
            $task->description = $request->description;
            $task->deadline_date= $request->deadline_date;
            $task->start_date= $request->start_date;
            $task->status = $request->status;
            $task->save();
            return redirect('/admin/tasks')->with('message', 'Task Updated Successfully');
        }
    }

}
