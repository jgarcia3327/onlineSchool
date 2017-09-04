@extends('layouts.app')

@section('content')
<?php $schedules = $wages[0]; ?>
<?php $startDate = $wages[1]; ?>
<?php $endDate = $wages[2]; ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

          <!-- Year/month/pich form -->
            <div class="panel panel-default">
                <div class="panel-heading">Wage</div>

                <div class="panel-body">
                  <form class="" action="{{ url('/wage') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="year">Select Year:</label>
                        <select class="form-control" id="year" name="year">
                          <?php $endYear = date('Y', strtotime($auth->created_at)) ?>
                          <?php $startYear = date('Y'); ?>
                          @while($startYear >= $endYear)
                          <option value="{{$startYear}}" {{ $startYear == date('Y', strtotime($startDate))? "selected" : ""}}>{{$startYear}}</option>
                          <?php $startYear--; ?>
                          @endwhile
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="month">Select Month:</label>
                        <select class="form-control" id="month" name="month">
                          @foreach($common->getMonths() AS $k => $v)
                          <option value="{{$k}}" {{$k == date('n', strtotime($startDate))? 'selected' : ''}}>{{$v}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="days">Select Days:</label>
                        <select class="form-control" id="pitch" name="pitch">
                          <option value="1" {{date('j', strtotime($startDate))<=15? 'selected' : ''}}>1st-to-15th</option>
                          <option value="2" {{date('j', strtotime($startDate))>15? 'selected' : ''}}>16th-to-last day of month</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12 text-right">
                      <button class="btn btn-primary" type="submit" >Submit</button>
                    </div>
                  </form>
                </div>
            </div>
            <!-- form -->

            <!-- Wage display -->
            <div class="panel panel-default">
                <div class="panel-heading"><strong>{{ date('Y-m-d', strtotime($startDate)) }}</strong> to <strong>{{ date('Y-m-d', strtotime($endDate)) }}</strong> Classes</div>

                <div class="panel-body">
                  <table class="table striped">
                    <tr>
                      <th>Schedule</th>
                      <th>Status</th>
                      <th>Salary</th>
                    </tr>
                    <?php $gross = $deduction = 0; ?>
                    @if(empty($schedules) || count($schedules) <= 0)
                      <tr>
                        <td colspan="3"><i>No Schedule Found.</i></td>
                      </tr>
                    @else
                      @foreach($schedules AS $v)
                      <tr>
                        <td>{{ $common->getFormattedDateTimeRange($v->date_time) }}</td>
                        @if($v->student_user_id === null)
                        <td>Open</td>
                        @elseif( $v->called === null )
                        <td><span class="text-danger">Missed Session</span></td>
                        @else
                        <td><span class="text-success">Successful Session</span></td>
                        @endif

                        @if($v->student_user_id === null)
                        <td>&nbsp;</td>
                        @elseif( $v->called === null )
                        <?php $deduction += 1; ?>
                        <td><span class="text-danger">-1 USD</span></td>
                        @else
                        <?php $gross += 2; ?>
                        <td><span class="text-success">2 USD</span></td>
                        @endif
                      </tr>
                      @endforeach
                    @endif
                  </table>
                  <h4>Total Earning: {{$gross-$deduction}} USD</h4>
                </div>
            </div>
            <!-- end wage display -->

        </div>
    </div>
</div>
@endsection
