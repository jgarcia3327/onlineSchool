@extends('layouts.app')

@section('content')
<div class="col-md-4 col-md-offset-4">
  <h3>Edit profile</h3>
  <form action="{{ url('/teacherProfile/'.$profile->id) }}" method="POST">
    {{ method_field('PUT') }}
    {{ csrf_field() }}
    <input type="hidden" name="user_id" value="{{ $profile->user_id }}"/>
    <div class="form-group">
      <label for="fname">First Name</label>
      <input type="text" class="form-control" id="fname" name="fname" value="{{$profile['fname']}}" placeholder="First Name" required>
    </div>
    <div class="form-group">
      <label for="lname">Last Name</label>
      <input type="text" class="form-control" id="lname" name="lname" value="{{$profile['lname']}}" placeholder="Last Name" required>
    </div>
    <div class="form-group">
    <label for="gender">Gender</label>
    <select class="form-control" id="gender" name="gender">
      <option value="male" {{$profile['gender']=='male'? 'selected' : '' }}>Male</option>
      <option value="female" {{$profile['gender']=='female'? 'selected' : '' }}>Female</option>
    </select>
    </div>
    <div class="form-group">
      <label for="skype">Skype ID</label>
      <input type="text" class="form-control" id="skype" name="skype" value="{{$profile['skype']}}" placeholder="Skype ID" required>
    </div>
    <div class="form-group">
      <label for="contact">Contact</label>
      <input type="text" class="form-control" id="contact" name="contact" value="{{$profile['contact']}}" placeholder="Contact Number" required>
    </div>
    <div class="form-group">
      <label for="address">Home Address</label>
      <textarea class="form-control" id="address" name="address" rows="2" required>{{$profile['address']}}</textarea>
    </div>
    <!--
    <div class="form-group">
    <label for="gender">Country</label>
    <select class="form-control" id="country" name="country">
      <?php $country = empty($profile['country'])? "VN" :  $profile['country']; ?>
      @foreach ($common->getCountries() as $k => $v)
      <option value="{{$k}}" {{ $country==$k? 'selected' : '' }}>{{$v}}</option>
      @endforeach
    </select>
    </div> -->
    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Submit">
      <a href="{{url('/teacherProfile')}}" class="btn btn-default">Cancel</a>
    </div>

  </form>
</div>
@endsection
