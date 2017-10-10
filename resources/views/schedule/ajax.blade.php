<?php $dateFormat = date('l, F j, Y', strtotime($time[3])); ?>
<div class="panel panel-default schedule-load {{ $time[3] }}">
  <div class="panel-heading">
    <h3>{{ $dateFormat }}</h3>
  </div>
  <div class="panel-body">
    <div class="col-md-6">
      <table class="table table-striped">
        <thead>
          <tr>
            <th colspan="2">Morning Schedule</th>
          </tr>
        </thead>
        <tbody>
          @foreach($time[0] AS $k => $v)
          <tr>
            <td>{{ $v }}</td>
            <td>
              @if(in_array($k, $time[2]))
                <i class="text-primary">Selected</i>
              @elseif(date("Y-m-d H:i:s") >= $time[3]." ".$k)
                <i class="text-danger">Past due date and time</i>
              <!-- Earlier than 24 hours = 86400 seconds -->
              @elseif( (strtotime(date("Y-m-d H:i:s")) + 86400) >= strtotime($time[3]." ".$k))
                <i class="text-warning">Less than 24 hours policy</i>
              @else
                <label class="form-check-label"><input data-start-time="{{ $k }}" data-sched-date="{{ $dateFormat }} | {{ $v }}" type="checkbox" name="date_time[{{ strtotime($time[3]." ".$k) }}]" value="{{ $time[3]." ".$k }}" class="form-check-input"> Open</label>
              @endif
          </td>
          </tr>
          @endforeach()
        </tbody>
      </table>
    </div>
    <div class="col-md-6">
      <table class="table table-striped">
        <thead>
          <tr>
            <th colspan="2">Afternoon Schedule</th>
          </tr>
        </thead>
        <tbody>
          @foreach( $time[1] AS $k => $v)
          <tr>
            <td>{{ $v }}</td>
            <td>
              @if(in_array($k, $time[2]))
                <i class="text-primary">Selected</i>
              @elseif(date("Y-m-d H:i:s") >= $time[3]." ".$k)
                <i class="text-danger">Past due date and time</i>
              <!-- Earlier than 24 hours = 86400 seconds -->
              @elseif( (strtotime(date("Y-m-d H:i:s")) + 86400) >= strtotime($time[3]." ".$k))
                <i class="text-warning">Less than 24 hours policy</i>
              @else
                <label class="form-check-label"><input data-start-time="{{ $k }}" data-sched-date="{{ $dateFormat }} | {{ $v }}" type="checkbox" name="date_time[{{ strtotime($time[3]." ".$k) }}]" value="{{ $time[3]." ".$k }}" class="form-check-input">Open</label>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
