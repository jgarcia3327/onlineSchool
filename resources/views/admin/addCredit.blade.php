@extends('layouts.app')

@section('title', "Add Student Lesson Credits")

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
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
                  <form action="{{url('/storeAdminAddCredit')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label for="student_name">
                        Student Name
                      </label>
                      <select class="form-control" id="student_name" name="student_id" required>
                        <option value=""></option>
                        @foreach($common->getActiveStudents() AS $v)
                        <option value="{{$v->id}}">{{ucFirst($v->fname)}} {{ucFirst($v->lname)}} ({{$v->email}})</option>
                        @endforeach
                      </select>

                      <label for="num_credit">
                        Number of Credits
                      </label>
                      <select class="form-control" id="num_credit" name="num_credit" required>
                        <option value=""></option>
                        @for($i = 1; $i <= 30; $i++)
                        <option value="{{$i}}">{{$i}}</option>
                        @endfor
                      </select>

                      <label for="num_days">
                        Number of validity days
                      </label>
                      <select class="form-control" id="num_days" name="num_days" required>
                        <option value=""></option>
                        @for($i = 1; $i <= 60; $i++)
                        <option value="{{$i}}">{{$i}}</option>
                        @endfor
                      </select>

                    </div>
                    <div class="form-group">
                      <input class="form-control btn btn-primary" type="submit" value="Add and Activate Lessons" />
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
