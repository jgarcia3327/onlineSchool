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
                <div class="panel-heading">My Profile
                  @if (Auth::check() && $profiles[0]->user_id === Auth::user()->id)
                  [ <a href="{{url('/profile/'.$profiles[0]->id.'/edit')}}">Edit</a> ]

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
                          </div>
                      </div>
                    </form>
                  </div><!-- end change-password -->


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
