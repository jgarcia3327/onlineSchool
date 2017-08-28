@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

          @if ($auth->is_student == 1)
            <div class="panel panel-default">
                <div class="panel-heading"><strong>My Credits</strong></div>

                <div class="panel-body">
                    <p>You have <strong>{{ $credits[0] }}</strong> credit{{ $credits[0] > 1 ? "s":"" }} left.</p>
                    @if (session('success') > 0)
                    <span class="help-block">
                        <strong class="text-success">Thank you for purchase. <br/>Please transfer {{session('success')}} USD to ... with comment <strong>"{{$auth->email}} Credit Payment"</strong> to activate your credits.</strong>
                    </span>
                    @endif
                    @if(count($credits[1]) > 0)
                    @foreach($credits[1] AS $pending)
                    <p class="text-warning"><strong>Pending:</strong> {{$pending->quantity}} credits, purchased {{$pending->create_date->diffForHumans()}}</p>
                    @endforeach
                    @endif
                </div>
            </div>

            <!-- Buy Credits -->
            <div class="panel panel-default">
                <div class="panel-heading">Buy Credits</h3></div>

                <div class="panel-body">
                  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                          <strong class="text-default credit-num">10</strong>
                          Consumable for 2-weeks
                          <a class="btn btn-primary" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <span class="fa fa-shopping-cart"></span> Buy
                          </a>
                        </h4>
                      </div>
                      <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                          <form action="{{ url('/scheduleCredit') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="quantity" value="10" />
                            <input class="btn btn-warning" type="submit" value="Confirm to buy 10 credits" />
                          </form>
                          <span class="text-danger">*Afer pressing confirm, please transfer {{10*2}} USD to ... with comment <strong>"{{$auth->email}} Credit Payment"</strong> to activate your credits.</span>
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                          <strong class="text-warning credit-num">15</strong>
                          Consumable for 3-weeks
                          <a class="collapsed btn btn-primary" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <span class="fa fa-shopping-cart"></span> Buy
                          </a>
                        </h4>
                      </div>
                      <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                          <form action="{{ url('/scheduleCredit') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="quantity" value="15" />
                            <input class="btn btn-warning" type="submit" value="Confirm to buy 15 credits" />
                          </form>
                          <span class="text-danger">*Afer pressing confirm, please transfer {{15*2}} USD to ... with comment <strong>"{{$auth->email}} Credit Payment"</strong> to activate your credits.</span>
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                          <strong class="text-danger credit-num">20 + 2</strong>
                          Consumable for 1 month
                          <a class="collapsed btn btn-primary" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <span class="fa fa-shopping-cart"></span> Buy
                          </a>
                        </h4>
                      </div>
                      <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                          <form action="{{ url('/scheduleCredit') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="quantity" value="20" />
                            <input class="btn btn-warning" type="submit" value="Confirm to buy 20 credits" />
                          </form>
                          <span class="text-danger">*Afer pressing confirm, please transfer {{20*2}} USD to ... with comment <strong>"{{$auth->email}} Credit Payment"</strong> to activate your credits.</span>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
            </div>
          @endif

          @if ($auth->is_admin == 1)
          <!-- Pending -->
          <div class="panel panel-default">
              <div class="panel-heading"><strong>Activate Pending Credits</strong></div>
              <div class="panel-body">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  @foreach($credits[2] AS $v)
                  <?php if($v->status != 0) continue; ?>
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading{{$v->id}}">
                      <h4 class="panel-title">
                        <strong class="text-default credit-num">{{$v->email}}</strong>
                        {{$v->quantity}} credits, Consumable for 2-weeks
                        <a class="btn btn-primary" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$v->id}}" aria-expanded="true" aria-controls="collapse{{$v->id}}">
                          Activate
                        </a>
                      </h4>
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
                @foreach($credits[2] AS $v)
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
