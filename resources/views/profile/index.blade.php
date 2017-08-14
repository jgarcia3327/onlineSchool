@extends('layouts.app')

@section('title')
  Profile
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">My Profile
                  @if (Auth::check() && $profile['user_id'] === Auth::user()->id)
                  [ <a href="{{url('/profile/'.$profile['id'].'/edit')}}">Edit</a> ]
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
        </div>
    </div>
</div>
@endsection
