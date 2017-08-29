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
                @if($v->student_user_id != null && $schedules[4][$v->student_user_id] != null)
                  {{ $schedules[4][$v->student_user_id]->fname }} {{ $schedules[4][$v->student_user_id]->lname }} [ <a href="{{url('/profile/'.$schedules[4][$v->student_user_id]->id)}}">Profile</a> ]
                  <?php
                    $schedTime =  strtotime($v->date_time);
                    $curTime = strtotime(date("Y-m-d H:i:s"));
                    $expireDateTime = $schedTime + 600; //10 minutes before called button elapse
                    $startDateTime = $schedTime - 300; //5 minutes earlier to show call button
                  ?>
                  @if( $curTime >= $startDateTime && $curTime <= $expireDateTime )
                    @if($v->called == null)
                      <form class="call-form" action="{{ url('/schedule/'.$v->id) }}" method="POST">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <input type="hidden" name="called" value="1">
                        <input type="submit" value="Call"/>
                      </form>
                    @else
                      [ <a href="skype:live:{{ $schedules[4][$v->student_user_id]->skype }}?call">Skype Call</a> ]
                    @endif
                  @endif
                @else
                  Open <form class="call-form" action="{{ url('/schedule/'.$v->id) }}" method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <input type="hidden" name="cancel" value="1">
                    <input type="submit" value="Cancel Schedule"/>
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
                @if($v->student_user_id != null && $schedules[4][$v->student_user_id] != null)
                  {{ $schedules[4][$v->student_user_id]->fname }} {{ $schedules[4][$v->student_user_id]->lname }}
                @else
                  Open
                @endif
              </td>
              <td>
                @if($v->student_user_id != null && $schedules[4][$v->student_user_id] != null)
                  @if($v->memo != null)
                  <p>Memo: {{ $v->memo }}</p>
                  <p>Memo Book: {{ $v->memo_book }}</p>
                  <p>Memo Next Page: {{ $v->memo_book }}</p>
                  @elseif($v->called == 1)
                  <form action="{{ url('schedule/'.$v->id) }}" method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="form-group">
                      <select class="form-control" id="memo" name="memo" required placeholder="Memo">
                        <option value=""></option>
                        <option>Reading</option>
                        <option>Writing</option>
                        <option>Speaking</option>
                        <option>Listening</option>
                      </select>
                      <input class="form-control" type="text" id="memo_book" name="memo_book" required placeholder="Memo Book">
                      <input class="form-control" type="text" id="memo_next_page" name="memo_next_page" required placeholder="Memo Next Page">
                      <input class="form-control btn btn-primary" type="submit" value="Submit" />
                    </div>
                  </form>
                  @else
                  <i class="text-danger">Missed Session</i>
                  @endif
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
