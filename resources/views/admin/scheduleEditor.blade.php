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
                              <form class="form-cancel" action="{{url('')}}" method="post" style="display:none;">
                                <input type="hidden" name="shed_id" value="{{$v->id}}">
                                <button class="btn btn-danger" type="submit" name="button">Confirm</button>
                                <a class="close-cancel" href="javascript:void(0)">Close</a>
                              </form>
                              [ <a class="add" href="javascript:void(0)">Assign Student</a> ]
                              <form class="form-add" action="{{url('')}}" method="post" style="display:none;">
                                <input type="hidden" name="shed_id" value="{{$v->id}}">
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
                        <tr>
                          <?php $hasStudent = ($v->sfname == null || empty($v->sfname))? false : true; ?>
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
                            [ <a class="cancel" href="javascript:void(0)">Cancel</a> ]
                            <form class="form-cancel" action="{{url('')}}" method="post" style="display:none;">
                              <input type="hidden" name="shed_id" value="{{$v->id}}">
                              <button class="btn btn-danger" type="submit" name="button">Confirm</button>
                              <a class="close-cancel" href="javascript:void(0)">Close</a>
                            </form>
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
</script>
@endsection
