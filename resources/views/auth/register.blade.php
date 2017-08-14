@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Student Registration</h3></div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>


                        <div class="form-group">
                          <label for="fname" class="col-md-4 control-label">First Name</label>
                          <div class="col-md-6">
                            <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="lname" class="col-md-4 control-label">Last Name</label>
                          <div class="col-md-6">
                            <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" required>
                          </div>
                        </div>
                        <div class="form-group">
                        <label for="gender" class="col-md-4 control-label">Gender</label>
                        <div class="col-md-6">
                          <select class="form-control" id="gender" name="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                          </select>
                        </div>
                        </div>
                        <div class="form-group">
                          <label for="skype" class="col-md-4 control-label">Skype ID</label>
                          <div class="col-md-6">
                            <input type="text" class="form-control" id="skype" name="skype" placeholder="Skype ID" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="contact" class="col-md-4 control-label">Contact</label>
                          <div class="col-md-6">
                            <input type="text" class="form-control" id="contact" name="contact" placeholder="Contact Number" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="address" class="col-md-4 control-label">Home Address</label>
                          <div class="col-md-6">
                           <textarea class="form-control" id="address" name="address" rows="2" required></textarea>
                          </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
