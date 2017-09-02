@extends('layouts.app')

@section('title')
  Lesson Scheduler
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <!-- Calendar for selecting a day -->
            <div class="panel panel-default">
                <div class="panel-heading">
                  <div class="text-center profile-photo sched-photo">
                    @if(Auth::check() && $reservations[0]->photo != null)
                    <img src="{{ asset('images/profile/') }}/{{ $reservations[0]->photo }}"/>
                    @else
                    <img src="{{ asset('images/profile/default_') }}{{ $reservations[0]->gender }}.png"/>
                    @endif
                  </div>
                  <h3 class="text-center">
                  {{ $reservations[0]->fname }} {{ $reservations[0]->lname }}
                  <span>[ <a href="{{url('/teacherProfile/'.$reservations[0]->user_id)}}">view profile</a> ]</span>
                  </h3>
                <div class="text-center profile-audio">
                @if($reservations[0]->audio != null)
                <audio controls>
                  <source src="{{ asset('audio/').'/' }}{{ $reservations[0]->user_id }}.ogg" type="audio/ogg">
                  <source src="{{ asset('audio/').'/' }}{{ $reservations[0]->user_id }}.mp3" type="audio/mpeg">
                Your browser does not support the audio element.
                </audio>
                @else
                <span class="text-center">No Audio uploaded</span>
                @endif
                </div>
              </div>
                <div class="panel-body">
                  <div class="col-md-8 col-md-offset-2">
                    <div id="datepicker"></div>
                  </div>
                </div>
            </div>

            <div class="panel panel-default">
              <div class="panel-heading">
                <strong>Credits: {{ $reservations[1] }}</strong> | [ <a href="{{ url('/scheduleCredit') }}">My Credits</a> ]
                @if (session('success') == -1)
                <span class="help-block">
                    <strong class="text-danger">You don't have enough credits on your selected schedules.</strong><br/>
                    <strong class="text-danger">Please select number of schedules within your credits.</strong>
                </span>
                @endif
              </div>
              <div class="panel-body">
                <div id="selected-sched">
                <i class="text-danger none-selected">No schedule selected</i>
                </div>
                <span class="span-row pull-right"><button onclick="$('form#create-schedule').submit()" type="submit" class="btn btn-primary" id="submit-selected" disabled>Reserve</button></span>
              </div>
            </div>

            <p class="loader text-center"><img src="{{ asset('images/ajax-loader.gif') }}"/></p>

            <form id="create-schedule" action="/reserveTeacher/{{ $reservations[0]->user_id }}" method="POST">
              {{ method_field('PUT') }}
              {{ csrf_field() }}
            <div id="available-time"></div>

          </form>

        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript" src="{{ asset('js/schedule-teacher.js') }}"></script>
@endsection
