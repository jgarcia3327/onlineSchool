@extends('layouts.app')

@section('title', "List of Schedules - English Hours")

@section('style')
<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">List of Future Schedules</div>

                <div class="panel-body">
                    <table id="student" class="display" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Lesson Schedule</th>
                          <th>Teacher</th>
                          <th>Teacher Skype ID</th>
                          <th>Student</th>
                          <th>Student Skype ID</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($schedules AS $v)
                        <tr>
                          <td>{{$common->getFormattedDateTimeRange($v->date_time)}}</td>
                          <td>{{ucfirst($v->tfname." ".$v->tlname)}}</td>
                          <td><a href="skype:live:{{$v->tskype}}?call">{{$v->tskype}}</a></td>
                          <td>{{ucfirst($v->sfname." ".$v->slname)}}</td>
                          <td><a href="skype:live:{{$v->sskype}}?call">{{$v->sskype}}</a></td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#student').DataTable( {
        "order": [[ 0, "asc" ]]
    } );
  } );
</script>
@endsection
