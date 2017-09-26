<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Deposit;
use App\Models\Balance;
use App\Models\Student;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\MailController;

class DepositController extends Controller
{
    public function index() {
      $qDeposits = Deposit::where("user_id", Auth::user()->id)->orderBy('id','desc')->get();
      $success = null;
      $pending = null;
      if ($qDeposits != null) {
        foreach($qDeposits AS $v){
          if ($v->status == 1) {
            $success[] = $v;
          }
          else {
            $pending[] = $v;
          }
        }
      }
      $balance = Balance::where('user_id', Auth::user()->id)->first();
      $balanceAmount = $balance == null? 0 : $balance->amount;
      $deposits = array($success, $pending, $balanceAmount);
      return view('scheduleCredit.deposit', compact('deposits'));
    }

    public function store(Request $request) {
      if (Auth::user()->is_student == 1) {
        $amount = $request->amount;
        $insertData = array(
          'user_id' => Auth::user()->id,
          'amount' => $amount,
          'create_date' => Carbon::now()
        );
        Deposit::insert($insertData);

        $student = Student::where("user_id",Auth::user()->id)->first();
        //Send email to student
        MailController::sendMail(Auth::user()->email, "Deposit to EnglishHours.net", "Dear ".$student->fname.",\n\nPlease deposit ".$amount." to our bank account:\nBank:AGRIBANK\nAccount Name:Jannet Iucu\nAccount Number:1421205079360\n\nWe will activate your deposit balance right after we received your payment.\n\nThank you. \n\nEnglishHours.net");
        //Send email to admin
        MailController::sendMail("info@englishhours.net", "Student Deposit Submission", "Dear EnglishHours Admin,\n\n". $student->fname." ".$student->lname." (".Auth::user()->email.") has submitted to deposit ".$amount."\n\nPlease activate deposit once received.");

        return back()->with("success", $amount);
      }
      return back()->with("error", 1);
    }

    public function admin(){
      // Admin
      if (Auth::user()->is_admin == 1) {
        $deposits = Deposit::select("deposits.*","users.email","students.fname","students.lname")->leftJoin("users","users.id","deposits.user_id")->leftJoin("students","students.user_id","deposits.user_id")->where("status",0)->orWhere("status",1)->orderBy("id", "desc")->get();
        return view('admin.deposit', compact('deposits'));
      }
      return redirect('');
    }

    public function update(Request $request, $id) {
      if (Auth::user()->is_admin == 1) {
        $deposit = Deposit::where('id',$id)->first();
        // Empty deposit
        if (empty($deposit)) {
          return back()->with("error", 1);
        }
        $deposit->activate_by = Auth::user()->id;
        $deposit->status = 1;
        $deposit->modify_date = Carbon::now();
        $deposit->save();

        //Update balance
        $user_id = $deposit->user_id;
        $amount = $deposit->amount;
        $balance = Balance::where('user_id',$user_id)->first();
        if ($balance == null) {
          //Create student balance if not existing
          $insertData = array(
            'user_id' => $user_id,
            'amount' => $amount,
            'create_date' => Carbon::now()
          );
          Balance::insert($insertData);
        }
        else {
          $balance->amount += $amount;
          $balance->modify_date = Carbon::now();
          $balance->save();
        }

        $student = Student::select("students.*","users.email")->leftJoin("users","users.id","students.user_id")->where("user_id", $user_id)->first();
        //Send email to student
        MailController::sendMail($student->email, "EnglishHours Deposit Activated", "Dear ".$student->fname.",\n\nWe have activated ".$amount." to your account balance in EnglishHours.net. You can now use your balance to purchase EnglishHours.net lessons.\n\nThank you.\n\nEnglishHours.net");
        //Send email to admin
        MailController::sendMail("info@englishhours.net", "Deposit Activated", "Dear EnglishHours Admin,\n\nYou have just activated ".$student->fname." ".$student->lname." (".$student->email.") deposit amounting to: ".$amount);
        return back()->with("success", 1);
      }

      return back()->with("error", 1);
    }
}
