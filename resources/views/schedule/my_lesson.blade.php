@extends('layouts.app')

@section('title')
  Lesson Scheduler
@endsection

@section('content')
<?php $credits = $common->getStudentCreditCount($auth->id); ?>
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
              <div class="panel-heading">Chọn một ngày hoặc một tuần bạn muốn để hiển thị lịch học của bạn [ <a href="{{ url('/studentScheduleList') }}">My List of Lessons</a> ]
                @if (!empty(session('success')))
                <span class="help-block">
                    <strong class="text-danger">
                      <!-- Schedule reservation cancelled successfully.  -->
                      Buổi học của bạn đã được hủy bỏ thành công.
                      <br/>-{{ $common->getFormattedDateTimeRange(session('success')) }} </strong>
                </span>
                @endif
              </div>
              <div class="panel-body">
                <div class="col-md-8 col-md-offset-2">
                  <div id="week-datepicker"></div>
                </div>
              </div>
          </div>

          <div id="lessons-list">

          <!-- LESSONS -->
          <!-- Future lessons -->
          <div class="panel panel-default" id="my-schedule">
              <div class="panel-heading">
                <h3 class="text-center">
                @if($schedules[2] != null)
                <strong>{{ $common->getFormattedDateVietNam($schedules[2]) }}</strong>
                @else
                <strong>{{ $common->getFormattedDateVietNam($schedules[3][0]) }}</strong> - to - <strong>{{ $common->getFormattedDateVietNam($schedules[3][1]) }}</strong>
                @endif
                </h3>
                Bài học sẽ thực hiện</div>
              <div class="panel-body">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Ngày/Giờ</th>
                        <th>Giáo viên</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if($schedules[0] != null)
                      @foreach($schedules[0] AS $v)
                      <tr>
                        <td>{{ $common->getFormattedDateTimeRange($v->date_time) }}</td>
                        <td>
                          {{ $v->fname }} {{ $v->lname }}
                          <!-- 2hrs = 7200 in sec -->
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
                            [ <a role="button" data-toggle="collapse" href="#collapse{{$v->id}}" aria-expanded="true" aria-controls="collapse{{$v->id}}">Close</a> ]
                          @endif
                        </td>
                      </tr>
                      @endforeach
                      @endif
                    </tbody>
                  </table>
              </div>
          </div>
          <!-- Past Lessons -->
          <div class="panel panel-default">
              <div class="panel-heading">Bài học đã thực hiện</div>
              <div class="panel-body">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Ngày/Giờ</th>
                        <th>Giáo viên</th>
                        <th>Ghi chú</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if($schedules[1] != null)
                      @foreach($schedules[1] AS $v)
                      <tr>
                        <td>{{ $common->getFormattedDateTimeRange($v->date_time) }}</td>
                        <td>
                          <a href="{{url('/teacherProfile/'.$v->teacher_user_id)}}">{{ $v->fname }} {{ $v->lname }}</a>
                        </td>
                        <td>
                            @if($v->called == null)
                              <i class="text-danger">Bài học bị bỏ lỡ<!--Missed Session--></i>
                            @elseif($v->memo != null)
                              <strong>Tên khóa học:</strong><p style="margin:0">{{ $v->memo }}</p>
                              <strong>Tên sách:</strong><p style="margin:0">{{ $v->memo_book }}</p>
                              <strong>Trang tiếp theo:</strong><p style="margin:0">{{ $v->memo_next_page }}</p>
                              <strong>Nhận xét của giáo viên:</strong><p style="margin:0">{{ $v->memo_comment }}</p>
                            @endif
                        </td>
                      </tr>
                      @endforeach
                      @endif
                    </tbody>
                  </table>
              </div>
          </div>

          <!-- END LESSONS -->

          </div>

        </div>
    </div>
</div>
@endsection

<?php
  $dateActiveArr = $schedules[2] != null? explode("-", $schedules[2]) : explode("-", $schedules[3][0]);
  $dateActiveStr = $dateActiveArr[0].",".($dateActiveArr[1]-1).",".$dateActiveArr[2];
?>

@section('javascript')

<!-- <script type="text/javascript" src="{{ asset('js/display-teacher.js') }}"></script> -->
<script type="text/javascript" src="{{ asset('js/my_schedule.js') }}"></script>

<script>
  // Set date selected
  // console.log("{{$dateActiveStr}}");
  //$('#week-datepicker').datepicker("setDate", new Date(2017,9,24) ); //Oct. 24, 2017
  $(document).ready(function(){
    $('#week-datepicker').datepicker("setDate", new Date({{$dateActiveStr}}) );

    // Load week button trigger in #week-datepicer
    $("#week-datepicker .ui-datepicker-week-col").click(function(){
        $(".loader").css({"display":"block"});
        $("#lessons-list").css({"display":"none"});
        var year = $("#week-datepicker .ui-datepicker-year").text();
        var week = $(this).text();
        dateStr = week+"_"+year;
        console.log(dateStr);
        getSavedDateTime(dateStr);
    });
  });
</script>

@endsection
