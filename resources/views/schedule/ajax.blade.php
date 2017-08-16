<form id="create-schedule" action="/schedule" method="POST">
  {{ csrf_field() }}
  <div class="panel-heading">
    <h3 class="current-day"></h3>
    <span class="span-row pull-right"><button type="submit" class="btn btn-primary" >Submit</button></span>
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
          <?php $counter = 0; ?>
          @foreach($time[0] AS $k => $v)
          <tr>
            <td>{{ $v }}</td>
            <td>
              @if(in_array($k, $time[2]))
                <i class="text-primary">Selected</i>
              @elseif(date("Y-m-d H:i:s") >= $time[3]." ".$k)
                <i class="text-danger">Past due date and time</i>
              @else
                <label class="form-check-label"><input data-start-time="{{ $k }}" type="checkbox" name="date_time[{{ $counter++ }}]" value="{{ $time[3]." ".$k }}" class="form-check-input"> Open</label>
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
              @else
                <label class="form-check-label"><input data-start-time="{{ $k }}" type="checkbox" name="date_time[{{ $counter++ }}]" value="{{ $time[3]." ".$k }}" class="form-check-input">Open</label>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <span class="span-row pull-right"><button type="submit" class="btn btn-primary" >Submit</button></span>
  </div>
</form>
