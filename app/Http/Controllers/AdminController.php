<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Student;
use App\Http\Controllers\CreditController;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index() {
      return view('admin.index');
    }

    public function student() {
      if (Auth::user()->is_admin != 1) {
        return redirect('');
      }

      $student = Student::select('students.*','balances.amount')->leftJoin('balances','balances.user_id','=','students.user_id')->where('active',1)->orderBy('id', 'desc')->get();

      $student_info = null;
      foreach($student AS $v) {
        $student_info[] = array(
          'name' => ucfirst($v->fname)." ".ucfirst($v->lname),
          'gender' => ucfirst($v->gender),
          'contact' => $v->contact,
          'skype' => $v->skype,
          'register' => $v->create_date,//$v->create_date->diffForHumans(),
          'credit' => CreditController::getCreditCount($v->user_id),
          'balance' => empty($v->amount)? "-" : $v->amount
        );
      }

      return view('admin.student', compact('student_info'));

    }
}
