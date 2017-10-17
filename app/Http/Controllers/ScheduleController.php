<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\Schedule;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\CreditController;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Credit;
use Carbon\Carbon;

class ScheduleController extends Controller
{

  public static function getAllFutureSchedules() {
    return Schedule::select("schedules.*", "students.fname AS sfname", "students.lname AS slname", "students.skype AS sskype", "teachers.fname AS tfname", "teachers.lname AS tlname", "teachers.skype AS tskype")->leftJoin("students","students.user_id","=","schedules.student_user_id")->leftJoin("teachers","teachers.user_id","=","schedules.teacher_user_id")->where([["date_time",">=",Carbon::now()]])->orderBy("date_time","asc")->get();
  }

  private function isTeacher() {
      return (Auth::user()->is_student == 0);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      if (!$this->isTeacher()) {
        // Student view
        return view('schedule.lesson');
      }
      // Teacher view
      return view('schedule.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      if (!$this->isTeacher())
        return redirect('/home');

      return view('schedule.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      //dd($request->date_time);
      if (!$this->isTeacher()) {
          return redirect('/home');
      }
      $sched = new Schedule;
      $dataSet = [];
      foreach($request->date_time AS $timeSched) {
        // Teacher can register not less than 24 hours of the current time
        // 24 hours = 86400 seconds
        if ( strtotime($timeSched) <= (strtotime(date("Y-m-d H:i:s")) + 86400)) {
          continue;
        }
        $dataSet[] = [
            'teacher_user_id' => Auth::user()->id,
            'date_time' => $timeSched
        ];
      }
      $sched->insert($dataSet);
      return redirect('/schedule');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {

      $schedule = Schedule::where('id',$id)->first();

      // TEACHER CANCEL SCHEDULE
      if ($request->has('cancel') && $this->isTeacher()) {
          if ($schedule->teacher_user_id === Auth::user()->id) {
            // Check if less than 24 hours = 86400 sec
            if (strtotime(date("Y-m-d H:i:s")) >= strtotime($schedule->date_time) - 86400) {
              return back()->with("error",1);
            }

            $teacher = Teacher::where('user_id', Auth::user()->id)->first();

            // Opps, we have student on the sched. We have to restore student credit
            if ($schedule->student_user_id != null) {

              // Restore student credits
              $credit = Credit::where([["user_id","=",$schedule->student_user_id],["schedule_id","=",$schedule->id]])->first();
              $credit->schedule_id = null;
              $credit->save();

              // Student email
              $student = Student::select("students.*","users.email")->leftJoin('users','users.id','=','students.user_id')->where('user_id', $schedule->student_user_id)->first();
              $subject = $schedule->date_time." cancelled by Teacher ".ucfirst($teacher->fname)." ".ucfirst($teacher->lname);
              $body = "Chào ".ucfirst($student->fname).",\n\nBài học của bạn vào lúc ".$schedule->date_time." với giáo viên ".ucfirst($teacher->fname)." ".ucfirst($teacher->lname)." đã được hủy. \n\nEnglishHours.net";
              $email = $student->email;
              //dd($subject.":".$body.":".$email);
              MailController::sendMail($email, $subject, $body);

              // Email Teacher
              $subject = $schedule->date_time." cancelled successfully.";
              $body = "Dear ".ucfirst($teacher->fname).",\n\nYour lesson on ".$schedule->date_time." with ".ucfirst($student->fname)." ".ucfirst($student->lname)." has been cancelled. \n\nEnglishHours.net";
              $email = Auth::user()->email;
              //dd($subject.":".$body.":".$email);
              MailController::sendMail($email, $subject, $body);

              // Delete Sched
              $date = $schedule->date_time;
              $schedule->delete();

              //TODO record teacher cancellations
              return back()->with("success",$date);
            }
            // Ok, we don't have student reserved on the selected sched
            else {

              // Email Teacher
              $subject = $schedule->date_time." cancelled successfully.";
              $body = "Dear ".ucfirst($teacher->fname).",\n\nYour lesson on ".$schedule->date_time." with no reserved student has been cancelled. \n\nEnglishHours.net";
              $email = Auth::user()->email;
              //dd($subject.":".$body.":".$email);
              MailController::sendMail($email, $subject, $body);

              // Delete Sched
              $date = $schedule->date_time;
              $schedule->delete();

              return back()->with("success",$date);
            }

          }
        return back()->with("success",-1);
      }

      // STUDENT CANCEL RESERVATION
      if ($request->has('cancel') && !$this->isTeacher()) {
        // Cannot cancel less than 1 hour = 3600 in seconds
        if ( (strtotime($schedule->date_time)-3600) >= strtotime(date("Y-m-d H:i:s")) ) {
          if ($schedule->student_user_id === Auth::user()->id) {
            $schedule->student_user_id = null;
            $schedule->save();
            // Restore credits //TODO record student cancellations
            $credit = Credit::where([["user_id","=",Auth::user()->id],["schedule_id","=",$schedule->id]])->first();
            $credit->schedule_id = null;
            $credit->save();
            return back()->with("success",$schedule->date_time);
          }
        }
        return back()->with("success",0);
      }

      if (!$this->isTeacher()) {
          return redirect('/schedule');
      }

      // TEACHER ATTEMPT CALL
      if ($request->has('called')) {
          if ( strtotime(date("Y-m-d H:i:s")) <= (strtotime($schedule->date_time)+600) ) {
            $schedule->update($request->all());
          }
          return redirect('/schedule');
      }

      // TEACHER UPDATE MEMO
      $schedule->update($request->all());
      return redirect('/schedule');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      //
  }

  public function index_ajax($date) {

    // STUDENT
    if (!$this->isTeacher()) {
      //Check if it is per week
      $dateRange = null;
      if (strpos($date, "_") !== false) {
        $week = strstr($date,"_",true);
        $year = substr(strstr($date,"_"),1);
        //JS release week number per year in advance of 1 week and we need to -1 to inline with JS
        $week = $week != 0 ? ($week-1) : 1;
        $dates = new CommonController();
        $dateStart = $dates->getStartAndEndDate($week, $year)[0];
        $dateEnd = $dates->getStartAndEndDate($week, $year)[1];
        $condition = [['student_user_id','=',Auth::user()->id],
          ['date_time', '>=', $dateStart." 00:00:00"],
          ['date_time', '<=', $dateEnd." 23:59:59"]
        ];
        $date = null;
        $dateRange = array($dateStart, $dateEnd);
      }
      else {
        $condition = [['student_user_id','=',Auth::user()->id],
          ['date_time', '>=', $date." 00:00:00"],
          ['date_time', '<=', $date." 23:59:59"]
        ];
        //dd($condition);
      }
      $scheds = Schedule::select("schedules.*","teachers.fname","teachers.lname")->leftJoin("teachers","schedules.teacher_user_id","=","teachers.user_id")->where($condition)->orderBy('date_time', 'asc')->get();
      //dd($scheds);
      $futureScheds = $pastScheds = null;
      $teachersArray = array();
      if ($scheds != null && count($scheds) > 0) {
        foreach($scheds AS $sched){
          if ($sched->teacher_user_id != null ) $teachersArray[] = $sched->teacher_user_id;
          if ($sched->date_time >= date("Y-m-d H:i:s")){
            $futureScheds[] = $sched;
          }
          else{
            $pastScheds[] = $sched;
          }
        }
      }

      if($pastScheds != null) {
        $pastScheds = array_reverse($pastScheds);
      }

      $schedules = array($futureScheds, $pastScheds, $date, $dateRange);

      return view('schedule.lesson_ajax', compact('schedules'));
    }

    //TEACHER
    //Check if it is per week
    $dateRange = null;
    if (strpos($date, "_") !== false) {
      $week = strstr($date,"_",true);
      $year = substr(strstr($date,"_"),1);
      //JS release week number per year in advance of 1 week and we need to -1 to inline with JS
      $week = $week != 0 ? ($week-1) : 1;
      $dates = new CommonController();
      $dateStart = $dates->getStartAndEndDate($week, $year)[0];
      $dateEnd = $dates->getStartAndEndDate($week, $year)[1];
      $condition = [['teacher_user_id','=',Auth::user()->id],
        ['date_time', '>=', $dateStart." 00:00:00"],
        ['date_time', '<=', $dateEnd." 23:59:59"]
      ];
      $date = null;
      $dateRange = array($dateStart, $dateEnd);
    }
    else {
      $condition = [['teacher_user_id','=',Auth::user()->id],
        ['date_time', '>=', $date." 00:00:00"],
        ['date_time', '<=', $date." 23:59:59"]
      ];
      //dd($condition);
    }
    $scheds = Schedule::where($condition)->orderBy('date_time', 'asc')->get();
    //dd($scheds);
    $futureScheds = $pastScheds = null;
    $studentsArray = array();
    foreach($scheds AS $sched){
      if ($sched->student_user_id != null ) $studentsArray[] = $sched->student_user_id;
      //add 15 minutes to be moved to past lessons 15 x 60sec = 900
      if( strtotime($sched->date_time) + 900 >= strtotime(date("Y-m-d H:i:s")) ) {
        $futureScheds[] = $sched;
      }
      else{
        $pastScheds[] = $sched;
      }
    }
    $students = array();
    if ($studentsArray != null && count($studentsArray) > 0) {
      $studentsArray = array_unique($studentsArray);
      foreach($studentsArray AS $v) {
        $students[$v] = Student::where(array('user_id'=>$v))->first();
      }
    }

    if($pastScheds != null) {
      $pastScheds = array_reverse($pastScheds);
    }

    $schedules = array($futureScheds, $pastScheds, $date, $dateRange, $students);

    return view('schedule.index_ajax', compact('schedules'));
  }


  public function my_schedule($date) {

    // STUDENT
    if (!$this->isTeacher()) {
      //Check if it is per week
      $dateRange = null;
      if (strpos($date, "_") !== false) {
        $week = strstr($date,"_",true);
        $year = substr(strstr($date,"_"),1);
        //JS release week number per year in advance of 1 week and we need to -1 to inline with JS
        $week = $week != 0 ? ($week-1) : 1;
        $dates = new CommonController();
        $dateStart = $dates->getStartAndEndDate($week, $year)[0];
        $dateEnd = $dates->getStartAndEndDate($week, $year)[1];
        $condition = [['student_user_id','=',Auth::user()->id],
          ['date_time', '>=', $dateStart." 00:00:00"],
          ['date_time', '<=', $dateEnd." 23:59:59"]
        ];
        $date = null;
        $dateRange = array($dateStart, $dateEnd);
      }
      else {
        $condition = [['student_user_id','=',Auth::user()->id],
          ['date_time', '>=', $date." 00:00:00"],
          ['date_time', '<=', $date." 23:59:59"]
        ];
        //dd($condition);
      }
      $scheds = Schedule::select("schedules.*","teachers.fname","teachers.lname")->leftJoin("teachers","schedules.teacher_user_id","=","teachers.user_id")->where($condition)->orderBy('date_time', 'asc')->get();
      //dd($scheds);
      $futureScheds = $pastScheds = null;
      $teachersArray = array();
      if ($scheds != null && count($scheds) > 0) {
        foreach($scheds AS $sched){
          if ($sched->teacher_user_id != null ) $teachersArray[] = $sched->teacher_user_id;
          if ($sched->date_time >= date("Y-m-d H:i:s")){
            $futureScheds[] = $sched;
          }
          else{
            $pastScheds[] = $sched;
          }
        }
      }

      if($pastScheds != null) {
        $pastScheds = array_reverse($pastScheds);
      }

      $schedules = array($futureScheds, $pastScheds, $date, $dateRange);

      return view('schedule.my_lesson', compact('schedules'));
    }

    //TEACHER
    //Check if it is per week
    $dateRange = null;
    if (strpos($date, "_") !== false) {
      $week = strstr($date,"_",true);
      $year = substr(strstr($date,"_"),1);
      //JS release week number per year in advance of 1 week and we need to -1 to inline with JS
      $week = $week != 0 ? ($week-1) : 1;
      $dates = new CommonController();
      $dateStart = $dates->getStartAndEndDate($week, $year)[0];
      $dateEnd = $dates->getStartAndEndDate($week, $year)[1];
      $condition = [['teacher_user_id','=',Auth::user()->id],
        ['date_time', '>=', $dateStart." 00:00:00"],
        ['date_time', '<=', $dateEnd." 23:59:59"]
      ];
      $date = null;
      $dateRange = array($dateStart, $dateEnd);
    }
    else {
      $condition = [['teacher_user_id','=',Auth::user()->id],
        ['date_time', '>=', $date." 00:00:00"],
        ['date_time', '<=', $date." 23:59:59"]
      ];
      //dd($condition);
    }
    $scheds = Schedule::where($condition)->orderBy('date_time', 'asc')->get();
    //dd($scheds);
    $futureScheds = $pastScheds = null;
    $studentsArray = array();
    foreach($scheds AS $sched){
      if ($sched->student_user_id != null ) $studentsArray[] = $sched->student_user_id;
      //add 15 minutes to be moved to past lessons 15 x 60sec = 900
      if( strtotime($sched->date_time) + 900 >= strtotime(date("Y-m-d H:i:s")) ) {
        $futureScheds[] = $sched;
      }
      else{
        $pastScheds[] = $sched;
      }
    }
    $students = array();
    if ($studentsArray != null && count($studentsArray) > 0) {
      $studentsArray = array_unique($studentsArray);
      foreach($studentsArray AS $v) {
        $students[$v] = Student::where(array('user_id'=>$v))->first();
      }
    }

    if($pastScheds != null) {
      $pastScheds = array_reverse($pastScheds);
    }

    $schedules = array($futureScheds, $pastScheds, $date, $dateRange, $students);

    return view('schedule.my_schedule', compact('schedules'));
  }


  public function studentCreateSchedule() {

    if (Auth::user()->is_student == 1) {
      $credits = CreditController::getCreditCount(Auth::user()->id);
      return view('schedule.student_create', compact('credits'));
    }

    return redirect('');

  }

  public function ajax($date) {
    if (!$this->isTeacher()) {
        return null;
    }
    $condition = [['teacher_user_id','=',Auth::user()->id],
      ['date_time', '>=', $date." 00:00:00"],
      ['date_time', '<=', $date." 23:59:59"]];
    $schedules = Schedule::where($condition)->get();
    $scheds = [];
    foreach($schedules AS $schedule ) {
      $scheds[] = substr($schedule->date_time, strpos($schedule->date_time, " ")+1);
    }
    //Time records
    $morning = array(
      "06:00:00"=>"6:00 AM - 6:30 AM",
      "06:30:00"=>"6:30 AM - 7:00 AM",
      "07:00:00"=>"7:00 AM - 7:30 AM",
      "07:30:00"=>"7:30 AM - 8:00 AM",
      "08:00:00"=>"8:00 AM - 8:30 AM",
      "08:30:00"=>"8:30 AM - 9:00 AM",
      "09:00:00"=>"9:00 AM - 9:30 AM",
      "09:30:00"=>"9:30 AM - 10:00 AM",
      "10:00:00"=>"10:00 AM - 10:30 AM",
      "10:30:00"=>"10:30 AM - 11:00 AM",
      "11:00:00"=>"11:00 AM - 11:30 AM",
      "11:30:00"=>"11:30 AM - 12:00 PM"
    );
    $afternoon = array(
      "12:00:00"=>"12:00 PM - 12:30 PM",
      "12:30:00"=>"12:30 PM - 1:00 PM",
      "13:00:00"=>"1:00 PM - 1:30 PM",
      "13:30:00"=>"1:30 PM - 2:00 PM",
      "14:00:00"=>"2:00 PM - 2:30 PM",
      "14:30:00"=>"2:30 PM - 3:00 PM",
      "15:00:00"=>"3:00 PM - 3:30 PM",
      "15:30:00"=>"3:30 PM - 4:00 PM",
      "16:00:00"=>"4:00 PM - 4:30 PM",
      "16:30:00"=>"4:30 PM - 5:00 PM",
      "17:00:00"=>"5:00 PM - 5:30 PM",
      "17:30:00"=>"5:30 PM - 6:00 PM",
      "18:00:00"=>"6:00 PM - 6:30 PM",
      "18:30:00"=>"6:30 PM - 7:00 PM",
      "19:00:00"=>"7:00 PM - 7:30 PM",
      "19:30:00"=>"7:30 PM - 8:00 PM",
      "20:00:00"=>"8:00 PM - 8:30 PM",
      "20:30:00"=>"8:30 PM - 9:00 PM",
      "21:00:00"=>"9:00 PM - 9:30 PM",
      "21:30:00"=>"9:30 PM - 10:00 PM",
      "22:00:00"=>"10:00 PM - 10:30 PM",
      "22:30:00"=>"10:30 PM - 11:00 PM",
      "23:00:00"=>"11:00 PM - 11:30 PM",
      "23:30:00"=>"11:30 PM - 12:00 AM"
    );
    $time = array($morning, $afternoon, $scheds, $date);
    return view('schedule.ajax', compact('time'));
  }

}
