<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use View;
use Auth;
use App\Models\Teacher;
use App\Models\Schedule;
use App\Http\Controllers\CreditController;
use Carbon\Carbon;

class ReserveTeacherController extends Controller
{
    //
    public function index() {

      $teachers = Teacher::where('active', 1)->orderBy('fname', 'asc')->orderBy('lname', 'asc')->get();
      return view('reserveTeacher.index', compact('teachers'));
    }

    public function show($teacher_user_id) {

      $teacher = Teacher::where('user_id', $teacher_user_id)->first();
      $credits = CreditController::getCreditCount(Auth::user()->id);
      $reservations = array($teacher, $credits);
      return view('reserveTeacher.schedule', compact('reservations'));
    }

    public function ajax($dateId) {

      $date = strstr($dateId,"|",true);
      $teacherUserId = substr(strstr($dateId,"|"),1);
      $condition = [['teacher_user_id','=',$teacherUserId],
        ['date_time', '>=', $date." 00:00:00"],
        ['date_time', '<=', $date." 23:59:59"]];
      $schedules = Schedule::where($condition)->orderBy('date_time', 'asc')->get();
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

      $creditLeft = CreditController::getCreditCount(Auth::user()->id);
      if($creditLeft < count($request->schedule_id)){
        //dd($creditLeft."===".count($request->schedule_id));
        return back()->with("success", -1);
      }

      $schedArr = array();
      foreach($request->schedule_id AS $sched_id) {
        //Update individually
        $condSched = [
          ['active','=',1],
          ['id','=',$sched_id],
          ['student_user_id','=',null],
          ['date_time','>',Carbon::now()]
        ];
        $schedule = Schedule::where("id",$sched_id)->first();
        if ( $schedule != null ) {
          //Update credit
          CreditController::updateCreditSchedule(Auth::user()->id, $schedule->id);
          //Update schedule
          //$schedule->update(['student_user_id' => Auth::user()->id]);
          $schedArr[] = $sched_id;
        }
      }
      //Update schedule at once
      if (count($schedArr) > 0) {
        //Update schedule
        Schedule::whereIn("id", $schedArr)->update(['student_user_id' => Auth::user()->id]);
      }

      return redirect('/lessons');
    }
}
