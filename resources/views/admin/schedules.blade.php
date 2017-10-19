@extends('layouts.app')

@section('title', "List of Schedules - English Hours")

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
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($futureSchedules AS $v)
                        <tr>
                          <?php $hasStudent = ($v->sfname == null || empty($v->sfname))? false : true; ?>
                          <td>{{$common->getFormattedDateTimeRange($v->date_time)}}</td>
                          <td>{{ucfirst($v->tfname." ".$v->tlname)}} (<a href="skype:live:{{$v->tskype}}?call">{{$v->tskype}}</a>)</td>
                          @if ($hasStudent)
                            <td>{{ucfirst($v->sfname." ".$v->slname)}} (<a href="skype:live:{{$v->sskype}}?call">{{$v->sskype}}</a>)</td>
                          @else
                            <td><i>Open</i></td>
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
                          <th>Report</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($pastSchedules AS $v)
                        <tr>
                          <?php $hasStudent = ($v->sfname == null || empty($v->sfname))? false : true; ?>
                          <td>{{$common->getFormattedDateTimeRange($v->date_time)}}</td>
                          <td>{{ucfirst($v->tfname." ".$v->tlname)}} (<a href="skype:live:{{$v->tskype}}?call">{{$v->tskype}}</a>)</td>
                          @if ($hasStudent)
                            <td>{{ucfirst($v->sfname." ".$v->slname)}} (<a href="skype:live:{{$v->sskype}}?call">{{$v->sskype}}</a>)</td>
                          @else
                            <td><i>Open</i></td>
                          @endif
                            <td>Report here...</td>
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
<script type="text/javascript">
  $(document).ready(function() {

    // Data tables
    $('#future').DataTable( {
        "order": [[ 0, "asc" ]]
    } );
    $('#past').DataTable( {
        "order": [[ 0, "asc" ]]
    } );

  });

  function viewFutureSched() {
    $("#past-schedule").css({"display":"none"});
    $("#future-schedule").css({"display":"block"});
    $(".future").addClass("active");
    $(".past").removeClass("active");
  }
  function viewPastSched() {
    $("#future-schedule").css({"display":"none"});
    $("#past-schedule").css({"display":"block"});
    $(".future").removeClass("active");
    $(".past").addClass("active");
  }
</script>
@endsection
