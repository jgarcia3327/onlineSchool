<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Schedule;
use App\Models\Credit;
use App\User;
use Carbon\Carbon;
use App\Http\Controllers\CreditController;

class WageController extends Controller
{

  public static function getTeacherWage($year, $month, $pitch, $user){
    if ($user->is_student === 0) {

      if($pitch == 1) {
        $dateStart = date("Y-m-d", strtotime($year.'-'.$month.'-01'));
        $dateEnd = date("Y-m-d", strtotime($year.'-'.$month.'-15'));
      }
      else{
        $dateStart = date("Y-m-d", strtotime($year.'-'.$month.'-16'));
        $dateEnd = date("Y-m-d", strtotime($year.'-'.$month.'-'.date('t', strtotime($dateStart))));
      }
      $condition = [
        ['student_user_id','<>',null], // Exclude open/no-student schedule
        //['active','=',1], // Missed call
        ['teacher_user_id','=',$user->id],
        ['date_time', '>=', $dateStart." 00:00:00"],
        ['date_time', '<=', $dateEnd." 23:59:59"]
      ];

      $teacherScheds = Schedule::where($condition)->get();

      return array($teacherScheds, $dateStart, $dateEnd);
    }
    return null;
  }

  public function index() {
    if( Auth::user()->is_student === 0 ) {
      $dt = Carbon::now();
      $pitch = $dt->day > 15? 2 : 1;
      $wages = WageController::getTeacherWage($dt->year, $dt->month, $pitch, Auth::user());

      return view('wage.index', compact('wages'));
    }
    return back()->with('error', "You don't have permission to visit the page.");
  }

  public function show($date) {
    if( Auth::user()->is_student === 0 ) {
      $datePieces = explode('-', $date);
      if (empty($datePieces[0]) || empty($datePieces[1]) || empty($datePieces[2])) {
        return redirect('/wage');
      }
      $wages = WageController::getTeacherWage($datePieces[0], $datePieces[1], $datePieces[2], Auth::user());

      return view('wage.index', compact('wages'));
    }
    return back()->with('error', "You don't have permission to visit the page.");
  }

  public function admin($date_teacher) {
    if (Auth::user()->is_admin != 1) {
      return redirect('');
    }
    $datePieces = explode('-', $date_teacher);
    if (empty($datePieces[0]) || empty($datePieces[1]) || empty($datePieces[2]) || empty($datePieces[3])) {
      return redirect('/adminTeacherSalary');
    }
    $teacher = User::where("id",$datePieces[3])->first();
    if ($teacher == null) {
      return redirect('/adminTeacherSalary');
    }
    $wages = WageController::getTeacherWage($datePieces[0], $datePieces[1], $datePieces[2], $teacher);
    $wages[] = $datePieces[3];

    return view('admin.teacherSalary', compact('wages'));
  }

  public function creditMissedCall(Request $request) {
    if (Auth::user()->is_admin != 1) {
      return redirect('');
    }
    $isSuccess = true;
    if ($request->has('schedID')){
      //dd($request->all());
      // Get selected missed call
      foreach($request->schedID AS $v) {
        // Get student credit
        //$schedule = Schedule::where([['id','=',$v], ['active','=',0]])->first();
        $schedule = Schedule::where('id',$v)->first();
        if ($schedule == null) continue;
        $credit = Credit::where('id',$schedule->credit_id)->first();

        // Check if credit returned from missed call status has been used
        if ($credit == null) { // We don't have records with the $credit_id, this happens if schedules has been created before Nov. 1, 2017
          $isSuccess = $this->updateCreditSchedule($schedule);
        }
        else if ($credit->schedule_id != null) { // Student credit has been assigned to new schedule
          // Check if student has extra credit to replace with the original credit
          if (!$this->updateCreditSchedule($schedule)) { // Student don't have extra credit
            // Check if assigned session is in future sched
            $newSchedule = Schedule::where([['credit_id','=',$credit->id],['student_user_id','=',$schedule->student_user_id], ['active','=',1]])->first();
            if ($newSchedule->called != 1) { // We have future sched, session not yet started
              // Free schedule
              $newSchedule->student_user_id = null;
              $newSchedule->credit_id = null;
              $newSchedule->save();
            }
            else { // We have past sched, therefore we need to credit another credit ID from student
              $isSuccess = false;
            }
          }
        }
        else { // no problem, credit still available
          // Update credit
          $credit->schedule_id = $v;
          $credit->save();
          // Update schedule
          $schedule->called = 1;
          $schedule->active = 1;
          $schedule->save();
        }
      }
    }

    if ($isSuccess) {
      return back()->with('success', 'Missed session successfully credited as successful session.');
    }

    return back()->with('error', 'Student do not have available lesson credit to be credited to missed session! Please try again once the student has an extra credit.');

  }

  private function updateCreditSchedule($schedule) {
    // Update credit
    $credit_id = CreditController::updateCreditSchedule($schedule->student_user_id, $schedule->id);
    if ($credit_id > 0) {
      // Update schedule
      $schedule->credit_id = $credit_id;
      $schedule->called = 1;
      $schedule->active = 1;
      $schedule->save();
      return true;
    }
    else { // Student don't have available credit
      return false;
    }
  }

}
