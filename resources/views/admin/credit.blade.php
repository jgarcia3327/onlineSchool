@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

          @if ($auth->is_admin == 1)
          <!-- Pending -->
          <div class="panel panel-default">
              <div class="panel-heading"><strong>ACTIVATE STUDENT CREDIT LESSIONS</strong></div>
              <div class="panel-body">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  @foreach($buyCredits AS $v)
                  <?php if($v->status != 0) continue; ?>
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading{{$v->id}}">
                      Lesson Credits: {{$v->quantity}}
                    </div>
                    <div class="panel-body">
                      <ul class="list-group">
                        <li class="list-group-item"><strong>Name:</strong> {{$v->fname}} {{$v->lname}}</li>
                        <li class="list-group-item"><strong>Email:</strong> {{$v->email}}</li>
                        <li class="list-group-item"><strong>Date Filed:</strong> {{$v->create_date}} <i class="text-default"> - {{$v->create_date->diffForHumans()}}</i></li>
                        <li class="list-group-item"><a class="btn btn-primary" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$v->id}}" aria-expanded="true" aria-controls="collapse{{$v->id}}">
                          Activate
                        </a></li>
                      </ul>
                      <div id="collapse{{$v->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$v->id}}">
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
            <div class="panel-heading"><strong>ACTIVATED CREDITS</strong></div>
            <div class="panel-body">
              <ul class="list-group">
                @foreach($buyCredits AS $v)
                  <?php if($v->status != 1) continue; ?>
                  <li class="list-group-item">
                    @if($v->charged == 0)
                      <strong class="text-danger">*Activated by Admin</strong>
                    @endif
                    <strong>Credits: {{$v->quantity}}</strong>
                    <br/>Name: {{$v->fname}} {{$v->lname}} ({{$v->email}}) | Activated {{$v->modify_date->diffForHumans()}}</li>
                @endforeach
              </ul>
            </div>
          </div>
          @endif

        </div>
    </div>
</div>
@endsection
