@extends('layouts.app')

@section('title')
  Lesson Scheduler
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

          <!-- Calendar display -->
          <div class="panel panel-default">
              <div class="panel-heading">Choose a day or week to display your lessons
                @if($auth->is_student === 0)
                [ <a href="{{url('/schedule/create')}}">Create Schedule</a> ] [ <a href="{{url('/teacherScheduleList')}}">My List of Schedules</a> ]
                @endif
                @if (session('success') === -1)
                <span class="help-block">
                    <strong class="text-danger">Schedule cancel IS NOT SUCCESSFUL. <br/>-Schedule selected has student reserved on it.</strong>
                </span>
                @elseif (!empty(session('success')))
                <span class="help-block">
                    <strong class="text-danger">Schedule deleted successfully. <br/>-{{ $common->getFormattedDateTimeRange(session('success')) }} </strong>
                </span>
                @endif
              </div>
              <div class="panel-body">
                <div class="col-md-8 col-md-offset-2">
                  <div id="week-datepicker"></div>
                </div>
              </div>
          </div>

          <div id="lessons-list">
            <!-- LIST OF SCHEDULES -->

            <!-- Future lessons -->
            <div class="panel panel-default" id="my-schedule">
                <div class="panel-heading">
                  <h3 class="text-center">
                  @if($schedules[2] != null)
                  <strong>{{ $common->getFormattedDate($schedules[2]) }}</strong>
                  @else
                  <strong>{{ $common->getFormattedDate($schedules[3][0]) }}</strong> - to - <strong>{{ $common->getFormattedDate($schedules[3][1]) }}</strong>
                  @endif
                  </h3>
                  Future Lessons</div>
                <div class="panel-body">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Date / Time</th>
                          <th>Student</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if($schedules[0] != null)
                        @foreach($schedules[0] AS $v)
                        <tr>
                          <td>{{ $common->getFormattedDateTimeRange($v->date_time) }}</td>
                          <td>
                            @if($v->student_user_id != null && $schedules[4][$v->student_user_id] != null)
                              {{ $schedules[4][$v->student_user_id]->fname }} {{ $schedules[4][$v->student_user_id]->lname }} [ <a href="{{url('/profile/'.$v->student_user_id)}}">Profile</a> ]
                              <?php
                                $schedTime =  strtotime($v->date_time);
                                $curTime = strtotime(date("Y-m-d H:i:s"));
                                $expireDateTime = $schedTime + 600; //10 minutes before called button elapse
                                $startDateTime = $schedTime - 300; //5 minutes earlier to show call button
                              ?>
                              @if( $curTime >= $startDateTime && $curTime <= $expireDateTime )
                                @if($v->called == null)
                                  <form style="display:none;" id="token-{{$v->id}}">
                                    {{ csrf_field() }}
                                  </form>
                                  <button class="btn btn-primary call-sched btn-sched-id-{{$v->id}}" data-sched_id="{{$v->id}}">Call</button>
                                  <span class="btn-skype-{{$v->id}}" style="display:none;">[ <a href="skype:live:{{ $schedules[4][$v->student_user_id]->skype }}?call">Skype Call</a> ]</span>
                                @else
                                  [ <a href="skype:live:{{ $schedules[4][$v->student_user_id]->skype }}?call">Skype Call</a> ]
                                @endif
                              @elseif ( $curTime >= $schedTime - 86400)
                                <!-- Disable cancellation under 24 hours -->
                              @else
                                [ <a class="text-danger" role="button" data-toggle="collapse" href="#collapse{{$v->id}}" aria-expanded="true" aria-controls="collapse{{$v->id}}">Cancel</a> ]
                                <div id="collapse{{$v->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$v->id}}">
                                  <form class="call-form" action="{{ url('/schedule/'.$v->id) }}" method="POST">
                                    {{ method_field('PUT') }}
                                    {{ csrf_field() }}
                                    <input type="hidden" name="cancel" value="1">
                                    <input type="submit" value="Confirm"/>
                                  </form>
                                  [ <a role="button" data-toggle="collapse" href="#collapse{{$v->id}}" aria-expanded="true" aria-controls="collapse{{$v->id}}">Close</a> ]
                                </div>
                              @endif

                            @else
                              <!-- 2hrs = 7200 hrs -->
                              <!-- 24hrs = 86400 hrs -->
                              @if ( strtotime(date("Y-m-d H:i:s")) >= (strtotime($v->date_time) - 7200) )
                                <i class="text-warning">No reservation - closed</i>
                              @elseif ( strtotime(date("Y-m-d H:i:s")) >= (strtotime($v->date_time) - 86400) )
                                Open
                              @else
                                Open <form class="call-form" action="{{ url('/schedule/'.$v->id) }}" method="POST">
                                  {{ method_field('PUT') }}
                                  {{ csrf_field() }}
                                  <input type="hidden" name="cancel" value="1">
                                  <input type="submit" value="Cancel"/>
                                </form>
                              @endif
                            @endif
                          </td>
                        </tr>
                        @endforeach
                        @endif
                      </tbody>
                    </table>
                </div>
            </div>
            <!-- Past Lessons -->
            <div class="panel panel-default">
                <div class="panel-heading">Past Lessons</div>
                <div class="panel-body">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Date / Time</th>
                          <th>Student</th>
                          <th>Memo</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if($schedules[1] != null)
                        @foreach($schedules[1] AS $v)
                        <tr>
                          <td>{{ $common->getFormattedDateTimeRange($v->date_time) }}</td>
                          <td>
                            @if($v->student_user_id != null && $schedules[4][$v->student_user_id] != null)
                              {{ $schedules[4][$v->student_user_id]->fname }} {{ $schedules[4][$v->student_user_id]->lname }}
                            @else
                              Open
                            @endif
                          </td>
                          <td>
                            @if($v->student_user_id != null && $schedules[4][$v->student_user_id] != null)
                              @if($v->memo != null)
                              <!-- <strong>Course:</strong><p style="margin:0">{{ $v->memo }}</p> -->
                              <!-- <strong>Book Title:</strong><p style="margin:0">{{ $v->memo_book }}</p> -->
                              <!-- <strong>Next Page:</strong><p style="margin:0">{{ $v->memo_next_page }}</p> -->
                              <!-- <strong>Teacher's Comment:</strong><p style="margin:0">{{ $v->memo_comment }}</p> -->
                              @endif
                              @if($v->called == 1)
                              <form class="memo" action="{{ url('schedule/'.$v->id) }}" method="POST">
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}
                                <div class="form-group">
                                  <select class="form-control" id="memo" name="memo" required placeholder="Course">
                                    <option value=""></option>
                                    @foreach($common->getCourses() AS $k1 => $v1)
                                    <option value="{{$k1}}" {{$k1 == $v->memo? "selected" : ""}}>{{$v1}}</option>
                                    @endforeach
                                  </select>
                                  <input class="form-control" type="text" id="memo_book" name="memo_book" value="{{ $v->memo_book }}" required placeholder="Book Title">
                                  <input class="form-control" type="text" id="memo_next_page" name="memo_next_page" value="{{ $v->memo_next_page }}" required placeholder="Next Page">
                                  <textarea class="memo_comment" name="memo_comment" required placeholder="Comment" style="width:100%">{{ $v->memo_comment }}</textarea>
                                  @if($v->memo != null)
                                    <input class="form-control btn btn-success" type="submit" value="UPDATE" />
                                  @else
                                    <input class="form-control btn btn-primary" type="submit" value="Submit" />
                                  @endif
                                </div>
                              </form>
                              @else
                              <i class="text-danger">Missed Session</i>
                              @endif
                            @endif
                          </td>
                        </tr>
                        @endforeach
                        @endif
                      </tbody>
                    </table>
                </div>
            </div>

            <!-- END LIST OF SCHEDULES -->
          </div>

        </div>
    </div>
