<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use View;
use Auth;
use App\Models\Teacher;
use App\Models\Schedule;

class ReserveTeacherController extends Controller
{
    //
    public function index() {

      $activeTeachers = Teacher::where('active', 1)->orderBy('fname', 'asc')->orderBy('lname', 'asc')->get();
      //dd($activeTeachers);
      $teachers = array();
      foreach($activeTeachers AS $v) {
        $teachers[$v->user_id] = $v->fname." ".$v->lname;
      }
      return view('reserveTeacher.index', compact('teachers'));
    }

    public function show($teacher_user_id) {

      $teacher = Teacher::where('user_id', $teacher_user_id)->first();
      return view('reserveTeacher.schedule', compact('teacher'));
    }

    public function ajax($dateId) {

      $date = strstr($dateId,"|",true);
      $teacherUserId = substr(strstr($dateId,"|"),1);
      $condition = [['teacher_user_id','=',$teacherUserId],
        ['date_time', '>=', $date." 00:00:00"],
        ['date_time', '<=', $date." 23:59:59"]];
      $schedules = Schedule::where($condition)->get();
      $scheds = array();
      $enrolees = array();
      foreach($schedules AS $schedule ) {
        $scheds[$schedule->id] = substr($schedule->date_time, strpos($schedule->date_time, " ") + 1);
        $enrolees[$schedule->id] = $schedule->student_user_id;
      }
      $time = array($scheds, $enrolees, $date, $teacherUserId);
      return view('reserveTeacher.ajax', compact('time'));
    }

    public function update(Request $request, $id) {

      foreach($request->schedule_id AS $sched_id) {
        Schedule::findOrFail($sched_id)->update(['student_user_id' => Auth::user()->id]);
      }

      return redirect('/reserveTeacher');
    }
}
