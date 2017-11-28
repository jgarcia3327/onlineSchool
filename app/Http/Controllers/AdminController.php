<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Student;
use App\Http\Controllers\CreditController;
use Carbon\Carbon;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\WageController;

class AdminController extends Controller
{
    public function index() {
      return view('admin.index');
    }

    public function student() {
      if (Auth::user()->is_admin != 1) {
        return redirect('');
      }

      $student = Student::select('students.*','users.email','balances.amount')->leftJoin('balances','balances.user_id','=','students.user_id')->leftJoin('users','users.id','=','students.user_id')->where('students.active',1)->orderBy('id', 'desc')->get();

      $student_info = null;
      foreach($student AS $v) {
        $student_info[] = array(
          'name' => ucfirst($v->fname)." ".ucfirst($v->lname),
          'gender' => ucfirst($v->gender),
          'contact' => $v->contact,
          'skype' => $v->skype,
          'email' => $v->email,
          'register' => $v->create_date,//$v->create_date->diffForHumans(),
          'credit' => CreditController::getCreditCount($v->user_id),
          'balance' => empty($v->amount)? "-" : $v->amount
        );
      }

      return view('admin.student', compact('student_info'));

    }

    public function schedule() {
      if (Auth::user()->is_admin != 1) {
        return redirect('');
      }

      $future_schedules = ScheduleController::getAllFutureSchedules();
      $past_schedules = ScheduleController::getAllPastSchedules();

      $schedules = array($future_schedules, $past_schedules);
      return view('admin.schedules', compact('schedules'));
    }

    public function teacherSalary() {
      if (Auth::user()->is_admin != 1) {
        return redirect('');
      }

      $dt = Carbon::now();
      $pitch = $dt->day > 15? 2 : 1;
      $wages = WageController::getTeacherWage($dt->year, $dt->month, $pitch, Auth::user());
      $wages[] = null;
      //$wages = WageController::getTeacherWage($datePieces[0], $datePieces[1], $datePieces[2], Auth::user());

      return view('admin.teacherSalary', compact('wages'));
    }

    public function scheduleEditor() {
      return view('admin.scheduleEditor');
    }
}
