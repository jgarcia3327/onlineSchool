@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ config('app.name') }} Administration</div>

                <div class="panel-body">
                    <div class="row">
                      <div class="col-md-3">
                        <a class="text-center" title="Activate paid credits" href="{{ url('/adminDeposit') }}">
                         <span class="fa fa-money fa-3x admin-link"></span>
                         <span class="admin-link">Activate Student Deposits</span>
                        </a>
                      </div>
                      <!-- Deprecated with deposit functionality
                      <div class="col-md-3">
                        <a class="text-center" title="Activate paid credits" href="{{ url('/adminCredit') }}">
                         <span class="fa fa-barcode fa-3x admin-link"></span>
                         <span class="admin-link">Activate Student Credit Lessons</span>
                        </a>
                      </div>
                      -->
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
                        <!-- Additional admin stuff here... -->
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
