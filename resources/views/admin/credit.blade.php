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
                  @if($v->charged == 0 && $v->status == 1)
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading{{$v->id}}">
                      REQUEST # OF LESSONS: <span class="text-underlined">{{$v->quantity}}</span>
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
                  @endif
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
                  @if($v->charged == 1 && $v->status == 1)
                  <li class="list-group-item">
                    <strong># of Credits: <span class="text-underlined">{{$v->quantity}}</span></strong> ({{$v->modify_date != null? $v->modify_date->diffForHumans() : "Date - untraced"}})
                    <br/><strong>Name:</strong> {{$v->fname}} {{$v->lname}} ({{$v->email}})
                    <br/><strong>Activated by:</strong> {{$v->activated_by != null ? "ADMIN ".$common->getAdmin($v->activated_by)->fname." ".$common->getAdmin($v->activated_by)->lname : "Credited to STUDENT DEPOSIT"}}
                  </li>
                  @endif
                @endforeach
              </ul>
            </div>
          </div>

          <!-- Disabled TODO -->

          @endif

        </div>
    </div>
</div>
@endsection
