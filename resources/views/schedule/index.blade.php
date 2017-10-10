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
                [ <a href="{{url('/schedule/create')}}">Create Schedule</a> ]
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

          <p class="loader text-center"><img src="{{ asset('images/ajax-loader.gif') }}"/></p>

          <div id="lessons-list">

          </div>

        </div>
    </div>
</div>
@endsection

@section('javascript')
<!-- <script type="text/javascript" src="{{ asset('js/display-teacher.js') }}"></script> -->
<script type="text/javascript" src="{{ asset('js/my_schedule.js') }}"></script>
@endsection
