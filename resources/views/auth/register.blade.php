@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>ĐĂNG KÝ</h3></div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Địa chỉ Email<!--E-Mail Address--></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" placeholder="Địa chỉ Email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Mật khẩu<!--Password--></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Mật khẩu" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Viết lại mật khẩu<!--Confirm Password--></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Viết lại mật khẩu" required>
                            </div>
                        </div>


                        <div class="form-group">
                          <label for="fname" class="col-md-4 control-label">Tên<!--First Name--></label>
                          <div class="col-md-6">
                            <input type="text" class="form-control" id="fname" name="fname" placeholder="Tên" value="{{ old('fname') }}" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="lname" class="col-md-4 control-label">Họ<!--Last Name--></label>
                          <div class="col-md-6">
                            <input type="text" class="form-control" id="lname" name="lname" placeholder="Họ" value="{{ old('lname') }}" required>
                          </div>
                        </div>
                        <div class="form-group">
                        <label for="gender" class="col-md-4 control-label">Giới tính<!--Gender--></label>
                        <div class="col-md-6">
                          <select class="form-control" id="gender" name="gender">
                            <option value="male" {{ old('gender') == 'male'? "selected" : "" }}>Nam<!--Male--></option>
                            <option value="female" {{ old('gender') == 'female'? "selected" : "" }} >Nữ<!--Female--></option>
                          </select>
                        </div>
                        </div>
                        <div class="form-group">
                          <label for="skype" class="col-md-4 control-label">Skype ID</label>
                          <div class="col-md-6">
                            <input type="text" class="form-control" id="skype" name="skype" placeholder="Skype ID" value="{{ old('skype') }}" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="contact" class="col-md-4 control-label">Số điện thoại<!--Contact--></label>
                          <div class="col-md-6">
                            <input type="text" class="form-control" id="contact" name="contact" placeholder="Số điện thoại" value="{{ old('contact') }}" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="address" class="col-md-4 control-label">Địa chỉ nhà<!--Home Address--></label>
                          <div class="col-md-6">
                           <textarea class="form-control" id="address" name="address" placeholder="Địa chỉ nhà" rows="2" required>{{ old('address') }}</textarea>
                          </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Đăng kí
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
