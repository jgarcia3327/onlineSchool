@extends('layouts.app')

@section('title', "List of Student - English Hours")

@section('style')
<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Students</div>

                <div class="panel-body">
                    <table id="student" class="display" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Contact #</th>
                          <th>Skype ID</th>
                          <th>Register Date</th>
                          <th>Lesson Credit</th>
                          <th>Balance</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($student_info AS $v)
                        <tr>
                          <td>{{$v['name']}}</td>
                          <td>{{$v['contact']}}{{$v['name']}}</td>
                          <td>{{$v['skype']}}</td>
                          <td>{{$v['register']}}</td>
                          <td>{{$v['credit']}}</td>
                          <td>{{$v['balance']}}</td>
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
        "order": [[ 3, "desc" ]]
    } );
  } );
</script>
@endsection
