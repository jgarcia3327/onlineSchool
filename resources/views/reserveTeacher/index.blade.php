@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Teachers</div>

                <div class="panel-body">
                  <div class="row text-center">
                  <?php $counter = 0; ?>
                  @foreach($teachers AS $v)
                    <div class="col-md-4 profile-photo">
                      <a href="{{ url('reserveTeacher/'.$v->user_id) }}">
                      @if(Auth::check() && $v->photo != null)
                      <img src="{{ asset('images/profile/') }}/{{ $v->photo }}"/>
                      @else
                      <img src="{{ asset('images/profile/default_') }}{{ $v->gender }}.png"/>
                      @endif
                      </a>
                      <a href="{{ url('reserveTeacher/'.$v->user_id) }}">{{ $v->fname }} {{ $v->lname }}</a>
                    </div>
                    <?php $counter++; ?>
                    @if ($counter % 3 == 0)
                      </div>
                      <div class="row text-center">
                    @endif
                  @endforeach
                  <?php $remaining = 3 - ($counter % 3); ?>
                  @if($remaining != 3)
                    @for($i = 0; $i < $remaining; $i++)
                      <div class="col-md-4">&nbsp;</div>
                    @endfor
                  @endif
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
