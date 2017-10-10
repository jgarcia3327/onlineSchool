@extends('layouts.app')

@section('title', "Create Schedule - English Hours")

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <!-- Calendar for selecting a day -->
            <div class="panel panel-default">
                <div class="panel-heading">
                  Select Day
                </div>
                <div class="panel-body">
                  <p><strong>*Chọn một ngày bạn muốn để hiển thị lịch dạy của giáo viên</strong></p>
                  <div class="col-md-8 col-md-offset-2">
                    <div id="datepicker"></div>
                  </div>
                </div>
            </div>

            @if ( Auth::check() && $auth->is_student == 1)
            <div class="panel panel-default">
              <div class="panel-heading">
                <strong>Số tiền trong tài khoản: {{ $credits }}</strong> | [ <a href="{{ url('/scheduleCredit') }}">Tài khoản của tôi</a> ]
                <span class="text-error">
                  *You can select several days to be added-up to your selected schedules.
                  <br/>*Selected schedule will be partially saved when moving/selecting other day for a batch submission of schedules.
                </span>
                @if (session('success') == -1)
                <span class="help-block">
                    <!-- <strong class="text-danger">You don't have enough credits on your selected schedules.</strong><br/> -->
                    <!-- <strong class="text-danger">Please select number of schedules within your credits.</strong> -->
                    <strong class="text-danger">Bạn không đủ số bài học trong tài khoản để thực hiện lịch học này.</strong><br/>
                    <strong class="text-danger">Vui lòng chọn số bài học vừa đủ với tài khoản hiện có của bạn.</strong>
                </span>
                @endif
              </div>
              <div class="panel-body">
                <div class="">
                  Selected Schedule: <strong class="selected-sched-count">0</strong> [ <a href="javascript:showSched()" class="view-hide">View</a> ]
                </div>
                <div id="selected-sched" style="display: none;">
                <i class="text-danger none-selected">Không có bài học nào được chọn</i>
                </div>
                <span class="span-row pull-right"><button onclick="$('form#create-schedule').submit()" type="submit" class="btn btn-primary" id="submit-selected" disabled>Chọn</button></span>
              </div>
            </div>
            @else
            <div class="panel panel-default">
              <div class="panel-body">
                Để chọn lịch học, bạn hãy đăng nhập tại đây <a class="btn btn-success btn-lg" href="{{ route('login') }}">ĐĂNG NHẬP</a>
              </div>
            </div>
            @endif

            <p class="loader text-center"><img src="{{ asset('images/ajax-loader.gif') }}"/></p>

            <form id="create-schedule" action="#" method="POST">
              {{ method_field('PUT') }}
              {{ csrf_field() }}
            <div id="available-time"></div>

          </form>

        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript" src="{{ asset('js/schedule-teacher.js') }}"></script>
@endsection
