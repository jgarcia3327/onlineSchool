@extends('layouts.app')

@section('title', "Teacher Salary - English Hours")

@section('content')
<?php
  $schedules = $wages[0];
  $startDate = $wages[1];
  $endDate = $wages[2];
  $teacherID = $wages[3];
  $selectedTeacherName = null;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">

          <!-- Year/month/pich form -->
          <form id="teacher-wage" action="" method="POST">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <h3>Teacher's Wage</h3>
                  <div class="form-group">
                    <label for="year">Select Teacher:</label>
                    <select class="form-control" id="teacher-id" name="teacher-id">
                      <option></option>
                      @foreach($common->getActiveTeachers() AS $v)
                      <?php
                        $teacherName = $v->fname." ".$v->lname." - ".$v->email;
                        if($v->id == $teacherID) {
                          $selectedTeacherName = $teacherName;
                        }
                      ?>
                      <option value="{{$v->id}}" {{$v->id == $teacherID? "selected":""}}>{{$teacherName}}</option>
                      @endforeach
                    </select>
                  </div>

                </div>

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
                <div class="panel-heading">
                  @if (!empty($selectedTeacherName))
                  <h3 class="text-success">{{$selectedTeacherName}}</h3>
                  @endif
                  <i>(YYYY-MM-DD)</i><br/>
                  <strong class="text-error-inline">{{ date('Y-m-d', strtotime($startDate)) }}</strong> to <strong class="text-error-inline">{{ date('Y-m-d', strtotime($endDate)) }}</strong> Classes
                </div>

                <div class="panel-body">
                  <form class="teacher-wage" action="{{ url('/adminCreditMissedCall') }}" method="POST">
                    {{ csrf_field() }}
                    <table class="table striped">
                      <tr>
                        <th>Schedule</th>
                        <th>Student</th>
                        <th>Status</th>
                        <th>Salary</th>
                      </tr>
                      <?php $gross = $deduction = 0; ?>
                      @if($teacherID == null || empty($schedules) || count($schedules) <= 0)
                        <tr>
                          <td colspan="4"><i>No Schedule Found.</i></td>
                        </tr>
                      @else
                        <?php $missedCounter = 0; ?>
                        @foreach($schedules AS $v)
                        <tr>
                          <td>{{ $common->getFormattedDateTimeRange($v->date_time) }}</td>
                          <td>
                            @if($v->student_user_id != null)
                              {{$v->sfname}} {{$v->slname}} ({{$v->semail}}) [<a href="{{url('/adminCreditDetails/'.$v->student_user_id)}}">Credit&nbsp;Details</a>]
                            @endif
                          </td>
                          @if($v->student_user_id === null)
                          <td>Open</td>
                          @elseif( $v->called === null )
                            @if(strtotime($v->date_time) > strtotime($common->getCarbonNow()))
                            <td><span class="text-primary"><i>Incoming Session<i></span></td>
                            @else
                            <?php $missedCounter++ ?>
                            <td><span class="text-danger">Missed Session [ <input type="checkbox" name="schedID[]" value="{{$v->id}}" /> Credit ]</span></td>
                            @endif
                          @else
                          <td><span class="text-success">Successful Session</span></td>
                          @endif

                          @if($v->student_user_id === null)
                          <td>&nbsp;</td>
                          @elseif( $v->called === null  && strtotime($v->date_time) < strtotime($common->getCarbonNow()) )
                          <?php $deduction += 25; ?>
                          <td><span class="text-danger">-25 PHP</span></td>
                          @elseif($v->called !== null && strtotime($v->date_time) < strtotime($common->getCarbonNow()))
                          <?php $gross += 100; ?>
                          <td><span class="text-success">100 PHP</span></td>
                          @else
                          <td><span class="text-primary">0 PHP</span></td>
                          @endif
                        </tr>
                        @endforeach
                        @if ($missedCounter > 0)
                        <tr>
                          <td colspan="3" align="right"><button type="submit" class="btn btn-danger" id="credit-missed-call" disabled>Credit missed call</button></td>
                        </tr>
                        @endif
                      @endif
                    </table>
                  </form>
                  <h4 class="pull-right"><strong>Total Earning: {{$gross-$deduction}} PHP</strong></h4>
                </div>
            </div>
            <!-- end wage display -->

        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
  $(document).ready(function(){

    // Teacher and date range submit
    $("#teacher-wage-submit").click(function(event) {
      var form = $("form#teacher-wage");
      var year = form.find("select[name='year']").val();
      var month = form.find("select[name='month']").val();
      var pitch = form.find("select[name='pitch']").val();
      var teacherID = form.find("select[name='teacher-id']").val();
      window.location.href = "/adminTeacherSalary/"+year+"-"+month+"-"+pitch+"-"+teacherID;
      event.preventDefault();
    });

    // Missed session
    $("form.teacher-wage input[type='checkbox']").change(function(){
      var numberOfChecked = $('form.teacher-wage input:checkbox:checked').length;
      if (numberOfChecked > 0) {
        $("#credit-missed-call").removeAttr("disabled");
      }
      else{
        $("#credit-missed-call").attr("disabled","disabled");
      }
    });

  });
</script>
@endsection
