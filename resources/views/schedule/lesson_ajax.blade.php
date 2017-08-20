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
      Future Lessons</div>
    <div class="panel-body">
        <table class="table">
          <thead>
            <tr>
              <th>Date / Time</th>
              <th>Student</th>
            </tr>
          </thead>
          <tbody>
            @if($schedules[0] != null)
            @foreach($schedules[0] AS $v)
            <tr>
              <td>{{ $common->getFormattedDateTimeRange($v->date_time) }}</td>
              <td>
                {{$schedules[4][$v->teacher_user_id]->fname}} {{$schedules[4][$v->teacher_user_id]->lname}}
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
    <div class="panel-heading">Past Lessons</div>
    <div class="panel-body">
        <table class="table">
          <thead>
            <tr>
              <th>Date / Time</th>
              <th>Student</th>
              <th>Memo</th>
            </tr>
          </thead>
          <tbody>
            @if($schedules[1] != null)
            @foreach($schedules[1] AS $v)
            <tr>
              <td>{{ $common->getFormattedDateTimeRange($v->date_time) }}</td>
              <td>
                {{$schedules[4][$v->teacher_user_id]->fname}} {{$schedules[4][$v->teacher_user_id]->lname}}
              </td>
              <td>
                  @if($v->memo != null)
                    <p>Memo: {{ $v->memo }}</p>
                    <p>Memo Book: {{ $v->memo_book }}</p>
                    <p>Memo Next Page: {{ $v->memo_book }}</p>
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
