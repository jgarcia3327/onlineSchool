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
                      <a class="text-center" title="Teacher Salary" href="{{ url('/adminTeacherSalary') }}">
                       <span class="fa fa-money fa-3x admin-link"></span>
                       <span class="admin-link">Teacher Salary</span>
                      </a>
                      <!-- Deposit - deprecated -->
                      <!-- <a class="text-center" title="Activate paid credits" href="{{ url('/adminDeposit') }}">
                       <span class="fa fa-money fa-3x admin-link"></span>
                       <span class="admin-link">Activate Student Deposits</span>
                      </a> -->
                    </div>
                    <div class="col-md-3">
                      <a class="text-center" title="Add Student credits" href="{{ url('/adminAddCredit') }}">
                       <span class="fa fa-arrow-circle-down fa-3x admin-link"></span>
                       <span class="admin-link">Add Student Credit Lessons</span>
                      </a>
                    </div>
                    <div class="col-md-3">
                      <a class="text-center" title="Schedule Editor" href="{{ url('/adminScheduleEditor') }}">
                       <span class="fa fa-calendar fa-3x admin-link"></span>
                       <span class="admin-link">Schedule Editor</span>
                     </a>
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
              <br/>
              <div class="row">
                <div class="col-md-3">
                  <a class="text-center" title="Student Credit Details" href="{{ url('/adminCreditDetails') }}">
                   <span class="fa fa-clipboard fa-3x admin-link"></span>
                   <span class="admin-link">Student Credit Details</span>
                  </a>
                </div>
                <div class="col-md-3">
                  <!-- feature here -->
                </div>
                <div class="col-md-3">
                  <!-- feature here -->
                </div>
                <div class="col-md-3">
                  <!-- feature here -->
                </div>
              </div>

            </div>

          </div>

        </div>
    </div>
</div>
@endsection
