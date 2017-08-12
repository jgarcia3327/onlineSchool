@extends('layouts.app')

@section('title')
  Profile
@endsection

@section('content')
<?php $profile = $profiles['profile']; ?>
<?php $educations = $profiles['education']; ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">My Profile
                  @if (Auth::check() && $profile->user_id === Auth::user()->id)
                  [ <a href="{{url('/teacherProfile/'.$profile['id'].'/edit')}}">Edit</a> ]
                  @endif
                </div>

                <div class="panel-body">
                  <ul class="list-group">
                    <li class="list-group-item"><strong>First Name:</strong> {{ $profile->fname }}</li>
                    <li class="list-group-item"><strong>Last Name:</strong> {{ $profile->lname }}</li>
                    <li class="list-group-item"><strong>Gender:</strong> {{ $profile->gender }}</li>
                    <li class="list-group-item"><strong>Skype ID:</strong> {{ $profile->skype }}</li>
                    <li class="list-group-item"><strong>Contact #:</strong> {{ $profile->contact }}</li>
                    <li class="list-group-item"><strong>Home Address:</strong> {{ $profile->address }}</li>
                  </ul>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Educational Background
                  @if (Auth::check() && $profile->user_id === Auth::user()->id)
                    [ <a href="{{url('/teacherEducation/create')}}">Add</a> ]
                  @endif
                </div>
                <div class="panel-body">
                @foreach ($educations as $v)
                  <ul class="list-group">
                    <li class="list-group-item">School Name: {{ $v->school_name }}</li>
                    <li class="list-group-item">Degree: {{ $v->degree }}</li>
                    <li class="list-group-item">Description: {{ $v->description }}</li>
                    @if (Auth::check() && $profile->user_id === Auth::user()->id)
                    <li class="list-group-item">
                      <form action="{{ url('/teacherEducation/'.$v->id) }}" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        [ <a href="{{ url('/teacherEducation/'.$v->id.'/edit') }}">Edit</a> ]
                        [ <a class="text-danger" href="javascript:void(0)" onclick="$(this).closest('form').submit()">Delete</a> ]
                      </form>
                    </li>
                    @endif
                  </ul>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
