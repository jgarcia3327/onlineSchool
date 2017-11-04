@extends('layouts.app')

@section('title', "My Lessons - English Hours")

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
            <li role="presentation" class="active future"><a href="javascript:viewFutureSched();">My Future Lessons</a></li>
            <li role="presentation" class="past"><a href="javascript:viewPastSched();">My Past Lessons</a></li>
          </ul>

            <div class="panel panel-default" id="future-schedule">
                <!-- <div class="panel-heading">My List of Future Schedules</div> -->
                <div class="panel-body">
                    <table id="future" class="display" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <!-- <th>Lesson Schedule</th> -->
                          <th>Ngày/Giờ</th>
                          <th>Action</th>
                          <!-- <th>Teacher</th> -->
                          <th>Giáo viên</th>
                          <th>Skype ID</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($futureSchedules AS $v)
                        <tr>
                          <?php $dateRangePieces = explode("|", $common->getFormattedDateTimeRangeMilitary($v->date_time)); ?>
                          <td>{!! $dateRangePieces[0] !!}<a href="{{url('schedule/my_schedule/'.date('Y-m-d', strtotime($v->date_time)))}}">{!! $dateRangePieces[1] !!}</a> | {!! $dateRangePieces[2] !!}</td>
                          <td>
                            <!-- Cancel schedule -->
                            @if ( (strtotime($v->date_time)-7200) >= strtotime(date("Y-m-d H:i:s")) )
                            [ <a class="text-danger" role="button" data-toggle="collapse" href="#collapse{{$v->id}}" aria-expanded="true" aria-controls="collapse{{$v->id}}">Hủy bài học<!--Cancel--></a> ]
                            <div id="collapse{{$v->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$v->id}}">
                              <form class="call-form" action="{{ url('/schedule/'.$v->id) }}" method="POST">
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}
                                <input type="hidden" name="cancel" value="1">
                                <!-- <input type="submit" value="Confirm"/> -->
                                <input type="submit" value="Hủy bài học - Confirm"/>
                              </form>
                              [<a role="button" data-toggle="collapse" href="#collapse{{$v->id}}" aria-expanded="true" aria-controls="collapse{{$v->id}}">Close</a>]
                            @endif
                          </td>
                          <td>{{ucfirst($v->tfname." ".$v->tlname)}} [ <a href="{{ url('teacherProfile/'.$v->tuser_id) }}">Profile</a> ]</td>
                          <td><a href="skype:live:{{$v->tskype}}?call">{{$v->tskype}}</a></td>
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
                          <!-- <th>Lesson Schedule</th> -->
                          <th>Ngày/Giờ</th>
                          <!-- <th>Teacher</th> -->
                          <th>Giáo viên</th>
                          <th>Skype ID</th>
                          <!-- <th>Report</th> -->
                          <th>Ngày/Giờ</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($pastSchedules AS $v)
                        <tr>
                          <?php $dateRangePieces = explode("|", $common->getFormattedDateTimeRangeMilitary($v->date_time)); ?>
                          <td>{!! $dateRangePieces[0] !!}<a href="{{url('schedule/my_schedule/'.date('Y-m-d', strtotime($v->date_time)))}}">{!! $dateRangePieces[1] !!}</a> | {!! $dateRangePieces[2] !!}</td>
                          <td>{{ucfirst($v->tfname." ".$v->tlname)}} [ <a href="{{ url('teacherProfile/'.$v->tuser_id) }}">Profile</a> ]</td>
                          <td><a href="skype:live:{{$v->tskype}}?call">{{$v->tskype}}</a></td>
                          <td>
                            @if ($v->called == 1)
                            <p style="margin:0"><strong>Tên khóa học:</strong> {{ $v->memo }}</p>
                            <p style="margin:0"><strong>Tên sách:</strong> {{ $v->memo_book }}</p>
                            <p style="margin:0"><strong>Trang tiếp theo:</strong> {{ $v->memo_next_page }}</p>
                            <p style="margin:0"><strong>Nhận xét của giáo viên:</strong> {{ $v->memo_comment }}</p>
                            @else
                            <i class="text-danger">Missed Session</i>
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
</div>
@endsection

@section('javascript')
<script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/schedule-list.js') }}"></script>
@endsection
