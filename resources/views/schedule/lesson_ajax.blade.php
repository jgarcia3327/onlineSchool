<!-- Future lessons -->
<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="text-center">
      @if($schedules[2] != null)
      <strong>{{ $common->getFormattedDate($schedules[2]) }}</strong>
      @else
      <strong>{{ $common->getFormattedDate($schedules[3][0]) }}</strong> - to - <strong>{{ $common->getFormattedDate($schedules[3][1]) }}</strong>
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
                @if ( (strtotime($v->date_time)-360) >= strtotime(date("Y-m-d H:i:s")) )
                <form class="call-form" action="{{ url('/schedule/'.$v->id) }}" method="POST">
                  {{ method_field('PUT') }}
                  {{ csrf_field() }}
                  <input type="hidden" name="cancel" value="1">
                  <input type="submit" value="Hủy bài học"/>
                </form>
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

<script>
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

</script>
