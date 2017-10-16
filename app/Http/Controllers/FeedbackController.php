<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Auth;
use Carbon\Carbon;

class FeedbackController extends Controller
{

  public static function getUserFeedback($user_id) {
    return Feedback::where([['active','=',1],['user_id','=',$user_id]])->get();
  }

  static function getAllFeedback() {
    if(Auth::user()->is_admin === 1) {
      return Feedback::where('active',1)->orderBy('id','desc')->get(); //paginate TODO
    }
    return null;
  }

  public static function admin() {
    $feedback = FeedbackController::getAllFeedback();
    return view('admin.feedback', compact('feedback'));
  }

  public static function update(Request $request, $id) {
    if(Auth::user()->is_admin === 1) {
      if($request->has('reply')){
        $dataSet = array(
          'reply' => $request->reply,
          'reply_by' => Auth::user()->id
        );
        $feedback =  Feedback::where('id', $id)->first();
        $feedback->update($dataSet);
        return back()->with('success', "You have successfully replied to feedback.");
      }
    }
    return back()->with('error', "You don't have the permission to post feedback reply.");
  }

  public static function ajaxFeaturedUpdate($id) {
    if(Auth::user()->is_admin === 1) {
      $feedback =  Feedback::where('id', $id)->first();
      $feedback->featured = $feedback->featured == 0? 1 : 0;
      $feedback->save();
    }
  }

  public function store(Request $request){

    if (Auth::check()) {
      $dataSet = array(
        'user_id' => Auth::user()->id,
        'remark' => $request->remark,
        'create_date' => Carbon::now()
      );
      Feedback::insert($dataSet);
      return back()->with("successFeedback", "Thank you for your feedback, we will get back to you the soonest.");
    }

    return back()->with("errorFeedback", "You don't have permission to post feedback.");
  }
}
