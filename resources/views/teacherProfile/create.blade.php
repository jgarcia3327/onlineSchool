@extends('layouts.app')

@section('content')
<div class="col-md-4 col-md-offset-4">
  <h3>More information to my profile</h3>
  <form action="{{ url('/teacherProfile') }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="user_id" />
    <div class="form-group">
      <label for="fname">First Name</label>
      <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" required>
    </div>
    <div class="form-group">
      <label for="lname">Last Name</label>
      <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" required>
    </div>
    <div class="form-group">
    <label for="gender">Gender</label>
    <select class="form-control" id="gender" name="gender">
      <option value="male">Male</option>
      <option value="female">Female</option>
    </select>
    </div>
    <div class="form-group">
      <label for="skype">Skype ID</label>
      <input type="text" class="form-control" id="skype" name="skype" placeholder="Skype ID" required>
    </div>
    <div class="form-group">
      <label for="contact">Contact</label>
      <input type="text" class="form-control" id="contact" name="contact" placeholder="Contact Number" required>
    </div>
    <div class="form-group">
      <label for="address">Home Address</label>
      <textarea class="form-control" id="address" name="address" rows="2" required></textarea>
    </div>
    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Submit">
    </div>

  </form>
</div>
@endsection
