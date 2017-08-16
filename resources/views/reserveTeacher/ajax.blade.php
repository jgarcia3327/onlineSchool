<form id="create-schedule" action="/reserveTeacher/{{$time[3]}}" method="POST">
  {{ method_field('PUT') }}
  {{ csrf_field() }}
  <div class="panel-heading">
    <h3 class="current-day"></h3>
    <span class="span-row pull-right"><button type="submit" class="btn btn-primary" >Submit</button></span>
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

          <?php if($time[1][$k] != null && $time[1][$k] != $auth->id) continue; ?>
          <?php if(date("Y-m-d H:i:s") >= $time[2]." ".$k) continue; ?>

          <tr>
            <td>{{ $v }}</td>
            <td>
              @if($time[1][$k] == $auth->id)
                <i class="text-primary">Enrolled</i>
              @else
                <label class="form-check-label"><input type="checkbox" name="schedule_id[{{ $counter++ }}]" value="{{ $k }}" class="form-check-input"> Reserve</label>
              @endif
          </td>
          </tr>
          @endforeach()
        </tbody>
      </table>
    <span class="span-row pull-right"><button type="submit" class="btn btn-primary" >Submit</button></span>
  </div>
</form>
