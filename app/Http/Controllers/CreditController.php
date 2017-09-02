<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Credit;
use App\Models\Buycredit;
use Auth;
use Carbon\Carbon;
use App\Models\Schedule;

class CreditController extends Controller
{
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

        $credits = array(
          CreditController::getCreditCount(Auth::user()->id),
          $pending
        );
        return view('scheduleCredit.index', compact('credits'));
      }

      return redirect('');
    }

    public function admin(){
      // Admin
      if (Auth::user()->is_admin == 1) {
        $buyCredits = Buycredit::select("buycredits.*","users.email")->leftJoin("users","users.id","buycredits.user_id")->where("status",0)->orWhere("status",1)->orderBy("id", "desc")->get();
        return view('admin.credit', compact('buyCredits'));
      }
      return redirect('');
    }

    public function store(Request $request) {

      $acceptedQuantity = array(10, 15, 20);

      if (in_array($request->quantity, $acceptedQuantity)) {
        $insertData = array(
          "user_id" => Auth::user()->id,
          "quantity" => $request->quantity,
          "create_date" => Carbon::now()
        );
        Buycredit::insert($insertData);
        return back()->with("success", $request->quantity*2); //TODO change price
      }

      return back()->with("success", 0);

    }

    public function update(Request $request, $id) {

      if (Auth::user()->is_admin == 1) {
        $credit = Buycredit::findOrFail($id)->first();
        $credit->activate_by = Auth::user()->id;
        $credit->status = 1;
        $credit->modify_date = Carbon::now();
        $credit->save();

        //Assign credits
        $studentCredit = new Credit;
        switch($credit->quantity) {
          case 10 : $consume = 14; // in days
          break;
          case 15 : $consume = 21; // in days
          break;
          default : $consume = 30; // in days
        }
        $dataset = [];
        $limit = $credit->quantity == 20? (20+2) : $credit->quantity;
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

    }
}
