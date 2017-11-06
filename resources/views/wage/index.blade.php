@extends('layouts.app')

@section('title', "Wage - English Hours")

@section('content')
<?php $schedules = $wages[0]; ?>
<?php $startDate = $wages[1]; ?>
<?php $endDate = $wages[2]; ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

          <!-- Year/month/pich form -->
          <form id="teacher-wage" action="" method="POST">
            <div class="panel panel-default">
                <div class="panel-heading">Wage</div>

                <div class="panel-body">

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
                    <button id="teacher-wage-submit" class="btn btn-primary" type="submit" >Submit</button>
                  </div>
                </div>
            </div>
            </form>
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
                          @if(strtotime($v->date_time) > strtotime($common->getCarbonNow()))
                          <td><span class="text-primary"><i>Incoming Session<i></span></td>
                          @else
                          <td><span class="text-danger">Missed Session</span></td>
                          @endif
                        @else
                        <td><span class="text-success">Successful Session</span></td>
                        @endif

                        <!-- No Student -->
                        @if($v->student_user_id === null)
                        <td>&nbsp;</td>
                        <!-- Missed session -->
                        @elseif( $v->called === null && strtotime($v->date_time) < strtotime($common->getCarbonNow()) )
                        <?php $deduction += 25; ?>
                        <td><span class="text-danger">-25 PHP</span></td>
                        <!-- Successful session -->
                        @elseif($v->called !== null && strtotime($v->date_time) < strtotime($common->getCarbonNow()))
                        <?php $gross += 100; ?>
                        <td><span class="text-success">100 PHP</span></td>
                        <!-- Incoming session -->
                        @else
                        <td><span class="text-primary">0 PHP</span></td>
                        @endif
                      </tr>
                      @endforeach
                    @endif
                  </table>
                  <h4>Total Earning: {{$gross-$deduction}} PHP</h4>
                </div>
            </div>
            <!-- end wage display -->

        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript" src="{{ asset('js/teacher-wage.js') }}"></script>
@endsection
