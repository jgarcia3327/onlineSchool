<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use View;
use Auth;
use App\Models\Education;

class TeacherEducationController extends Controller
{

    private function isTeacher() {
        return (Auth::user()->is_student == 0);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!$this->isTeacher()) {
            return redirect('/home');
        }
        return view('teacherEducation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if (!$this->isTeacher()) {
          return redirect('/home');
      }
      $education = new Education;
      $dataSet[] = [
            'user_id' => Auth::user()->id,
            'school_name' => $request->school_name,
            'degree' => $request->degree,
            'start_date' => $request->start_year."-".$request->start_month."-"."01",
            'end_date' => $request->end_year."-".$request->end_month."-"."01"
        ];
      $education->insert($dataSet);

      $id = $education->id;
      return redirect('/teacherProfile/'.Auth::user()->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $education = Education::findOrFail($id);
        if ($education->user_id != Auth::user()->id) {
            return redirect('/home');
        }
        return view('teacherEducation.edit', compact('education'));
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
        $education = Education::findOrFail($id);
        if ($education->user_id != Auth::user()->id) {
            return redirect('/home');
        }
        $education->school_name = $request->school_name;
        $education->degree = $request->degree;
        $education->start_date = $request->start_year."-".$request->start_month."-"."01";
        $education->end_date = $request->end_year."-".$request->end_month."-"."01";
        $education->save();

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
        $education = Education::findOrFail($id);
        if ($education->user_id != Auth::user()->id) {
            return redirect('/home');
        }
        $education->delete();

        return redirect('/teacherProfile');
    }
}
