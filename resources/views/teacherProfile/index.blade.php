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
        <div class="text-center profile-photo">
          @if(Auth::check() && $profile->photo != null)
          <img src="{{ asset('images/profile/') }}/{{ $profile->photo }}"/>
          @else
          <img src="{{ asset('images/profile/default_') }}{{ $profile->gender }}.png"/>
          @endif
          @if (Auth::check() && $profile->user_id === Auth::user()->id)
            <p class="text-center">
              <span class="photo-change btn btn-default">Change Photo</span>
              <form class="photo-form" action="{{ url('/teacherProfile/'.$profile->id) }}" method="post" enctype="multipart/form-data" style="display: none;">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <input type="file" name="photo" id="photo">
                <input type="submit" class="btn btn-primary" disabled >
                <span class="photo-cancel btn btn-default">Cancel</span>
              </form>
            </p>
          @endif
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="text-center profile-audio">
        @if($profile->audio != null)
        <audio controls>
          <source src="{{ asset('audio/').'/' }}{{ $profile->user_id }}.ogg" type="audio/ogg">
          <source src="{{ asset('audio/').'/' }}{{ $profile->user_id }}.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
        </audio>
        @else
        <p class="text-center">No Audio uploaded</p>
        @endif
        @if (Auth::check() && $profile->user_id === Auth::user()->id)
          <p class="text-center">
            <span class="audio-change btn btn-default">Change Audio</span>
            <form class="audio-form" action="{{ url('/teacherProfile/'.$profile->id) }}" method="post" enctype="multipart/form-data" style="display: none;">
              {{ method_field('PUT') }}
              {{ csrf_field() }}
              <input type="file" name="audio" id="audio">
              <input type="submit" class="btn btn-primary" disabled >
              <span class="audio-cancel btn btn-default">Cancel</span>
            </form>
          </p>
        @endif
      </div>
      <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">My Profile
                  @if (Auth::check() && $profile->user_id === Auth::user()->id)
                  [ <a href="{{url('/teacherProfile/'.$profile['id'].'/edit')}}">Edit</a> ]

                  <!-- change-password -->
                  [ <a href="#" data-toggle="collapse" data-target="#change-password">Change Password</a> ]
                  @if (session('success') == 1)
                  <span class="help-block">
                      <strong class="text-success">Password changed successfully.</strong>
                  </span>
                  @endif
                  @if ($errors->has('current_password'))
                  <span class="help-block">
                      <strong class="text-danger">Current password did not match.</strong>
                  </span>
                  @endif
                  @if ($errors->has('new_password'))
                  <span class="help-block">
                      <strong class="text-danger">New password error. <br/>Password should have 6 characters mininum. <br/>New password and confirm password should match.</strong>
                  </span>
                  @endif
                  <div id="change-password" class="collapse">
                    <form class="form-horizontal" action="{{ url('/profile/'.$profile->id) }}" method="post">
                      {{ method_field('PUT') }}
                      {{ csrf_field() }}
                      <div class="form-group">
                          <label for="old-password" class="col-md-4 control-label">Current Password</label>
                          <div class="col-md-6">
                              <input id="old-password" type="password" class="form-control" name="current_password" required>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="password" class="col-md-4 control-label">New Password</label>
                          <div class="col-md-6">
                              <input id="password" type="password" class="form-control" name="new_password" required>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="confirm-password" class="col-md-4 control-label">Confirm New Password</label>
                          <div class="col-md-6">
                              <input id="confirm-password" type="password" class="form-control" name="new_password_confirmation" required>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="password" class="col-md-4 control-label"></label>
                          <div class="col-md-6">
                              <input type="submit" class="btn btn-primary" value="Change Password" >
                          </div>
                      </div>
                    </form>
                  </div><!-- end change-password -->

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
                    <li class="list-group-item"><strong>ESL Experience:</strong> {{ $profile->esl_experience }}</li>
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
                    <li class="list-group-item">Date: {{ $common->getMonthStr(date('m', strtotime($v->start_date))) }} {{ date('Y', strtotime($v->start_date)) }} to {{ $common->getMonthStr(date('m', strtotime($v->end_date))) }} {{ date('Y', strtotime($v->end_date)) }}</li>
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

@section('javascript')
<script type="text/javascript" src="{{ asset('js/teacher-index.js') }}"></script>
@endsection
