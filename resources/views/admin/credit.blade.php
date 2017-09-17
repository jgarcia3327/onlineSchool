@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

          @if ($auth->is_admin == 1)
          <!-- Pending -->
          <div class="panel panel-default">
              <div class="panel-heading"><strong>Activate Pending Credits</strong></div>
              <div class="panel-body">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  @foreach($buyCredits AS $v)
                  <?php if($v->status != 0) continue; ?>
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading{{$v->id}}">
                      <p>
                        <strong class="text-default credit-num">{{$v->email}}</strong>
                        {{$v->quantity}} credits.
                        <a class="btn btn-primary" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$v->id}}" aria-expanded="true" aria-controls="collapse{{$v->id}}">
                          Activate
                        </a>
                      </p>
                    </div>
                    <div id="collapse{{$v->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$v->id}}">
                      <div class="panel-body">
                        <form action="{{ url('/scheduleCredit/'.$v->id) }}" method="POST">
                          {{ method_field('PUT') }}
                          {{ csrf_field() }}
                          <input class="btn btn-warning" type="submit" value="Confirm Activation" />
                        </form>
                        <span class="text-danger">*Once activated, it cannot be undo.</span>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
          </div>

          <!-- Activated -->
          <div class="panel panel-default">
            <div class="panel-heading"><strong>Activated Credits</strong></div>
            <div class="panel-body">
              <ul class="list-group">
                @foreach($buyCredits AS $v)
                  <?php if($v->status != 1) continue; ?>
                  <li class="list-group-item">{{$v->email}} | credits: {{$v->quantity}} | activated {{$v->modify_date->diffForHumans()}}</li>
                @endforeach
              </ul>
            </div>
          </div>
          @endif

        </div>
    </div>
</div>
@endsection
