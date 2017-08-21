<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use View;
use App\Models\Student;
use Auth;
use App\Models\Schedule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function hasProfile() {
        if ($this->isStudent())
            return (Student::where('user_id', Auth::user()->id)->count() != 0);
        return (Teacher::where('user_id', Auth::user()->id)->count() != 0);
    }

    private function isStudent() {
        return (Auth::user()->is_student == 1);
    }

    private function getProfile() {
        if ($this->isStudent()) {
            return Student::where('user_id', Auth::user()->id)->first();
        }
        return null;
    }

    private function getStudentProfile($id) {
        if ($this->isStudent()) {
            return Student::where('id', $id)->first();
        }
        return null;
    }

    public function index()
    {
        if (!$this->isStudent()) {
              return redirect('');
        }
        $profile = $this->getProfile();
        $condition = [['student_user_id','=',Auth::user()->id],
          ['date_time', '<=', date("Y-m-d H:i:s")]
        ];
        $scheds = Schedule::select("schedules.*","teachers.fname","teachers.lname")->leftjoin('teachers', 'schedules.teacher_user_id', '=', 'teachers.user_id')->where($condition)->orderBy('date_time', 'desc')->limit(20)->get();
        $profiles = array($profile, $scheds);
        return view('profile.index', compact('profiles'));
    }

    public function create()
    {
        $profile = $this->getProfile();
        // Redirect to edit if student profile exist
        if ($profile != null) {
          return redirect('/profile/'.$profile->id.'/edit');
        }
        return view('profile.create');
    }

    public function store(Request $request)
    {
        if ($this->hasProfile()) {
            return redirect('/profile');
        }
        $id = 0;
        if ($this->isStudent()) {
            $id = Student::create($request->all())->id;
        }
        return redirect('/profile/'.$id);
    }

    public function show($id)
    {
        $profile = Student::where('id',$id)->first();
        //dd($profile);
        if ($this->isStudent() && $profile->user_id != Auth::user()->id){
            return redirect('/profile');
        }
        $condition = [['student_user_id','=',$profile->user_id],
          ['date_time', '<=', date("Y-m-d H:i:s")]
        ];
        $scheds = Schedule::select("schedules.*","teachers.fname","teachers.lname")->leftjoin('teachers', 'schedules.teacher_user_id', '=', 'teachers.user_id')->where($condition)->orderBy('date_time', 'desc')->limit(20)->get();
        $profiles = array($profile, $scheds);
        return view('profile.index', compact('profiles'));

    }

    public function edit($id)
    {
        if (!$this->isStudent()) {
          return redirect('');
        }
        $profile = Student::findOrFail($id);
        //dd($profile);
        if($profile->user_id != Auth::user()->id) {
            return redirect('/profile');
        }
        return view('profile.edit', compact('profile'));
    }

    public function update(Request $request, $id)
    {
      $profile = Student::findOrFail($id);

      if (!$this->isStudent() || $profile->user_id != Auth::user()->id) {
          return redirect('/home');
      }

      $profile->update($request->all());

      return redirect('/profile');
    }

    public function destroy($id)
    {
        //
    }
}
