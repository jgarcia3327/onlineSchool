<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Schedule;
use App\User;
use Carbon\Carbon;

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
        ['active','=',1],
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

}
