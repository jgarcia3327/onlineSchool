@extends('layouts.app')

@section('content')
<?php
  $creditLesson = $credits[0];
  $pendingCredits = $credits[1];
  $balanceAmount = $credits[2];
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

          @if ($auth->is_student == 1)
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Tài khoản của tôi</strong></div>

                <div class="panel-body">
                  <!-- <p>You have <strong class="text-danger">{{ $creditLesson }}</strong> lesson credit(s) left.</p> -->
                  <p>Bạn còn lại <strong class="text-danger">{{ $creditLesson }}</strong> bài học trong tài khoản.</p>
                  <p>You have <strong class="text-success">{{ $balanceAmount }}</strong> USD balance in your account. [ <a href="{{ url('/deposit') }}">Deposit</a> ]</p>
                  @if (session('success') > 0)
                  <span class="help-block">
                      <strong class="text-success">Cảm ơn bạn đã mua gói học<!--Thank you for your purchase.-->
                  </span>
                  @endif
                  @if(count($pendingCredits) > 0)
                  @foreach($pendingCredits AS $pending)
                  <p class="text-warning"><strong>Đanh chờ kích hoạt:</strong> Gói học gồm {{$pending->quantity}} bài học - Đã đăng kí {{$pending->create_date->diffForHumans()}}</p>
                  @endforeach
                  @endif
                </div>
            </div>

            <!-- Buy Credits -->
            <div class="panel panel-default">
                <div class="panel-heading">Mua gói học</h3></div>

                <div class="panel-body">
                  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                    <!-- Option 1 -->
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingOne">
                          <p>
                            <strong class="text-default credit-num">10</strong>
                            Thời hạn sử dụng: 30 ngày.
                          </p>
                          <p>Học phí: 860.000 đồng/ 10 bài học <!--3.75 USD/LESSON (TOTAL = $37.50 USD)--></p>
                          <p>
                          <a class="btn btn-primary" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <span class="fa fa-shopping-cart"></span> Mua
                          </a>
                        </p>
                      </div>
                      <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                          <form action="{{ url('/scheduleCredit') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="quantity" value="10" />
                            <input class="btn btn-warning" type="submit" value="Đăng kí để mua gói 10 bài học này" />
                          </form>
                          <span class="text-danger">
                            *Sau khi bấm vào đăng kí, bạn hãy nộp học phí <strong>860.000 đồng</strong> để kích hoạt gói học của mình.
                            <!--*Afer pressing confirm, please pay <strong>$37.50 USD</strong> to activate your requested credits.-->
                          </span>
                        </div>
                      </div>
                    </div>

                    <!-- Option 2 -->
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingTwo">
                        <p>
                          <strong class="text-warning credit-num">20</strong>
                          Thời hạn sử dụng: 60 ngày.
                        <p>
                        <p>Học phí: 1.660.000 đồng/ 20 bài học<!--3.60 USD/LESSON (TOTAL = $72.00 USD)--></p>
                        <p><a class="collapsed btn btn-primary" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <span class="fa fa-shopping-cart"></span> Mua
                          </a>
                        </p>
                      </div>
                      <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                          <form action="{{ url('/scheduleCredit') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="quantity" value="20" />
                            <input class="btn btn-warning" type="submit" value="Đăng kí để mua gói 20 bài học này" />
                          </form>
                          <span class="text-danger">
                            *Sau khi bấm vào đăng kí, bạn hãy nộp học phí <strong>1.660.000 đồng</strong> để kích hoạt gói học của mình.
                            <!--*Afer pressing confirm, please pay <strong>$72.00 USD</strong> to activate your requested credits.-->
                          </span>
                        </div>
                      </div>
                    </div>

                    <!-- Option 3 -->
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingThree">
                        <p>
                          <strong class="text-danger credit-num">30</strong>
                          Thời hạn sử dụng: 90 ngày.
                        </p>
                        <p>Học phí: 2.350.000 đồng/ 30 bài học<!--3.40 USD/LESSON (TOTAL = $102.00 USD)--></p>
                        <p>
                          <a class="collapsed btn btn-primary" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <span class="fa fa-shopping-cart"></span> Mua
                          </a>
                        </p>
                      </div>
                      <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                          <form action="{{ url('/scheduleCredit') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="quantity" value="30" />
                            <input class="btn btn-warning" type="submit" value="Đăng kí để mua gói 30 bài học này" />
                          </form>
                          <span class="text-danger">
                            *Sau khi bấm vào đăng kí, bạn hãy nộp học phí <strong>2.350.000 đồng</strong> để kích hoạt gói học của mình.
                            <!--*Afer pressing confirm, please pay <strong>$102.00 USD</strong> to activate your requested credits.-->
                          </span>
                        </div>
                      </div>
                    </div>

                    <!-- Option 4 -->
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingFour">
                        <p>
                          <strong class="text-danger credit-num">40</strong>
                          Thời hạn sử dụng: 120 ngày.
                        </p>
                        <p>Học phí: 2.990.000 đồng/ 40 bài học<!--3.25 USD/LESSON (TOTAL = $130.00 USD)--></p>
                        <p>
                          <a class="collapsed btn btn-primary" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
                            <span class="fa fa-shopping-cart"></span> Mua
                          </a>
                        </p>
                      </div>
                      <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                        <div class="panel-body">
                          <form action="{{ url('/scheduleCredit') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="quantity" value="40" />
                            <input class="btn btn-warning" type="submit" value="Đăng kí để mua gói 40 bài học này" />
                          </form>
                          <span class="text-danger">
                            *Sau khi bấm vào đăng kí, bạn hãy nộp học phí <strong>2.990.000 đồng</strong> để kích hoạt gói học của mình.
                            <!--*Afer pressing confirm, please pay <p>$130.00 USD</p> to activate your requested credits.-->
                          </span>
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
