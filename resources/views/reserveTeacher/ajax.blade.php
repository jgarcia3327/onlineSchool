<?php $dateFormat = date('l, F j, Y', strtotime($time[2])); ?>
<div class="panel panel-default schedule-load {{ $time[2] }}">
  <div class="panel-heading">
    <h3>{{ $dateFormat }}</h3>
  </div>
  <div class="panel-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th colspan="2">Available Schedule</th>
          </tr>
        </thead>
        <tbody>
          <?php $counter = 0; ?>
          @foreach($time[0] AS $k => $v)

          <?php //if($time[1][$k] != null && $time[1][$k] != $auth->id) continue; ?>
          <?php //if(date("Y-m-d H:i:s") >= $time[2]." ".$k) continue; ?>
          <?php
            $v = substr($v, 0, strrpos($v,":"));
            $min = strstr($v, ":");
            $hour = strstr($v,":",true);
            $ampm = ($hour >= 12)? "PM" : "AM";
            $hour = ($hour >= 13)? $hour - 12 : $hour;

            if (strstr($v,":") == ":30") {
              $ampmTo = ($hour+1 >= 12)? "PM" : "AM";
              $ampmTo = (strstr($v,":",true))+1 == 24? "AM" : $ampmTo;
              $vformat = $hour.$min." ".$ampm." - ".($hour+1).":00 ".$ampmTo;
            }
            else {
              $vformat = $hour.$min." ".$ampm." - ".$hour.":30 ".$ampm;
            }
          ?>

          <tr>
            <td>{{ $vformat }}</td>
            <td>
              @if($time[1][$k] == $auth->id && date("Y-m-d H:i:s") >= $time[2]." ".$v)
                <i class="text-warning">Enrolled (Closed)</i>
              @elseif($time[1][$k] == $auth->id)
                  <i class="text-primary">Enrolled</i>
              @elseif( $time[1][$k] != null || date("Y-m-d H:i:s") >= $time[2]." ".$v )
                <i class="text-danger">Closed</i>
              @else
                <label class="form-check-label"><input type="checkbox" name="schedule_id[{{ $counter++ }}]" data-sched-date="{{ $dateFormat }} | {{ $vformat }}" value="{{ $k }}" class="form-check-input"> Reserve</label>
              @endif
          </td>
          </tr>
          @endforeach()
          @if($counter == 0)
          <tr>
            <td colspan="2"><i class="text-danger">No Available Schedule</i></td>
          </tr>
          @endif
        </tbody>
      </table>
  </div>
</div>
