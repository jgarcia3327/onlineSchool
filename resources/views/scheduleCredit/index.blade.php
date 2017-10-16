@extends('layouts.app')

@section('title', "Credit Lessons - English Hours")

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
                  <p>Bạn còn lại <strong class="text-danger">{{ $creditLesson }}</strong> bài học</p>
                  <!-- <p>You have <strong class="text-success">{{ $balanceAmount }} đồng</strong> balance in your account. [ <a href="{{ url('/deposit') }}">Deposit</a> ]</p> -->
                  <p>Bạn có <strong class="text-success">{{ $balanceAmount }} đồng</strong> trong tài khoản [ <a href="{{ url('/deposit') }}">Nạp tiền vào tài khoản</a> ]</p>
                  @if (session('success') > 0)
                  <span class="help-block">
                      <strong class="text-success">Cảm ơn bạn đã mua gói học<!--Thank you for your purchase.-->
                  </span>
                  @endif
                  @if (session('error') == 1)
                    <strong class="text-danger">You don't have enough privileges.</strong>
                  @endif
                  <!-- Pending credit lessons -->
                  @if($pendingCredits != null && count($pendingCredits) > 0)
                  @foreach($pendingCredits AS $pending)
                  <div class="text-error">
                    <ul class="list-group">
                      <li class="list-group-item">PENDING LESSON REQUEST ( {{$pending->create_date->diffForHumans()}} ):
                        <br/>- You have {{$pending->quantity}} credit lessons pending for activation.
                        <br/>- To activate pending request, please deposit {{$common->getCreditLessonsStr()[$pending->quantity]}} đồng to:</li>
                      @foreach($common->getEnglishHoursBankAccount() AS $k => $v)
                      <li class="list-group-item">{{$k}}: <strong>{{$v}}</strong></li>
                      @endforeach
                    </ul>
                  </div>
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
                            Thời hạn sử dụng: {{$common->getCreditLessonsValidity()[10]}} ngày.
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
                          @if($balanceAmount >= $common->getCreditLessons()[10])
                            <form action="{{ url('/scheduleCredit') }}" method="POST">
                              {{ csrf_field() }}
                              <input type="hidden" name="quantity" value="10" />
                              <!-- <input class="btn btn-warning" type="submit" value="Sign up for a 10-lesson package" /> -->
                              <input class="btn btn-warning" type="submit" value="Đăng kí để mua gói 10 bài học này" />
                            </form>
                            <span class="text-danger">
                              <!-- Your current balance will be charged with <strong>860.000 đồng</strong>. -->
                              Số dư tài khoản hiện tại của bạn sẽ được cộng thêm <strong>860.000</strong>
                            </span>
                          @else
                            <!-- <p class="text-danger">Please deposit at least <strong>860.000 đồng</strong> [ <a href="{{ url('/deposit') }}">Deposit</a> ]</p> -->
                            <!-- <p class="text-danger">Vui lòng nạp vào tài khoản ít nhất <strong>860.000</strong> đồng để mua gói học [ <a href="{{ url('/deposit') }}">Nạp tiền vào tài khoản</a> ]</p> -->

                            <!-- Direct buy of # of credit lessons -->
                            <form action="{{ url('/scheduleCredit') }}" method="POST">
                              {{ csrf_field() }}
                              <input type="hidden" name="quantity" value="10" />
                              <input class="btn btn-warning" type="submit" value="Đăng kí để mua gói 10 bài học này" />
                            </form>
                            <span class="text-error">
                              <ul class="list-group">
                                <li class="list-group-item">
                                  <!-- *To activate your 10 credit lessons, please deposit an amount of <strong>860.000</strong> to: -->
                                  Để kích hoạt gói 10 bài học này, bạn vui lòng chuyển <strong>860.000</strong> đến:
                                </li>
                                @foreach($common->getEnglishHoursBankAccount() AS $k => $v)
                                <li class="list-group-item">{{$k}}: <strong>{{$v}}</strong></li>
                                @endforeach
                              </ul>
                            </span>

                          @endif
                        </div>
                      </div>
                    </div>

                    <!-- Option 2 -->
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingTwo">
                        <p>
                          <strong class="text-warning credit-num">20</strong>
                          Thời hạn sử dụng: {{$common->getCreditLessonsValidity()[20]}} ngày.
                        <p>
                        <p>Học phí: 1.660.000 đồng/ 20 bài học<!--3.60 USD/LESSON (TOTAL = $72.00 USD)--></p>
                        <p><a class="collapsed btn btn-primary" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <span class="fa fa-shopping-cart"></span> Mua
                          </a>
                        </p>
                      </div>
                      <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                          @if ($balanceAmount >= $common->getCreditLessons()[20])
                            <form action="{{ url('/scheduleCredit') }}" method="POST">
                              {{ csrf_field() }}
                              <input type="hidden" name="quantity" value="20" />
                              <input class="btn btn-warning" type="submit" value="Đăng kí để mua gói 20 bài học này" />
                            </form>
                            <span class="text-danger">
                              <!-- Your current balance will be charged with <strong>1.660.000 đồng</strong>. -->
                              Số dư tài khoản hiện tại của bạn sẽ được cộng thêm <strong>1.660.000</strong>
                            </span>
                          @else
                            <!-- <p class="text-danger">Please deposit at least <strong>1.660.000 đồng</strong> [ <a href="{{ url('/deposit') }}">Deposit</a> ]</p> -->
                            <!-- <p class="text-danger">Vui lòng nạp vào tài khoản ít nhất <strong>1.660.000</strong> đồng để mua gói học [ <a href="{{ url('/deposit') }}">Nạp tiền vào tài khoản</a> ]</p> -->

                            <!-- Direct buy of # of credit lessons -->
                            <form action="{{ url('/scheduleCredit') }}" method="POST">
                              {{ csrf_field() }}
                              <input type="hidden" name="quantity" value="20" />
                              <input class="btn btn-warning" type="submit" value="Đăng kí để mua gói 20 bài học này" />
                            </form>
                            <span class="text-error">
                              <ul class="list-group">
                                <li class="list-group-item">
                                  <!-- *To activate your 20 credit lessons, please deposit an amount of <strong>1.660.000</strong> to: -->
                                  Để kích hoạt gói 10 bài học này, bạn vui lòng chuyển <strong>1.660.000</strong> đến:
                                </li>
                                @foreach($common->getEnglishHoursBankAccount() AS $k => $v)
                                <li class="list-group-item">{{$k}}: <strong>{{$v}}</strong></li>
                                @endforeach
                              </ul>
                            </span>

                          @endif
                        </div>
                      </div>
                    </div>

                    <!-- Option 3 -->
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingThree">
                        <p>
                          <strong class="text-danger credit-num">30</strong>
                          Thời hạn sử dụng: {{$common->getCreditLessonsValidity()[30]}} ngày.
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
                          @if ($balanceAmount >= $common->getCreditLessons()[30])
                            <form action="{{ url('/scheduleCredit') }}" method="POST">
                              {{ csrf_field() }}
                              <input type="hidden" name="quantity" value="30" />
                              <input class="btn btn-warning" type="submit" value="Đăng kí để mua gói 30 bài học này" />
                            </form>
                            <span class="text-danger">
                              <!-- Your current balance will be charged with <strong>2.350.000 đồng</strong>. -->
                              Số dư tài khoản hiện tại của bạn sẽ được cộng thêm <strong>2.350.000</strong>
                            </span>
                          @else
                            <!-- <p class="text-danger">Please deposit at least <strong>2.350.000 đồng</strong> [ <a href="{{ url('/deposit') }}">Deposit</a> ]</p> -->
                            <!-- <p class="text-danger">Vui lòng nạp vào tài khoản ít nhất <strong>2.350.000</strong> đồng để mua gói học [ <a href="{{ url('/deposit') }}">Nạp tiền vào tài khoản</a> ]</p> -->

                            <!-- Direct buy of # of credit lessons -->
                            <form action="{{ url('/scheduleCredit') }}" method="POST">
                              {{ csrf_field() }}
                              <input type="hidden" name="quantity" value="30" />
                              <input class="btn btn-warning" type="submit" value="Đăng kí để mua gói 30 bài học này" />
                            </form>
                            <span class="text-error">
                              <ul class="list-group">
                                <li class="list-group-item">
                                  <!-- *To activate your 30 credit lessons, please deposit an amount of <strong>2.350.000</strong> to: -->
                                  Để kích hoạt gói 10 bài học này, bạn vui lòng chuyển <strong>2.350.000</strong> đến:
                                </li>
                                @foreach($common->getEnglishHoursBankAccount() AS $k => $v)
                                <li class="list-group-item">{{$k}}: <strong>{{$v}}</strong></li>
                                @endforeach
                              </ul>
                            </span>

                          @endif
                        </div>
                      </div>
                    </div>

                    <!-- Option 4 -->
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingFour">
                        <p>
                          <strong class="text-danger credit-num">40</strong>
                          Thời hạn sử dụng: {{$common->getCreditLessonsValidity()[40]}} ngày.
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
                          @if ($balanceAmount >= $common->getCreditLessons()[40])
                            <form action="{{ url('/scheduleCredit') }}" method="POST">
                              {{ csrf_field() }}
                              <input type="hidden" name="quantity" value="40" />
                              <input class="btn btn-warning" type="submit" value="Đăng kí để mua gói 40 bài học này" />
                            </form>
                            <span class="text-danger">
                              <!-- Your current balance will be charged with <strong>2.990.000 đồng</strong>. -->
                              Số dư tài khoản hiện tại của bạn sẽ được cộng thêm <strong>2.990.000</strong>
                            </span>
                          @else
                            <!-- <p class="text-danger">Please deposit at least <strong>2.990.000 đồng</strong> [ <a href="{{ url('/deposit') }}">Deposit</a> ]</p> -->
                            <!-- <p class="text-danger">Vui lòng nạp vào tài khoản ít nhất <strong>2.990.000</strong> đồng để mua gói học [ <a href="{{ url('/deposit') }}">Nạp tiền vào tài khoản</a> ]</p> -->

                            <!-- Direct buy of # of credit lessons -->
                            <form action="{{ url('/scheduleCredit') }}" method="POST">
                              {{ csrf_field() }}
                              <input type="hidden" name="quantity" value="40" />
                              <input class="btn btn-warning" type="submit" value="Đăng kí để mua gói 40 bài học này" />
                            </form>
                            <span class="text-error">
                              <ul class="list-group">
                                <li class="list-group-item">
                                  <!-- *To activate your 40 credit lessons, please deposit an amount of <strong>2.990.000</strong> to: -->
                                  Để kích hoạt gói 10 bài học này, bạn vui lòng chuyển <strong>2.990.000</strong> đến:
                                </li>
                                @foreach($common->getEnglishHoursBankAccount() AS $k => $v)
                                <li class="list-group-item">{{$k}}: <strong>{{$v}}</strong></li>
                                @endforeach
                              </ul>
                            </span>

                          @endif
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
