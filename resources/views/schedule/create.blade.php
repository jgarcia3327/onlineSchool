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
                <div class="panel-heading">Select Day</div>
                <div class="panel-body">
                  <div class="col-md-8 col-md-offset-2">
                    <div id="datepicker"></div>
                  </div>
                </div>
            </div>

            <div class="panel panel-default">
              <div class="panel-heading">
                <span class="text-error">
                  *You can select several days to be added-up to your selected schedules.
                  <br/>*Selected schedule will be partially saved when moving/selecting other day for a batch submission of schedules.
                </span>
              </div>
              <div class="panel-body">
                <div class="">
                  Selected Schedule: <strong class="selected-sched-count">0</strong> [ <a href="javascript:showSched()" class="view-hide">View</a> ]
                </div>
                <div id="selected-sched" style="display: none;">
                <i class="text-danger none-selected">No schedule selected</i>
                </div>
                <span class="span-row pull-right">
                  <button onclick="$('form#create-schedule').submit()" type="submit" class="btn btn-primary" id="submit-selected" disabled>Submit</button>
                  <!-- <a href="{{url('schedule/create')}}" class="btn btn-warning">Cancel</a> -->
                </span>
              </div>
            </div>

            <p class="loader text-center"><img src="{{ asset('images/ajax-loader.gif') }}"/></p>

            <form id="create-schedule" action="/schedule" method="POST">
              {{ csrf_field() }}
            <div id="available-time"></div>

          </form>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript" src="{{ asset('js/schedule-create.js') }}"></script>
@endsection
