@extends('layouts.app')

@section('title', "My Profile - English Hours")

@section('style')
<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
@endsection

@section('content')
<?php
$isStudent = (Auth::user()->is_student == 1)? true : false;
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

          <!-- Credits -->
          <div class="panel panel-default">
              <div class="panel-heading">
                <!-- Schedule Credits -->
                @if (!$isStudent)
                {{$profiles[0]->fname}} {{$profiles[0]->lname}} - Credits
                @else
                Thông tin tài khoản
                  @if (Auth::check() && $profiles[0]->user_id === Auth::user()->id)
                  [ <a href="{{url('/scheduleCredit')}}">
                    <!-- Buy credits -->
                    Mua thêm bài học
                  </a> ]
                  @endif
                @endif
              </div>

              <div class="panel-body">
                  <!-- Credits:  -->
                  @if (!$isStudent)
                  Lesson credits left:
                  @else
                  Số bài học:
                  @endif
                  <strong>{{ $profiles[2] }}</strong>
              </div>
          </div>

          <!-- My profile -->
            <div class="panel panel-default">
                <div class="panel-heading">
                  @if (Auth::check() && $profiles[0]->user_id === Auth::user()->id)
                  <!-- My Profile  -->
                  Thông tin cá nhân
                  [ <a href="{{url('/profile/'.$profiles[0]->id.'/edit')}}">
                    <!-- Edit -->
                    Sửa
                  </a> ]

                  <!-- change-password -->
                  [ <a href="javascript:void(0)" data-toggle="collapse" data-target="#change-password">
                    <!-- Change Password -->
                    Đổi mật khẩu
                  </a> ]
                  @if (session('success') == 1)
                  <span class="help-block">
                      <strong class="text-success">Password changed successfully.</strong>
                  </span>
                  @endif
                  @if ($errors->has('current_password'))
                  <span class="help-block">
                      <strong class="text-danger">Current password did not match.</strong>
                  </span>
                  @endif
                  @if ($errors->has('new_password'))
                  <span class="help-block">
                      <strong class="text-danger">New password error. <br/>Password should have 6 characters mininum. <br/>New password and confirm password should match.</strong>
                  </span>
                  @endif
                  <div id="change-password" class="collapse">
                    <form class="form-horizontal" action="{{ url('/profile/'.$profiles[0]->id) }}" method="post">
                      {{ method_field('PUT') }}
                      {{ csrf_field() }}
                      <div class="form-group">
                          <label for="old-password" class="col-md-4 control-label">
                            <!-- Current Password -->
                            Mật khẩu hiện tại
                          </label>
                          <div class="col-md-6">
                              <input id="old-password" type="password" class="form-control" name="current_password" required>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="password" class="col-md-4 control-label">
                            <!-- New Password -->
                            Mật khẩu mới
                          </label>
                          <div class="col-md-6">
                              <input id="password" type="password" class="form-control" name="new_password" required>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="confirm-password" class="col-md-4 control-label">
                            <!-- Confirm New Password -->
                            Viết lại mật khẩu mới
                          </label>
                          <div class="col-md-6">
                              <input id="confirm-password" type="password" class="form-control" name="new_password_confirmation" required>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="password" class="col-md-4 control-label"></label>
                          <div class="col-md-6">
                              <!-- <input type="submit" class="btn btn-primary" value="Change Password" > -->
                              <!-- <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#change-password">Cancel</button> -->
                              <input type="submit" class="btn btn-primary" value="Đổi mật khẩu" >
                              <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#change-password">Hủy</button>
                          </div>
                      </div>
                    </form>
                  </div><!-- end change-password -->
                  @else
                  {{ $profiles[0]->fname }} {{ $profiles[0]->lname }} - Profile
                  @endif
                </div>

                <div class="panel-body">
                  <ul class="list-group">
                    @if (!$isStudent)
                      <li class="list-group-item"><strong>First Name:</strong> {{ $profiles[0]->fname }}</li>
                      <li class="list-group-item"><strong>Last Name:</strong> {{ $profiles[0]->lname }}</li>
                      <li class="list-group-item"><strong>Gender:</strong> {{ $profiles[0]->gender }}</li>
                      <li class="list-group-item"><strong>Skype ID:</strong> {{ $profiles[0]->skype }}</li>
                      <li class="list-group-item"><strong>Contact #:</strong> {{ $profiles[0]->contact }}</li>
                      <li class="list-group-item"><strong>Home Address:</strong> {{ $profiles[0]->address }}</li>
                    @else
                      <li class="list-group-item"><strong>Tên:</strong> {{ $profiles[0]->fname }}</li>
                      <li class="list-group-item"><strong>Họ:</strong> {{ $profiles[0]->lname }}</li>
                      <li class="list-group-item"><strong>Giới tính:</strong> {{ $profiles[0]->gender == 'male'? "Nam" : "Nữ"}}</li>
                      <li class="list-group-item"><strong>Skype ID:</strong> {{ $profiles[0]->skype }}</li>
                      <li class="list-group-item"><strong>Số điện thoại:</strong> {{ $profiles[0]->contact }}</li>
                      <li class="list-group-item"><strong>Địa chỉ nhà:</strong> {{ $profiles[0]->address }}</li>
                    @endif
                  </ul>
                </div>
            </div>

            <!-- Site Feedback -->
            @if (Auth::check() && $profiles[0]->user_id === Auth::user()->id)
            <div class="panel panel-default">
                <div class="panel-heading">
                  <!-- My Feedback -->
                  Phản hồi của bạn
                  [ <a href="javascript:void(0)" data-toggle="collapse" data-target="#create-feedback">
                    <!-- Create {{config('app.name')}} feedback -->
                    Tạo phản hồi cho EnglishHours.net
                  </a> ]
                  @if (!empty(session('successFeedback')))
                  <span class="help-block">
                      <strong class="text-success">{{ session('successFeedback') }}</strong>
                  </span>
                  @endif
                </div>

                <div class="panel-body">
                  <!-- create-feedback -->
                  <div id="create-feedback" class="collapse">
                    <form class="form-horizontal" action="{{ url('/feedback/') }}" method="post">
                      {{ csrf_field() }}
                      <div class="form-group">
                          <label for="feedback-remark" class="col-md-4">
                            <!-- Feedback to {{ config('app.name') }} -->
                            Phản hồi gửi đến EnglishHours.net
                          </label>
                          <div class="col-md-12">
                              <textarea id="feedback-remark" class="form-control" name="remark" required></textarea>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label"></label>
                          <div class="col-md-12">
                              <!-- <input type="submit" class="btn btn-primary" value="Submit Feedback" > -->
                              <!-- <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#create-feedback">Cancel</button> -->
                              <input type="submit" class="btn btn-primary" value="Gửi phản hồi" >
                              <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#create-feedback">Hủy</button>
                          </div>
                      </div>
                    </form>
                  </div>
                  <!-- End create-feedback -->

                  <!-- List of feedbacks -->
                  <ul class="list-group">
                    @foreach($profiles[3] AS $v)
                    <li class="list-group-item"><a href="javascript:void(0)" data-toggle="collapse" data-target="#feedback{{$v->id}}"> {{ substr($v->remark,0,60) }}{{strlen($v->remark) > 60? '...' : ''}}</a>  <span class="badge">{{ $v->create_date->diffForHumans() }}</span>
                      <div id="feedback{{$v->id}}" class="collapse">
                        <ul class="list-group">
                          <li class="list-group-item">{{ $v->remark }}</li>
                          <li class="list-group-item bg-info">{!! $v->reply === null? '<i>No reply yet from '.config('app.name').'</i>' : $v->reply !!}</li>
                        </ul>
                      </div>
                    </li>
                    @endforeach
                  </ul>
                  <!-- end list of feedbacks -->
                </div>
            </div>
            @endif
            <!-- end site feedback -->

            <!-- History -->
            <div class="panel panel-default">
                <div class="panel-heading">
                  <!-- Teacher view -->
                  @if (!$isStudent)
                    {{ $profiles[0]->fname }} {{ $profiles[0]->lname }} - Schedules
                  <!-- Owner/Student view -->
                  @else
                    My Schedules [ <a href="{{ url('/studentScheduleList/?past=1') }}">Lịch sử</a> ]
                  @endif
                </div>
                <!-- Show student scheds on Teacher view -->
                @if (!$isStudent)
                <?php
                  $futureSchedules = $profiles[1][0];
                  $pastSchedules = $profiles[1][1];
                ?>
                <div class="panel-body">
                  <div class="col-md-12">

                    <ul class="nav nav-tabs">
                      <li role="presentation" class="future"><a href="javascript:viewFutureSched();">Future Lessons</a></li>
                      <li role="presentation" class="active past"><a href="javascript:viewPastSched();">Past Lessons</a></li>
                    </ul>

                      <div class="panel panel-default" id="future-schedule">
                          <!-- <div class="panel-heading">My List of Future Schedules</div> -->
                          <div class="panel-body">
                              <table id="future" class="display" cellspacing="0" width="100%">
                                <thead>
                                  <tr>
                                    <th>Lesson Schedule</th>
                                    <th>Teacher</th>
                                    <!-- <th>Skype ID</th> -->
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach($futureSchedules AS $v)
                                  <tr>
                                    <td>{!! $common->getFormattedDateTimeRangeMilitary($v->date_time) !!}</td>
                                    <td>{{ucfirst($v->tfname." ".$v->tlname)}} [<a href="{{ url('teacherProfile/'.$v->tuser_id) }}">Profile</a>]</td>
                                    <!-- <td><a href="skype:live:{{$v->tskype}}?call">{{$v->tskype}}</a></td> -->
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
                                    <th>Teacher</th>
                                    <!-- <th>Skype ID</th> -->
                                    <th>Report</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach($pastSchedules AS $v)
                                  <tr>
                                    <td>{!! $common->getFormattedDateTimeRangeMilitary($v->date_time) !!}</td>
                                    <td>{{ucfirst($v->tfname." ".$v->tlname)}} [<a href="{{ url('teacherProfile/'.$v->tuser_id) }}">Profile</a>]</td>
                                    <!-- <td><a href="skype:live:{{$v->tskype}}?call">{{$v->tskype}}</a></td> -->
                                    <td>
                                      @if ($v->called == 1)
                                      <p style="margin:0"><strong>Course:</strong> {{ $v->memo }}</p>
                                      <p style="margin:0"><strong>Book Title:</strong> {{ $v->memo_book }}</p>
                                      <p style="margin:0"><strong>Next Page:</strong> {{ $v->memo_next_page }}</p>
                                      <p style="margin:0"><strong>Comment:</strong> {{ $v->memo_comment }}</p>
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
                @endif
            </div>

        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
@if(!$isStudent)
  <script type="text/javascript">
    $(document).ready(function() {

      // Default past schedules
      viewPastSched();

      // Data tables
      $('#future').DataTable( {
          "pageLength": 20,
          "lengthMenu": [ [10, 20, 50, -1], [10, 20, 50, "All"] ],
          "order": [[ 0, "asc" ]]
      } );
      $('#past').DataTable( {
          "pageLength": 20,
          "lengthMenu": [ [10, 20, 50, -1], [10, 20, 50, "All"] ],
          "order": [[ 0, "desc" ]]
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
@endif
@endsection
