@extends('layouts.app')

@section('title')
  Profile
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

          <!-- Credits -->
          <div class="panel panel-default">
              <div class="panel-heading">Schedule Credits
                @if (Auth::check() && $profiles[0]->user_id === Auth::user()->id)
                [ <a href="{{url('/scheduleCredit')}}">Buy credits</a> ]
                @endif
              </div>

              <div class="panel-body">
                  Credits: <strong>{{ $profiles[2] }}</strong>
              </div>
          </div>

          <!-- My profile -->
            <div class="panel panel-default">
                <div class="panel-heading">
                  @if (Auth::check() && $profiles[0]->user_id === Auth::user()->id)
                  My Profile [ <a href="{{url('/profile/'.$profiles[0]->id.'/edit')}}">Edit</a> ]

                  <!-- change-password -->
                  [ <a href="javascript:void(0)" data-toggle="collapse" data-target="#change-password">Change Password</a> ]
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
                    <form class="form-horizontal" action="{{ url('/profile/'.$profiles[0]->id) }}" method="post">
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
                              <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#change-password">Cancel</button>
                          </div>
                      </div>
                    </form>
                  </div><!-- end change-password -->
                  @else
                  {{ $profiles[0]->fname }} {{ $profiles[0]->lname }} - Profile
                  @endif
                </div>

                <div class="panel-body">
                  <ul class="list-group">
                    <li class="list-group-item"><strong>First Name:</strong> {{ $profiles[0]->fname }}</li>
                    <li class="list-group-item"><strong>Last Name:</strong> {{ $profiles[0]->lname }}</li>
                    <li class="list-group-item"><strong>Gender:</strong> {{ $profiles[0]->gender }}</li>
                    <li class="list-group-item"><strong>Skype ID:</strong> {{ $profiles[0]->skype }}</li>
                    <li class="list-group-item"><strong>Contact #:</strong> {{ $profiles[0]->contact }}</li>
                    <li class="list-group-item"><strong>Home Address:</strong> {{ $profiles[0]->address }}</li>
                  </ul>
                </div>
            </div>

            <!-- Site Feedback -->
            @if (Auth::check() && $profiles[0]->user_id === Auth::user()->id)
            <div class="panel panel-default">
                <div class="panel-heading">My Feedback
                  [ <a href="javascript:void(0)" data-toggle="collapse" data-target="#create-feedback">Create {{config('app.name')}} feedback</a> ]
                  @if (!empty(session('successFeedback')))
                  <span class="help-block">
                      <strong class="text-success">{{ session('successFeedback') }}</strong>
                  </span>
                  @endif
                </div>

                <div class="panel-body">
                  <!-- create-feedback -->
                  <div id="create-feedback" class="collapse">
                    <form class="form-horizontal" action="{{ url('/feedback/') }}" method="post">
                      {{ csrf_field() }}
                      <div class="form-group">
                          <label for="feedback-remark" class="col-md-4">Feedback to {{ config('app.name') }}</label>
                          <div class="col-md-12">
                              <textarea id="feedback-remark" class="form-control" name="remark" required></textarea>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label"></label>
                          <div class="col-md-12">
                              <input type="submit" class="btn btn-primary" value="Submit Feedback" >
                              <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#create-feedback">Cancel</button>
                          </div>
                      </div>
                    </form>
                  </div>
                  <!-- End create-feedback -->

                  <!-- List of feedbacks -->
                  <ul class="list-group">
                    @foreach($profiles[3] AS $v)
                    <li class="list-group-item"><a href="javascript:void(0)" data-toggle="collapse" data-target="#feedback{{$v->id}}"> {{ substr($v->remark,0,60) }}{{strlen($v->remark) > 60? '...' : ''}}</a>  <span class="badge">{{ $v->create_date->diffForHumans() }}</span>
                      <div id="feedback{{$v->id}}" class="collapse">
                        <ul class="list-group">
                          <li class="list-group-item">{{ $v->remark }}</li>
                          <li class="list-group-item bg-info">{!! $v->reply === null? '<i>No reply yet from '.config('app.name').'</i>' : $v->reply !!}</li>
                        </ul>
                      </div>
                    </li>
                    @endforeach
                  </ul>
                  <!-- end list of feedbacks -->
                </div>
            </div>
            @endif
            <!-- end site feedback -->

            <!-- History -->
            <div class="panel panel-default">
                <div class="panel-heading">History</div>

                <div class="panel-body">
                  <table class="table striped">
                    <thead>
                      <tr>
                        <th>Date/Time</th>
                        <th>Teacher</th>
                        <th>Memo</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $counter=0; ?>
                      @foreach($profiles[1] AS $v)
                      <tr>
                        <td>{{ $common->getFormattedDateTimeRange($v->date_time) }}</td>
                        <td>{{ $v->fname }} {{ $v->lname }}</td>
                        <td>
                          @if ($v->called == null)
                          <i class="text-danger">Missed Session</i>
                          @elseif ($v->memo == null)
                          <i class="text-warning">No Memo provided</i>
                          @else
                          Memo: {{ $v->memo }}<br/>Book: {{ $v->memo_book }}<br/>Next Page: {{ $v->memo_next_page }}
                          @endif
                        </td>
                      </tr>
                      <?php $counter++; ?>
                      @endforeach
                    </tbody>
                  </table>
                  <?php //LOAD MORE TODO ?>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
