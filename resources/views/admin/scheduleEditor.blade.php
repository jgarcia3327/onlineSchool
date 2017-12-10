@extends('layouts.app')

@section('title', "Schedule Editor - English Hours")

@section('style')
<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
@endsection

@section('content')
<?php
  $futureSchedules = $schedules[0];
  $pastSchedules = $schedules[1];
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">

          <ul class="nav nav-tabs">
            <li role="presentation" class="active future"><a href="javascript:viewFutureSched();">Future Schedules</a></li>
            <li role="presentation" class="past"><a href="javascript:viewPastSched();">Past Schedules</a></li>
          </ul>

            <div class="panel panel-default" id="future-schedule">
                <div class="panel-heading">List of Future Schedules</div>
                <div class="panel-body">
                    <table id="future" class="display" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Lesson Schedule</th>
                          <th>Teacher</th>
                          <th>Student</th>
                          <th>ACTION</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($futureSchedules AS $v)
                        <tr>
                          <?php $hasStudent = ($v->sfname == null || empty($v->sfname))? false : true; ?>
                          <td>{!! $common->getFormattedDateTimeRangeMilitary($v->date_time) !!}</td>
                          <td>{{ucfirst($v->tfname." ".$v->tlname)}} (<a href="skype:live:{{$v->tskype}}?call">{{$v->tskype}}</a>)</td>
                          @if ($hasStudent)
                            <td>{{ucfirst($v->sfname." ".$v->slname)}} (<a href="skype:live:{{$v->sskype}}?call">{{$v->sskype}}</a>)</td>
                            <td class="cancel-sched">
                              [ <a class="cancel" href="javascript:void(0)">Cancel</a> ]
                              <form class="form-cancel" action="{{url('')}}" method="post" style="display:none;">
                                <input type="hidden" name="shed_id" value="{{$v->id}}">
                                <button class="btn btn-danger" type="submit" name="button">Confirm</button>
                                <a class="close-cancel" href="javascript:void(0)">Close</a>
                              </form>
                            </td>
                          @else
                            <td><i>Open</i></td>
                            <td class="cancel-sched">
                              [ <a class="cancel" href="javascript:void(0)">Delete</a> ]
                              <form class="form-cancel" action="" method="post" style="display:none;">
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}
                                <input type="hidden" name="delete_sched_id" value="{{$v->id}}">
                                <button class="btn btn-danger" type="submit" name="button">Confirm</button>
                                <a class="close-cancel" href="javascript:void(0)">Close</a>
                              </form>
                              [ <a class="add" href="javascript:void(0)">Assign Student</a> ]
                              <form class="form-add" action="" method="post" style="display:none;">
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}
                                <input type="hidden" name="assign_sched_id" value="{{$v->id}}">
                                <!-- Student with credits -->
                                <select name="user_id">
                                  <option value=""></option>
                                  @foreach($common->getActiveStudents() AS $v)
                                    @if ($common->getStudentCreditCount($v->user_id) > 0)
                                      <option value="{{$v->user_id}}">{{$v->fname}} {{$v->lname}} ({{$v->email}})</option>
                                    @endif
                                  @endforeach
                                </select>
                                <button class="btn btn-primary" type="submit" name="button">Assign</button>
                                <a class="close-add" href="javascript:void(0)">Close</a>
                              </form>
                            </td>
                          @endif
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
            </div>

            <div class="panel panel-default" id="past-schedule" style="display: none;">
                <div class="panel-heading">List of Past Schedules</div>
                <div class="panel-body">
                    <table id="past" class="display" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Lesson Schedule</th>
                          <th>Teacher</th>
                          <th>Student</th>
                          <th>Report/Status</th>
                          <th>ACTION</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($pastSchedules AS $v)
                        <?php
                          $hasStudent = ($v->sfname == null || empty($v->sfname))? false : true;
                          //Display only schedules with student
                          if (!$hasStudent) continue;
                        ?>
                        <tr>
                          <td>{!! $common->getFormattedDateTimeRangeMilitary($v->date_time) !!}</td>
                          <td>{{ucfirst($v->tfname." ".$v->tlname)}} (<a href="skype:live:{{$v->tskype}}?call">{{$v->tskype}}</a>)</td>
                          @if ($hasStudent)
                            <td>{{ucfirst($v->sfname." ".$v->slname)}} (<a href="skype:live:{{$v->sskype}}?call">{{$v->sskype}}</a>)</td>
                            @if ($v->called == null)
                              <td><i class="text-error-inline">Missed Session</i></td>
                            @else
                              <td>
                                <strong>Course:</strong> {{ $v->memo }}<br/>
                                <strong>Book Title:</strong> {{ $v->memo_book }}<br/>
                                <strong>Next Page:</strong> {{ $v->memo_next_page }}<br/>
                                <strong>Teacher's Comment:</strong> {{ $v->memo_comment }}
                              </td>
                            @endif
                          @else
                            <td><i class="text-danger">Open</i></td>
                            <td><i class="text-danger">N/A</i></td>
                          @endif
                          <td class="cancel-sched">
                            @if ($hasStudent && $v->called != null)
                            [<a class="cancel" href="javascript:void(0)">Cancel/Unsuccessful</a>]
                            <form class="form-cancel" action="" method="post" style="display:none;">
                              {{ method_field('PUT') }}
                              {{ csrf_field() }}
                              <input type="hidden" name="cancel_sched_id" value="{{$v->id}}">
                              <button class="btn btn-danger" type="submit" name="button">Confirm</button>
                              <a class="close-cancel" href="javascript:void(0)">Close</a>
                            </form>
                            @endif
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/schedule-list.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    // Cancel / Delete
    $(".cancel-sched a.cancel").click(function() {
      $(this).siblings("form.form-cancel").css({"display":"block"});
    });
    $(".cancel-sched a.close-cancel").click(function() {
      $(this).parents("form.form-cancel").css({"display":"none"});
    });
    // Add
    $(".cancel-sched a.add").click(function() {
      $(this).siblings("form.form-add").css({"display":"block"});
    });
    $(".cancel-sched a.close-add").click(function() {
      $(this).parents("form.form-add").css({"display":"none"});
    });

    $("form").submit(function(event){
      var cancel_sched_id = $(this).find("input[name='cancel_sched_id']").val();
      var delete_sched_id = $(this).find("input[name='delete_sched_id']").val();
      var assign_sched_id = $(this).find("input[name='assign_sched_id']").val();

      var token = $(this).find("input[name='_token']").val();
      var sched_id = null;
      var action = null;
      var student_id = null;

      // Cancel schedule
      if(typeof cancel_sched_id != 'undefined' && cancel_sched_id != "") {
        sched_id = cancel_sched_id;
        action = "cancel";
      }
      else if(typeof delete_sched_id != 'undefined' && delete_sched_id != "") {
        sched_id = delete_sched_id;
        action = "delete";
      }
      else if(typeof assign_sched_id != 'undefined' && assign_sched_id != "") {
        sched_id = assign_sched_id;
        action = "assign";
        student_id = $(this).find("select[name='user_id']").val();
      }

      //AJAX
      if (sched_id != null && action != null) {
        $.ajax({
          url : "/adminScheduleEditorUpdateAjax/"+sched_id,
          dataType : "json",
          method : "POST",
          data : {"_method":"PUT", "_token":token,"action":action,"student_id":student_id}
        })
        .done(
          function(result) {
            console.log(result);
        });
        console.log("Cancel Schedule...");
        $(this).siblings("td.cancel-sched a.cancel").css({"display":"none"});
        $(this).siblings("td.cancel-sched a.add").css({"display":"none"});
        $(this).closest("td.cancel-sched form").css({"display":"none"});
        var past_action = "CANCELLED";
        if (action == "delete") past_action = "DELETED";
        else if(action == "assign") past_action = "ASSIGNED";
        $(this).closest("td.cancel-sched").append(past_action);
      }
      event.preventDefault();
    });
  });
</script>
@endsection
