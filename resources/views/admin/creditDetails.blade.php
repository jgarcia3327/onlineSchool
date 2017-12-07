@extends('layouts.app')

@section('title', "Student Lesson Credit Details")

@section('style')
<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
@endsection

@section('content')
<?php
$student_id = $credit_details[0];
$student_name = null;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Add custom number of Credits to Students
                  @if (session("success") != null || session("error") != null)
                    <br>
                    <i class="text-success">{{session("success")}}</i>
                    <i class="text-danger">{{session("error")}}</i>
                  @endif
                </div>

                <div class="panel-body">
                  <form id="credit-details" action="" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label for="student_name">
                        Student Name
                      </label>
                      <select class="form-control" id="student_name" name="student_id" required>
                        <option value=""></option>
                        @foreach($common->getActiveStudents() AS $v)
                        <?php if($v->id == $student_id) $student_name = ucFirst($v->fname)." ".ucFirst($v->lname)." (".$v->email.")";?>
                        <option value="{{$v->id}}" {{$v->id == $student_id? "selected" : ""}}>{{ucFirst($v->fname)}} {{ucFirst($v->lname)}} ({{$v->email}})</option>
                        @endforeach
                      </select>

                    </div>
                    <div class="form-group">
                      <input class="form-control btn btn-primary" type="submit" value="View Credit Details" />
                    </div>
                  </form>
                </div>
            </div>

            @if($student_id == null || $student_id <= 0)
            <div class="panel panel-default">
                <div class="panel-heading"><i class="text-danger">Please select student</i></div>
                <div class="panel-body"></div>
            </div>
            @else
            <?php
              $credits = $credit_details[1];
              $totalCredit = $credits == null? 0 : count($credits);
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                  <h3>{{$student_name}}</h3>
                  <p>Total Purchased Credits: <i class="text-default">{{$totalCredit}}</i></p>
                  <p>Active Credits: <i class="text-primary" id="active-credit"></i></p>
                  <p>Used Credits: <i class="text-success" id="used-credit"></i></p>
                  <p>Expired Credits: <i class="text-danger" id="expired-credit"></i></p>
                </div>
                <?php
                  $active_credit = 0;
                  $used_credit = 0;
                  $expired_credit = 0;
                ?>
                <div class="panel-body">
                  @if ($credits == null)
                  <i class="text-danger">No Credits Found</i>
                  @else
                    <table id="student-credit">
                      <thead>
                        <th>Schedule</th>
                        <th>Teacher</th>
                        <th>Status</th>
                      </thead>
                      <tbody>
                    <?php $counter = 0; ?>
                    @foreach ($credits AS $v)
                      <tr>
                      <?php
                        $date_time = strtotime($v->date_time);
                        $date_created = strtotime($v->create_date);
                        $date_time_active = ($v->consume_days * (24*60*60)); //Convert days to seconds
                        $expired_time = $date_created + $date_time_active;
                        $counter++;
                        $can_cancel = $v->can_cancel != 1? "[Cannot Cancel Schedule]" : "";
                      ?>
                      @if ( $v->active == 0 )
                        <?php $expired_credit++; ?>
                        <td><span style="display:none;">0</span></td>
                        <td></td>
                        <td>{{$can_cancel}} <i class="text-error-inline">Expired last {{date("F d, Y",$expired_time)}}</i></td>
                      @elseif ($v->schedule_id == null || empty($v->schedule_id))
                        <?php $active_credit++; ?>
                        <td><span style="display:none;">0</span></td>
                        <td></td>
                        <td>{{$counter}} ). {{$can_cancel}} <i class="text-success">Open - will expire {{date("F d, Y",$expired_time)}}</i></td>
                      @else
                        <?php $used_credit++; ?>
                        <?php $status = $date_time < strtotime($common->getCarbonNow())? "<i class='text-success'>(Done)</i>" : "<i class='text-danger'>(Incoming)</i>"; ?>
                        <td><span style="display:none;">{{$v->date_time}}</span>{{$common->getFormattedDateTimeRange($v->date_time)}}</td>
                        <td>{{$v->tfname}} {{$v->tlname}} [<a href="{{url('/teacherProfile/'.$v->tuser_id)}}">Teacher Profile</a>]</td>
                        <td>{{$can_cancel}} {!! $status !!}</td>
                      @endif
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                  @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection


@section('javascript')
<script type="text/javascript">
  $(document).ready(function(){
    $("form#credit-details").submit(function(event){
      var student_id = $("select[name='student_id']").val();
      if (typeof student_id != 'undefined' && student_id != "")
      location.href = "/adminCreditDetails/"+student_id;
      event.preventDefault();
    });
  });
</script>
@if ($student_id != null)
<script type="text/javascript">
  $(document).ready(function(){
    $("#active-credit").html("{{$active_credit}}");
    $("#used-credit").html("{{$used_credit}}");
    $("#expired-credit").html("{{$expired_credit}}");
  });
</script>
@endif

<script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#student-credit').DataTable( {
        "order": [[ 0, "asc" ]],
        "pageLength": 60
    } );
  } );
</script>
@endsection
