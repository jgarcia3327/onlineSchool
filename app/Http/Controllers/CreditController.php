<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Credit;
use App\Models\Buycredit;
use Auth;
use Carbon\Carbon;
use App\Models\Schedule;
use App\Models\Balance;
use App\Models\Student;
use App\Http\Controllers\MailController;

class CreditController extends Controller
{

    public static function getCreditLessonsValidity() {
      return array(
        10 => 30, // in days
        20 => 60, // in days
        30 => 90, // in days
        40 => 120 // in days
      );
    }

    public static function getCreditLessons() {
      return array(
        10 => 860000,
        20 => 1660000,
        30 => 2350000,
        40 => 2990000
      );
    }

    public static function getCreditCount($user_id){

      //Redeem teacher missed session
      $conditionSched = [
        ["active","=",1],
        ["student_user_id","=",$user_id],
        ["called","=",null],
        ["date_time","<",Carbon::now()->subMinutes(15)],
        ["date_time",">=",Carbon::now()->subMonth()]
      ];
      $schedules = Schedule::where($conditionSched)->get();
      if (count($schedules) > 0) {
        $updateCredits = array();
        foreach($schedules AS $v) {
          $v->active = 0;
          $updateCredits[] = $v->id;
          $v->save();
        }
        if(count($updateCredits) > 0){
          Credit::whereIn("schedule_id", $updateCredits)->update(["schedule_id" => null]);
        }
      }

      //Check credit lifetime
      $credits = Credit::where([["user_id","=",$user_id], ["active","=",1], ["schedule_id","=",null]])->get();
      $count = 0;
      foreach($credits AS $v) {
        if (($v->consume_days*86400) + strtotime($v->create_date) <= strtotime(Carbon::now())) {
          $v->active = 0;
          $v->modify_date = Carbon::now();
          $v->save();
        }
        else{
          $count++;
        }
      }
      return $count;
    }

    public static function updateCreditSchedule($user_id, $schedule_id) {
      $creditCond = [
        ["user_id","=",$user_id],
        ["active","=",1],
        ["schedule_id","=",null]
      ];
      $credit = Credit::where($creditCond)->first();

      if ($credit != null && !empty($credit) && !empty($schedule_id)) {
        $credit->update(['schedule_id' => $schedule_id]);
      }

    }

    public function index() {

      // Student and admin only
      if (Auth::user()->is_student == 1 || Auth::user()->is_admin == 1) {
        $pendingCond = [
          ["user_id","=",Auth::user()->id],
          ["status","=", 0]
        ];
        $pending = Buycredit::where($pendingCond)->orderBy("id", "desc")->get();
        $balance = Balance::where('user_id', Auth::user()->id)->first();
        $balanceAmount = $balance == null? 0 : $balance->amount;

        $credits = array(
          CreditController::getCreditCount(Auth::user()->id),
          $pending,
          $balanceAmount
        );
        return view('scheduleCredit.index', compact('credits'));
      }

      return redirect('');
    }

    public function admin(){
      // Admin
      if (Auth::user()->is_admin == 1) {
        $buyCredits = Buycredit::select("buycredits.*","users.email","students.fname","students.lname")->leftJoin("users","users.id","buycredits.user_id")->leftJoin("students","students.user_id","buycredits.user_id")->where("status",0)->orWhere("status",1)->orderBy("id", "desc")->get();
        return view('admin.credit', compact('buyCredits'));
      }
      return redirect('');
    }

    public function store(Request $request) {

      if(Auth::user()->is_student == 1) {
        $creditLessons = CreditController::getCreditLessons();
        $balance = Balance::where("user_id", Auth::user()->id)->first();
        $quantity = $request->quantity;
        if (!empty($balance) && array_key_exists($quantity, $creditLessons) && $balance->amount >= $creditLessons[$quantity]) {
          // Record buy credit lessons
          $insertData = array(
            "user_id" => Auth::user()->id,
            "quantity" => $quantity,
            "charged" => 1,
            "create_date" => Carbon::now()
          );
          Buycredit::insert($insertData);

          // Charge balance
          $balance->amount -= $creditLessons[$quantity];
          $balance->save();

          // Activate bought credit lessons
          $consume = CreditController::getCreditLessonsValidity()[$quantity];
          $dataset = [];
          $limit = $quantity;
          for ($i=0; $i < $limit; $i++) {
            $dataset[] = [
              'user_id' => Auth::user()->id,
              'consume_days' => $consume,
              'create_date' => Carbon::now()
            ];
          }
          Credit::insert($dataset);

          $student = Student::where("user_id",Auth::user()->id)->first();
          //Send email to student
          MailController::sendMail(Auth::user()->email, "EnglishHours.net Lessons Purshase", "Dear ".$student->fname.",\n\nYou have successfully purchased ".$quantity." lesson credits.\n\nThank you. \n\nEnglishHours.net");
          //Send email to admin
          MailController::sendMail("info@englishhours.net", $quantity." Lessons purchased from ".$student->fname, "Dear EnglishHours Admin,\n\n". $student->fname." ".$student->lname." (".Auth::user()->email.") has successfully purchased ".$quantity." lesson credits, amounting to ".$amount);

          return back()->with("success", $quantity); //TODO change price
        }

        return back()->with("error", 1);
      }

      return back()->with("error", 1);

    }

    //Deprecated
    public function update(Request $request, $id) {
      /*
      if (Auth::user()->is_admin == 1) {
        $credit = Buycredit::where('id',$id)->first();
        // Empty credit
        if (empty($credit)) {
          return back()->with("success", -1);
        }
        $credit->activate_by = Auth::user()->id;
        $credit->status = 1;
        $credit->modify_date = Carbon::now();
        $credit->save();

        //Assign credits
        $studentCredit = new Credit;
        switch($credit->quantity) {
          case 10 : $consume = 30; // in days
          break;
          case 20 : $consume = 60; // in days
          break;
          case 30 : $consume = 90; // in days
          break;
          default : $consume = 120; // in days
        }
        $dataset = [];
        $limit = $credit->quantity;
        for ($i=0; $i < $limit; $i++) {
          $dataset[] = [
            'user_id' => $credit->user_id,
            'consume_days' => $consume,
            'create_date' => Carbon::now()
          ];
        }
        $studentCredit->insert($dataset);

        return back()->with("success", 1);
      }

      return back()->with("success", -1);
      */
    }
}
