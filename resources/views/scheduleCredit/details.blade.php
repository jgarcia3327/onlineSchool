@extends('layouts.app')

@section('title', "My Credit Details")

@section('content')
<?php $totalCredit = $credits == null? 0 : count($credits); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Total Purchased Credits: <i class="text-default">{{$totalCredit}}</i>
                </div>

                <div class="panel-body">
                  @if ($credits == null)
                  <i class="text-danger">No Credits Found</i>
                  @else
                    <ul class="list-group">
                    <?php $counter = 0; ?>
                    @foreach ($credits AS $v)
                      <?php
                        $date_time = strtotime($v->date_time);
                        $date_created = strtotime($v->create_date);
                        $date_time_active = ($v->consume_days * (24*60*60)); //Convert days to seconds
                        $expired_time = $date_created + $date_time_active;
                        $counter++;
                      ?>
                      @if ( $v->active == 0 )
                        <li class="list-group-item">{{$counter}} ). <i class="text-error-inline">Expired last {{date("F d, Y",$expired_time)}}</i></li>
                      @elseif ($v->schedule_id == null || empty($v->schedule_id))
                        <li class="list-group-item">{{$counter}} ). <i class="text-success">Open - will expire {{date("F d, Y",$expired_time)}}</i></li>
                      @else
                        <li class="list-group-item">
                          <?php $status = $date_time < strtotime($common->getCarbonNow())? "<i class='text-success'>(Done)</i>" : "<i class='text-danger'>(Incoming)</i>"; ?>
                          {{$counter}} ). <strong>{!! $status !!} Lesson Schedule:</strong> <a href="{{ url('/schedule/my_schedule/'.date('Y-m-d', $date_time)) }}">{{$common->getFormattedDateTimeRange($v->date_time)}}</a>
                          <br/><strong>Teacher:</strong> {{$v->tfname}} {{$v->tlname}} [ <a href="{{url('/teacherProfile/'.$v->tuser_id)}}">Teacher Profile</a> ]
                          <!-- id:{{$v->id}} | user-id:{{$v->user_id}} | schedule-id:{{$v->schedule_id}} | consume-days:{{$v->consume_days}} -->
                        </li>
                      @endif
                    @endforeach
                    </ul>
                  @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
