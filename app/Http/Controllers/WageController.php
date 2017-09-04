<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Schedule;
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
        //['student_user_id','<>',null],
        ['active','=',1],
        ['teacher_user_id','=',$user->id],
        ['date_time', '>=', $dateStart." 00:00:00"],
        ['date_time', '<=', $dateEnd." 23:59:59"]
      ];

      return array(Schedule::where($condition)->get(), $dateStart, $dateEnd);
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

  public function show(Request $request) {
    if( Auth::user()->is_student === 0 ) {

      $wages = WageController::getTeacherWage($request->year, $request->month, $request->pitch, Auth::user());

      return view('wage.index', compact('wages'));
    }
    return back()->with('error', "You don't have permission to visit the page.");
  }

}
