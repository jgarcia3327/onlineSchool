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
                  @foreach($teachers AS $k => $v)
                    <div class="col-md-4">
                      <a href="{{ url('reserveTeacher/'.$k) }}">{{ $v }}</a>
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
