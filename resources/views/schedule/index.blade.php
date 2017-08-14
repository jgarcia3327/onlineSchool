@extends('layouts.app')

@section('title')
  Lesson Scheduler
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <!-- Future lessons -->
            <div class="panel panel-default">
                <div class="panel-heading">Future Lessons
                  [ <a href="{{ url('/schedule/create') }}">Add</a> ]
                </div>
                <div class="panel-body">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Date / Time</th>
                          <th>Student</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($schedules[0] AS $v)
                        <tr>
                          <td>{{$v->date_time}}</td>
                          <td>Student here... [ Call ]</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
            <!-- Past Lessons -->
            <div class="panel panel-default">
                <div class="panel-heading">Past Lessons</div>
                <div class="panel-body">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Date / Time</th>
                          <th>Student</th>
                          <th>Memo</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($schedules[1] AS $v)
                        <tr>
                          <td>{{ $v->date_time}}</td>
                          <td>Studend here...</td>
                          <td>Memo here...</td>
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
