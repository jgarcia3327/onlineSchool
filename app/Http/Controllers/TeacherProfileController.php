<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use View;
use Auth;
use App\Models\Teacher;
use App\Models\Education;

class TeacherProfileController extends Controller
{

    private function hasProfile() {
        if ($this->isTeacher())
            return (Teacher::where('user_id', Auth::user()->id)->count() != 0);
    }

    private function isTeacher() {
        return (Auth::user()->is_student == 0);
    }

    private function getProfile() {
        if ($this->isTeacher()) {
            return Teacher::where('user_id', Auth::user()->id)->first();
        }
        return null;
    }

    private function getTeacherProfile($id) {
        if ($this->isTeacher()) {
            return Teacher::where('id', $id)->first();
        }
        return null;
    }

    public function index()
    {
      if (!$this->hasProfile()) {
            return redirect('/teacherProfile/create');
      }
      $profile = $this->getProfile();
      $education = Education::where('user_id', Auth::user()->id)->get();
      $profiles = array("profile" => $profile, "education" => $education);
      return view('teacherProfile.index', compact('profiles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $profile = $this->getProfile();
        // Redirect to edit if student profile exist
        if ($profile != null) {
          return redirect('/teacherProfile/'.$profile->id.'/edit');
        }
        return view('teacherProfile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->hasProfile()) {
            return redirect('/teacherProfile');
        }
        if (!$this->isTeacher()) {
            return redirect('/home');
        }
        $id = Teacher::create($request->all())->id;
        return redirect('/teacherProfile/'.$id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $profile = $this->getTeacherProfile($id);
      $education = Education::where('user_id', Auth::user()->id)->get();
      $profiles = array("profile" => $profile, "education" => $education);
      return view('teacherProfile.index', compact('profiles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $profile = $this->getTeacherProfile($id);
      if($profile == null || $profile->user_id !== Auth::user()->id) {
          if ($profile == null) return redirect('/teacherProfile/create');
          return redirect('/teacherProfile/'.$profile->id.'/edit');
      }
      return view('teacherProfile.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $teacherProfile = Teacher::findOrFail($id);

        if (!$this->isTeacher() || $teacherProfile->user_id != Auth::user()->id) {
            return redirect('/home');
        }

        $teacherProfile->update($request->all());

        return redirect('/teacherProfile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
