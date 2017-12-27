@extends('layouts.app')

@section('title', "My Schedules - English Hours")

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
            <li role="presentation" class="active future"><a href="javascript:viewFutureSched();">My Future Schedules</a></li>
            <li role="presentation" class="past"><a href="javascript:viewPastSched();">My Past Schedules</a></li>
          </ul>

            <div class="panel panel-default" id="future-schedule">
                <!-- <div class="panel-heading">My List of Future Schedules</div> -->
                <div class="panel-body">
                    <table id="future" class="display" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Lesson Schedule</th>
                          <th>Action (YYYY-MM-DD)</th>
                          <th>Student</th>
                          <th>Skype ID</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($futureSchedules AS $v)
                        <tr>
                          <?php $hasStudent = ($v->sfname == null || empty($v->sfname))? false : true; ?>
                          <?php $dateRangePieces = explode("|", $common->getFormattedDateTimeRangeMilitary($v->date_time)); ?>
                          <td>{!! $dateRangePieces[0] !!}<a href="{{url('schedule/my_schedule/'.date('Y-m-d', strtotime($v->date_time)))}}">{!! $dateRangePieces[1] !!}</a> | {!! $dateRangePieces[2] !!}</td>
                          <td>
                            <a href="{{url('schedule/my_schedule/'.date('Y-m-d', strtotime($v->date_time)).'/#lessons-list')}}">Visit {{date('Y-m-d', strtotime($v->date_time))}} from My Calendar</a>
                          </td>
                          @if ($hasStudent)
                            <td>{{ucfirst($v->sfname." ".$v->slname)}} [ <a href="{{ url('profile/'.$v->suser_id) }}">Profile</a> ]</td>
                            <td><a href="skype:live:{{$v->sskype}}?call">{{$v->sskype}}</a></td>
                          @else
                            <td><i>Open</i></td>
                            <td><i>N/A</i></td>
                          @endif
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
            </div>

            <div class="panel panel-default" id="past-schedule" style="display: none;">
                <!-- <div class="panel-heading">My List of Past Schedules</div> -->
                <div class="panel-body">
                    <table id="past" class="display" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Lesson Schedule</th>
                          <th>Student</th>
                          <th>Skype ID</th>
                          <th>Report</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($pastSchedules AS $v)
                        <tr>
                          <?php $hasStudent = ($v->sfname == null || empty($v->sfname))? false : true; ?>
                          <?php $dateRangePieces = explode("|", $common->getFormattedDateTimeRangeMilitary($v->date_time)); ?>
                          <td>{!! $dateRangePieces[0] !!}<a href="{{url('schedule/my_schedule/'.date('Y-m-d', strtotime($v->date_time)))}}">{!! $dateRangePieces[1] !!}</a> | {!! $dateRangePieces[2] !!}</td>
                          @if ($hasStudent)
                            <td>{{ucfirst($v->sfname." ".$v->slname)}} [ <a href="{{ url('profile/'.$v->suser_id) }}">Profile</a> ]</td>
                            <td><a href="skype:live:{{$v->sskype}}?call">{{$v->sskype}}</a></td>
                            <td>
                              @if ($v->called == 1)
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
                                    <input class="form-control btn btn-primary" type="submit" value="UPDATE" />
                                  @else
                                    <input class="form-control btn btn-primary" type="submit" value="Submit" />
                                  @endif
                                </div>
                              </form>
                              @else
                              <i class="text-danger">Missed Session</i>
                              @endif
                            </td>
                          @else
                            <td><i>Open</i></td>
                            <td><i>N/A</i></td>
                            <td><i>N/A</i></td>
                          @endif
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
@endsection
