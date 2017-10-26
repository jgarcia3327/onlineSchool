@extends('layouts.app')

@section('title', "Admin Dashboard - English Hours")

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

          <!-- Payment -->
          <div class="panel panel-default">
              <div class="panel-heading">{{ config('app.name') }} Payment</div>
              <div class="panel-body">
                  <div class="row">
                    <div class="col-md-3">
                      <a class="text-center" title="Activate paid credits" href="{{ url('/adminCredit') }}">
                       <span class="fa fa-ticket fa-3x admin-link"></span>
                       <span class="admin-link">Activate Student Credit Lessons</span>
                      </a>
                    </div>
                    <div class="col-md-3">
                      <!-- TODO <a class="text-center" title="Activate paid credits" href="{{ url('/adminTeacherSalary') }}">
                       <span class="fa fa-clock-o fa-3x admin-link"></span>
                       <span class="admin-link">Teacher Salary</span>
                     </a> -->
                      <!-- Deposit - deprecated -->
                      <!-- <a class="text-center" title="Activate paid credits" href="{{ url('/adminDeposit') }}">
                       <span class="fa fa-money fa-3x admin-link"></span>
                       <span class="admin-link">Activate Student Deposits</span>
                      </a> -->
                    </div>
                    <div class="col-md-3">
                      <!-- Additiona admin feature -->
                    </div>
                    <div class="col-md-3">
                      <!-- Additional admin feature -->
                    </div>
                  </div>
              </div>
          </div>

          <!-- Miscellaneous  -->
          <div class="panel panel-default">
            <div class="panel-heading">{{ config('app.name') }} Miscellaneous</div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3">
                  <a class="text-center" title="Upload pdf books" href="{{ url('/books') }}">
                   <span class="fa fa-book fa-3x admin-link"></span>
                   <span class="admin-link">Upload Books</span>
                  </a>
                </div>
                <div class="col-md-3">
                  <a class="text-center" title="Read and reply to feedback" href="{{ url('/adminFeedback') }}">
                   <span class="fa fa-meh-o fa-3x admin-link"></span>
                   <span class="admin-link">User Feedback</span>
                  </a>
                </div>
                <div class="col-md-3">
                  <a class="text-center" title="Activate paid credits" href="{{ url('/adminStudent') }}">
                   <span class="fa fa-group fa-3x admin-link"></span>
                   <span class="admin-link">List of Student</span>
                  </a>
                </div>
                <div class="col-md-3">
                  <a class="text-center" title="Activate paid credits" href="{{ url('/adminScheduleList') }}">
                   <span class="fa fa-tasks fa-3x admin-link"></span>
                   <span class="admin-link">List of Schedules</span>
                  </a>
                </div>
              </div>
            </div>
          </div>

        </div>
    </div>
</div>
@endsection
