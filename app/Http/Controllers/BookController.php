<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use View;
use App\Models\Book;
use File;

class BookController extends Controller
{

    public function index(){
      $books = Book::where("active",1)->orderBy('title','asc')->get();
      return view('misc.books',compact('books'));
    }

    public function store(Request $request)
    {

      if($request->hasFile('book')) {
        //dd($request->book);
        $bookFiles = array(
          'application/pdf'
        );
        if (in_array($request->book->getClientMimeType(), $bookFiles)) {
          //Save to db
          $data = array(
            "user_id" => Auth::user()->id,
            "title" => $request->title,
            "description" => $request->description,
            "file_name" => $request->book->getClientOriginalName()
          );
          $book = Book::create($data);
          $file = $request->file('book');
          $location = public_path('../../englishhours.net/uploaded_books/'.$book->id.'/');
          //$location = public_path('uploaded_books/'.$book->id.'/');
          $file->move($location, $request->book->getClientOriginalName());
        }
        return redirect()->back()->with('success', 'File uploaded successfully.');
      }
      return redirect()->back()->with('error', 'Something went wrong uploading your book.');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        if (Auth::user()->is_admin != 1) {
            return redirect()->back()->with('error', 'Delete not permitted.');
        }
        //Delete physical pdf file
        $location = public_path('uploaded_books/'.$book->id.'/');
        File::deleteDirectory($location);
        $book->delete();

        return redirect()->back()->with('success', 'File deleted successfully.');
    }
}
