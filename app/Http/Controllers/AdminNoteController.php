<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminNoteController extends Controller
{
      /* notes index*/
      public function notesIndex(Request $request)
      {
          /* if the url has get method */
          $notes = Note::latest()->paginate(15);
          return view('admin.notes.index', compact('notes'));
      }
       /* notes creation*/
    public function createNotes(Request $request)
    {
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.notes.create');
        } else {
            /* if the url has post method */
            $notes = new Note();
            $notes->user_id = Auth::user()->id;
            $notes->title = $request->title;
            $notes->subject = $request->subject;
            $notes->note = $request->note;
            $notes->save();
            return redirect('/admin/notes')->with('message', 'Notes created Successfully.');
        }
    }

     /* destroy notes information*/
     public function destroyNotes($id)
     {
         $notes = Note::find($id);
         $notes->delete();
         return redirect()->back()->with('message', 'Notes Destroyed Successfully');
     }
         /* notes updation */
    public function updateNotes(Request $request, $id)
    {
        $notes = Note::find($id);
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.notes.create', compact('notes'));
        } else {
            /* if the url has post method */
            $notes->user_id = Auth::user()->id;
            $notes->title = $request->title;
            $notes->subject = $request->subject;
            $notes->note = $request->note;
            $notes->save();
            return redirect('/admin/notes')->with('message', 'Notes Updated Successfully');
        }
    }
}
