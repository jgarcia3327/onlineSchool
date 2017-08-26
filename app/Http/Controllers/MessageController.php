<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use View;
use App\Models\Message;
use DB;
use App\Models\Teacher;
use App\Models\Student;
use Carbon\Carbon;

class MessageController extends Controller
{
    //

    public function index() {
      // Student
      if (Auth::user()->is_student == 1) {
        $messages = Message::select("teachers.fname", "teachers.lname", "teachers.user_id AS uid", DB::raw("MAX(messages.create_date) AS date, COUNT(*) AS msgcount"))->leftJoin("teachers", function($join){$join->on("teachers.user_id","=","message_to")->orOn("teachers.user_id","=","message_from");})->groupBy("fname","lname","uid")->where('message_to', Auth::user()->id)->orWhere('message_from', Auth::user()->id)->orderBy('date','desc')->get();
      }
      // Teacher
      else {
        $messages = Message::select("students.fname", "students.lname", "students.user_id AS uid", DB::raw("MAX(messages.create_date) AS date, COUNT(*) AS msgcount"))->leftJoin("students", function($join){$join->on("students.user_id","=","message_to")->orOn("students.user_id","=","message_from");})->groupBy("fname","lname","uid")->where('message_to', Auth::user()->id)->orWhere('message_from', Auth::user()->id)->orderBy('date','desc')->get();
      }
      //dd($messages);
      return view("messages.index", compact('messages'));
    }


    public function show($id) {

      $condition1 = [
        ["message_to","=",Auth::user()->id],
        ["message_from","=",$id]
      ];
      $condition2 = [
        ["message_to","=",$id],
        ["message_from","=",Auth::user()->id]
      ];
      $message = Message::where($condition1)->orWhere($condition2)->get(); //Load more TODO

      // Student
      if (Auth::user()->is_student == 1) {
        $recipient = Teacher::where('user_id',$id)->first();
      }
      // Teacher
      else {
        $recipient = Student::where('user_id',$id)->first();
      }
      $messages = array($message, $recipient);
      //dd($messages);
      return view("messages.show", compact('messages'));
    }


    public function store(Request $request) {

      $data = array(
        "message_from" => Auth::user()->id,
        "message_to" => $request->message_to,
        "message" => $request->message,
        "create_date" => Carbon::now()
      );
      Message::create($data);
      //return back()->with("success", 1);
      return redirect("/messages/".$request->message_to);
    }
}
