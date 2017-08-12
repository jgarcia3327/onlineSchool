<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use View;
use App\Models\Student;
use Auth;

class ProfileController extends Controller
{
    public function __construct()
    {

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
        if (!$this->hasProfile()) {
              return redirect('/profile/create');
        }
        $profile = $this->getProfile();
        return view('profile.index', compact('profile'));
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
        $profile = $this->getStudentProfile($id);
        return view('profile.index', compact('profile'));
    }

    public function edit($id)
    {
        $profile = $this->getStudentProfile($id);
        if($profile == null || $profile->user_id !== Auth::user()->id) {
            if ($profile == null) return redirect('/profile/create');
            return redirect('/profile/'.$profile->id.'/edit');
        }
        return view('profile.edit', compact('profile'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
