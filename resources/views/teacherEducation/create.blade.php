@extends('layouts.app')

@section('title', 'Add Educational Background')

@section('content')
<div class="col-md-4 col-md-offset-4">
  <h3>Add Education</h3>
  <form action="{{ url('/teacherEducation') }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="user_id"/>
    <div class="form-group">
      <label for="school_name">Name of School/University</label>
      <input type="text" class="form-control" id="school_name" name="school_name" placeholder="University of ..." required>
    </div>
    <div class="form-group">
      <label for="degree">Degree</label>
      <input type="text" class="form-control" id="degree" name="degree" placeholder="Bachelor of Science ..." required>
    </div>
    <div class="form-group">
      <label for="start_month">Start Date (Month / Year)</label>
      <select class="form-control" id="start_month" name="start_month">
        @foreach ($common->getMonths() as $k => $v)
        <option value="{{$k}}" {{$k == date('m')? "selected" : ""}}>{{$v}}</option>
        @endforeach
      </select>
      <select class="form-control" id="start_year" name="start_year">
        @for ($y = date('Y'); $y>1999; $y--)
        <option value="{{$y}}">{{$y}}</option>
        @endfor
      </select>
    </div>
    <div class="form-group">
      <label for="end_month">End Date (Month / Year)</label>
      <select class="form-control" id="end_month" name="end_month">
        @foreach ($common->getMonths() as $k => $v)
        <option value="{{$k}}" {{$k == date('m')? "selected" : ""}}>{{$v}}</option>
        @endforeach
      </select>
      <select class="form-control" id="end_year" name="end_year">
        @for ($y = date('Y'); $y>1999; $y--)
        <option value="{{$y}}">{{$y}}</option>
        @endfor
      </select>
    </div>
    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Submit">
      <a href="{{url('/teacherProfile')}}" class="btn btn-default">Cancel</a>
    </div>

  </form>
</div>
@endsection
