<!-- Future lessons -->
<div class="panel panel-default" id="my-schedule">
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
                  {{ $schedules[4][$v->student_user_id]->fname }} {{ $schedules[4][$v->student_user_id]->lname }} [ <a href="{{url('/profile/'.$v->student_user_id)}}">Profile</a> ]
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
                  @elseif ( $curTime >= $schedTime - 86400)
                    <!-- Disable cancellation under 24 hours -->
                  @else
                    [ <a class="text-danger" role="button" data-toggle="collapse" href="#collapse{{$v->id}}" aria-expanded="true" aria-controls="collapse{{$v->id}}">Cancel</a> ]
                    <div id="collapse{{$v->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$v->id}}">
                      <form class="call-form" action="{{ url('/schedule/'.$v->id) }}" method="POST">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <input type="hidden" name="cancel" value="1">
                        <input type="submit" value="Confirm"/>
                      </form>
                      [ <a role="button" data-toggle="collapse" href="#collapse{{$v->id}}" aria-expanded="true" aria-controls="collapse{{$v->id}}">Close</a> ]
                    </div>
                  @endif

                @else
                  <!-- 1hr = 3600 -->
                  <!-- 24hr = 86400 -->
                  @if ( strtotime(date("Y-m-d H:i:s")) >= (strtotime($v->date_time) - 3600) )
                    <i class="text-warning">No reservation - closed</i>
                  @elseif ( strtotime(date("Y-m-d H:i:s")) >= (strtotime($v->date_time) - 86400) )
                    Open
                  @else
                    Open <form class="call-form" action="{{ url('/schedule/'.$v->id) }}" method="POST">
                      {{ method_field('PUT') }}
                      {{ csrf_field() }}
                      <input type="hidden" name="cancel" value="1">
                      <input type="submit" value="Cancel"/>
                    </form>
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
                  <strong>Course:</strong><p style="margin:0">{{ $v->memo }}</p>
                  <strong>Book Title:</strong><p style="margin:0">{{ $v->memo_book }}</p>
                  <strong>Next Page:</strong><p style="margin:0">{{ $v->memo_next_page }}</p>
                  <strong>Teacher's Comment:</strong><p style="margin:0">{{ $v->memo_comment }}</p>
                  @elseif($v->called == 1)
                  <form action="{{ url('schedule/'.$v->id) }}" method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="form-group">
                      <select class="form-control" id="memo" name="memo" required placeholder="Course">
                        <option value=""></option>
                        <option value="IELTS/TOEIC/TOEFL">IELTS/TOEIC/TOEFL</option>
                        <option value="BUSINESS/OFFICE ENGLISH">BUSINESS/OFFICE ENGLISH</option>
                        <option value="ENGLISH FOR KIDS">ENGLISH FOR KIDS</option>
                        <option value="PUBLIC SPEAKING">PUBLIC SPEAKING</option>
                        <option value="WRITING AND COMPOSITION">WRITING AND COMPOSITION</option>
                        <option value="READING AND COMPREHENSION">READING AND COMPREHENSION</option>
                        <option value="LISTENING">LISTENING</option>
                      </select>
                      <input class="form-control" type="text" id="memo_book" name="memo_book" required placeholder="Book Title">
                      <input class="form-control" type="text" id="memo_next_page" name="memo_next_page" required placeholder="Next Page">
                      <textarea id="memo_comment" name="memo_comment" required placeholder="Comment" style="width:100%"></textarea>
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