</div>
@endsection

<?php
  $dateActiveArr = $schedules[2] != null? explode("-", $schedules[2]) : explode("-", $schedules[3][0]);
  $dateActiveStr = $dateActiveArr[0].",".($dateActiveArr[1]-1).",".$dateActiveArr[2];
?>

@section('javascript')
<script type="text/javascript" src="{{ asset('js/my_schedule_teacher.js') }}"></script>

<script type="text/javascript">
  $(document).ready(function(){

    // Skype trigger
    $(".call-sched").mouseup(function(){
      var id = $(this).data("sched_id");
      var token = $("form#token-"+id+" input[name='_token']").val();
      console.log(token);
      console.log(id);
      $.ajax({
        url : "/schedule/"+id,
        dataType : "json",
        method : "POST",
        data : {"_method":"PUT", "_token":token,"called":"1"}
      })
      .done(
        function(result) {
          console.log(result);
          console.log(result.id);
          $(".sched-kype-"+result.id).click();
      });
      // Call skype
      $(".btn-sched-id-"+id).css({"display":"none"});
      $(".btn-skype-"+id).css({"display":"block"});
      $(".btn-skype-"+id+" > a")[0].click();
    });

    // Set date selected
    // console.log("{{$dateActiveStr}}");
    //$('#week-datepicker').datepicker("setDate", new Date(2017,9,24) ); //Oct. 24, 2017
    $(document).ready(function(){
      $('#week-datepicker').datepicker("setDate", new Date({{$dateActiveStr}}) );

      // Load week button trigger in #week-datepicer
      $("#week-datepicker .ui-datepicker-week-col").click(function(){
          $(".loader").css({"display":"block"});
          $("#lessons-list").css({"display":"none"});
          var year = $("#week-datepicker .ui-datepicker-year").text();
          var week = $(this).text();
          dateStr = week+"_"+year;
          console.log(dateStr);
          getSavedDateTime(dateStr);
      });
    });

  });
</script>

<script type="text/javascript">
  // Refresh every 5 minutes
  var pathname = $(location).attr('pathname');
  var refreshPage = pathname;
  var refreshInterval = setInterval(function() {
    window.location.href = refreshPage;
  }, 300000); // 5 mins

</script>
@endsection
