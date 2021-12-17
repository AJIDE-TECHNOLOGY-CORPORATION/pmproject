<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminTodoController extends Controller
{
      /* todo index*/
      public function todosIndex(Request $request)
      {
          /* if the url has get method */
          $todos = Todo::latest()->paginate(15);
          return view('admin.todo.index', compact('todos'));
      }
       /* todo creation*/
    public function createTodo(Request $request)
    {
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.todo.create');
        } else {
            /* if the url has post method */
            $todos = new Todo();
            $todos->user_id = Auth::user()->id;
            $todos->title = $request->title;
            $todos->description = $request->description;
            $todos->due_date= $request->due_date;
            $todos->save();
            return redirect('/admin/todos')->with('message', 'Todo created Successfully.');
        }
    }

     /* destroy todo information*/
     public function destroyTodo($id)
     {
         $todo = Todo::find($id);
         $todo->delete();
         return redirect()->back()->with('message', 'Todo Destroyed Successfully');
     }
         /* todo updation */
    public function updateTodo(Request $request, $id)
    {
        $todo = Todo::find($id);
     
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.todo.create', compact('todo'));
        } else {
          
            /* if the url has post method */
            $todo->title = $request->title;
            $todo->description = $request->description;
            $todo->due_date = $request->due_date;
            $todo->save();
            return redirect('/admin/todos')->with('message', 'Todo Updated Successfully');
        }
    }

       /* update active and inactive status */
       public function changeStatus(Request $request)
       {
          $todo=Todo::find($request->id);
           if($todo->status==1) {
               /* if status is 1 - completed*/
              $todo->status = 0;
              $todo->completed_at = null;
           } else {
               /* if active flag is 0 - not completed*/
              $todo->status = 1;
              $todo->completed_at = Carbon::now()->format('Y-m-d H:i:s');
           }
          $todo->save();
           return response()->json("success");
       }
   
}
