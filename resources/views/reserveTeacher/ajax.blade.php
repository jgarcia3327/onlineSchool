<?php $dateFormat = date('l, F j, Y', strtotime($time[2])); ?>
<div class="panel panel-default schedule-load {{ $time[2] }}">
  <div class="panel-heading">
    <h3>{{ $common->getFormattedDateVietNam($dateFormat)}}</h3>
  </div>
  <div class="panel-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th colspan="2">Lịch dạy</th>
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
              $ampmTo = (strstr($v,":",true))+1 >= 12? "PM" : "AM";
              $ampmTo = (strstr($v,":",true))+1 == 24? "AM" : $ampmTo;
              $vformat = $hour.$min." ".$ampm." - ".($hour+1).":00 ".$ampmTo;
            }
            else {
              $vformat = $hour.$min." ".$ampm." - ".$hour.":30 ".$ampm;
            }
          ?>
          @if( date("Y-m-d H:i:s") <= $time[2]." ".$v )
          <tr>
            <td>{{ $vformat }}</td>
            <td>
              @if( Auth::check() && $time[1][$k] == $auth->id )
                  <i class="text-primary">Đã được chọn<!--Enrolled--></i>
              @elseif( $time[1][$k] != null )
                <i class="text-danger">Đã được chọn<!--Closed--></i>
              @elseif( strtotime(date("Y-m-d H:i:s")) >= strtotime($time[2]." ".$v) - 7200 ) <!-- Lock if start sched is less than 2 hours = 7200 sec. -->
                <!-- <i class="text-warning">Locked</i> -->
                <i class="text-warning">Đã khóa</i>
              @else
                <?php $counter++; ?>
                <label class="form-check-label"><input type="checkbox" name="schedule_id[{{ $k }}]" data-sched-date="{{ $dateFormat }} | {{ $vformat }}" value="{{ $k }}" class="form-check-input"> Chọn</label>
              @endif
          </td>
          </tr>
          @endif
          @endforeach()
          @if($counter == 0)
          <tr>
            <td colspan="2"><i class="text-danger">Không có lịch dạy nào trong ngày</i></td>
          </tr>
          @endif
        </tbody>
      </table>
  </div>
</div>
