@extends('layouts.app')

@section('title')
  Lesson Scheduler
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

          <!-- Credits -->
          <div class="panel panel-default">
              <div class="panel-heading">Thông tin tài khoản
                @if (Auth::check() && $auth->is_student == 1)
                [ <a href="{{url('/scheduleCredit')}}">Mua thêm bài học</a> ]
                @endif
              </div>

              <div class="panel-body">
                  Số bài học: <strong>{{ $credits }}</strong>
              </div>
          </div>

          <!-- Calendar display -->
          <div class="panel panel-default">
              <div class="panel-heading">Chọn một ngày hoặc một tuần bạn muốn để hiển thị lịch học của bạn
                @if (!empty(session('success')))
                <span class="help-block">
                    <strong class="text-danger">Schedule reservation cancelled successfully. <br/>-{{ $common->getFormattedDateTimeRange(session('success')) }} </strong>
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
<script type="text/javascript" src="{{ asset('js/display-teacher.js') }}"></script>
@endsection
