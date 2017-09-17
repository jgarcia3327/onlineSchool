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
                        <strong class="text-success">Thank you for your purchase.
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

                    <!-- Option 1 -->
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingOne">
                          <p><strong class="text-default credit-num">10</strong> Consumable for 30 Days. </p>
                          <p>3.75 USD/LESSON (TOTAL = $37.50 USD)</p>
                          <p>
                          <a class="btn btn-primary" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <span class="fa fa-shopping-cart"></span> Buy
                          </a>
                        </p>
                      </div>
                      <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                          <form action="{{ url('/scheduleCredit') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="quantity" value="10" />
                            <input class="btn btn-warning" type="submit" value="Confirm to buy 10 credits" />
                          </form>
                          <span class="text-danger">*Afer pressing confirm, please pay <strong>$37.50 USD</strong> <!-- <strong>"{{$auth->email}} Credit Payment"</strong> --> to activate your requested credits.</span>
                        </div>
                      </div>
                    </div>

                    <!-- Option 2 -->
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingTwo">
                        <p>
                          <strong class="text-warning credit-num">20</strong>
                          Consumable for 60 Days.
                        <p>
                        <p>3.60 USD/LESSON (TOTAL = $72.00 USD)</p>
                        <p><a class="collapsed btn btn-primary" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <span class="fa fa-shopping-cart"></span> Buy
                          </a>
                        </p>
                      </div>
                      <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                          <form action="{{ url('/scheduleCredit') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="quantity" value="20" />
                            <input class="btn btn-warning" type="submit" value="Confirm to buy 20 credits" />
                          </form>
                          <span class="text-danger">*Afer pressing confirm, please pay <strong>$72.00 USD</strong> <!-- <strong>"{{$auth->email}} Credit Payment"</strong> --> to activate your requested credits.</span>
                        </div>
                      </div>
                    </div>

                    <!-- Option 3 -->
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingThree">
                        <p>
                          <strong class="text-danger credit-num">30</strong>
                          Consumable for 90 Days.
                        </p>
                        <p>3.40 USD/LESSON (TOTAL = $102.00 USD)</p>
                        <p>
                          <a class="collapsed btn btn-primary" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <span class="fa fa-shopping-cart"></span> Buy
                          </a>
                        </p>
                      </div>
                      <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                          <form action="{{ url('/scheduleCredit') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="quantity" value="30" />
                            <input class="btn btn-warning" type="submit" value="Confirm to buy 30 credits" />
                          </form>
                          <span class="text-danger">*Afer pressing confirm, please pay <strong>$102.00 USD</strong> <!-- <strong>"{{$auth->email}} Credit Payment"</strong> --> to activate your requested credits.</span>
                        </div>
                      </div>
                    </div>

                    <!-- Option 4 -->
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingFour">
                        <p>
                          <strong class="text-danger credit-num">40</strong>
                          Consumable for 120 Days.
                        </p>
                        <p>3.25 USD/LESSON (TOTAL = $130.00 USD)</p>
                        <p>
                          <a class="collapsed btn btn-primary" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
                            <span class="fa fa-shopping-cart"></span> Buy
                          </a>
                        </p>
                      </div>
                      <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                        <div class="panel-body">
                          <form action="{{ url('/scheduleCredit') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="quantity" value="40" />
                            <input class="btn btn-warning" type="submit" value="Confirm to buy 40 credits" />
                          </form>
                          <span class="text-danger">*Afer pressing confirm, please pay <p>$130.00 USD</p> <!-- <strong>"{{$auth->email}} Credit Payment"</strong> --> to activate your requested credits.</span>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>

            </div>
          @endif

        </div>
    </div>
</div>
@endsection
