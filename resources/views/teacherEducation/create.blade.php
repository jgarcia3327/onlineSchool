@extends('layouts.app')

@section('title', 'Add Educational Background')

@section('content')
<div class="col-md-4 col-md-offset-4">
  <h3>Add Education</h3>
  <form action="{{ url('/teacherEducation') }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="user_id"/>
    <div class="form-group">
      <label for="school_name">Name of School</label>
      <input type="text" class="form-control" id="school_name" name="school_name" placeholder="University of ...">
    </div>
    <div class="form-group">
      <label for="degree">Degree</label>
      <input type="text" class="form-control" id="degree" name="degree" placeholder="Bachelor of Science ...">
    </div>
    <div class="form-group">
      <label for="description">Description</label>
      <textarea class="form-control" id="description" name="description" placeholder="Status, date started, date finished, awards received..." rows="2" required></textarea>
    </div>
    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Submit">
      <a href="{{url('/teacherProfile')}}" class="btn btn-default">Cancel</a>
    </div>

  </form>
</div>
@endsection
