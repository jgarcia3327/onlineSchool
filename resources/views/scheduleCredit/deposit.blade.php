@extends('layouts.app')

@section('title', "Balance Deposit - English Hours")

@section('content')
<?php
$success = $deposits[0];
$pending = $deposits[1];
$balanceAmount = $deposits[2];
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

          <!-- Balance details -->
          <div class="panel panel-default">
            <!-- <div class="panel-heading">BALANCE</div> -->
            <div class="panel-heading">SỐ DƯ TÀI KHOẢN</div>
            <div class="panel-body">
              <!-- <strong>Total Balance: {{$balanceAmount}} </strong> [ <a href="{{url('scheduleCredit')}}">Buy Lesson Credit</a> ] -->
              <strong>Tổng số dư tài khoản: {{$balanceAmount}} </strong> [ <a href="{{url('scheduleCredit')}}">Mua gói học</a> ]
              @if(!empty(session('success')))
                <!-- <p class="text-success">We will credit your balance as soon as we received your <strong class="text-danger">{{ session('success') }}</strong> deposit.</p>
                <p class="text-success">Thank you. -From EnglishHours.net</p> -->
                <br/>
                <p class="text-success">Chúng tôi sẽ xác nhận số dư tài khoản của bạn ngay khi nhận được số tiền nạp <strong class="text-danger">{{ session('success') }}</strong> từ ngân hàng.</p>
                <p class="text-success">Chân thành cảm ơn bạn.</p>
                <p class="text-success">EnglishHours.net</p>
              @endif
            </div>
          </div>

          <!-- Deposit -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <!-- ADD BALANCE -->
              NẠP THÊM SỐ DƯ VÀO TÀI KHOẢN
            </div>
            <div class="panel-body" role="tab" id="headingOne">
              <form action="{{ url('/deposit') }}" method="POST">
                <div class="form-group">
                  <!-- <label for="amount">Amount:</label> -->
                  <label for="amount">Số tiền:</label>
                  <select class="form-control amount-form" id="amount" name="amount">
                    <option value="860000">860.000</option>
                    <option value="1000000">1.000.000</option>
                    <option value="1660000">1.660.000</option>
                    <option value="2000000">2.000.000</option>
                    <option value="2350000">2.350.000</option>
                    <option value="3000000">3.000.000</option>
                    <option value="4000000">4.000.000</option>
                    <option value="5000000">5.000.000</option>
                    <option value="6000000">6.000.000</option>
                    <option value="7000000">7.000.000</option>
                    <option value="8000000">8.000.000</option>
                    <option value="9000000">9.000.000</option>
                    <option value="10000000">10.000.000</option>
                    <option value="11000000">11.000.000</option>
                    <option value="12000000">12.000.000</option>
                    <option value="13000000">13.000.000</option>
                    <option value="14000000">14.000.000</option>
                    <option value="15000000">15.000.000</option>
                  </select>
                </div>
                <a class="btn btn-success deposit-btn" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  <span class="fa fa-money"></span>
                  <!-- Deposit -->
                  Nạp tiền
                </a>
                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  {{ csrf_field() }}
                  <input type="hidden" name="quantity" value="10" />
                  <ul class="list-group">
                    <li class="list-group-item">
                      <!-- *Please deposit amount to: -->
                      Xin gửi số tiền nạp trên đến:
                    </li>
                    @foreach($common->getEnglishHoursBankAccount() AS $k => $v)
                    <li class="list-group-item">{{$k}}: <strong>{{$v}}</strong></li>
                    @endforeach
                    <!-- <li class="list-group-item"><input class="btn btn-danger" type="submit" value="Confirm to Deposit Money" /></li> -->
                    <li class="list-group-item"><input class="btn btn-danger" type="submit" value="Xác nhận nạp tiền" /></li>
                  </ul>
                </div>
              </form>
            </div>
          </div>

          <!-- Successfully credited deposits -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <!-- CREDITED DEPOSITS -->
              SỐ TIỀN NẠP THÀNH CÔNG
            </div>
            <div class="panel-body">
              @if($success == null && count($success) <= 0)
                <!-- No data found. -->
                Không tìm thấy thông tin
              @else
                @foreach($success AS $v)
                <ul class="list-group">
                  <li class="list-group-item"><strong>{{ $v->amount }}</strong> ({{$v->create_date->toDateTimeString()}}) {{ $v->create_date->diffForHumans()}}</li>
                </ul>
                @endforeach
              @endif
            </div>
          </div>

          <!-- Pending deposits that needs approval/activation from admin -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <!-- PENDING DEPOSITS -->
              SỐ TIỀN NẠP ĐANG CHỜ XỬ LÝ
              @if($pending != null && count($pending) > 0)
              <ul class="list-group">
                <li class="list-group-item"><span class="text-danger">
                  <!-- *Deposit pending request to: -->
                  Tiền nạp đang xử lý yêu cầu gửi đến:
                </span></li>
                @foreach($common->getEnglishHoursBankAccount() AS $k => $v)
                <li class="list-group-item">
                  {{$k}}:
                  <strong class="text-danger">{{$v}}</strong>
                </li>
                @endforeach
              </ul>
              @endif
            </div>
            <div class="panel-body">
              @if($pending == null && count($pending) <= 0)
                No data found.
              @else
                @foreach($pending AS $v)
                <ul class="list-group">
                  <li class="list-group-item">
                    <!-- Amount:  -->
                    Số tiền:
                    <strong>{{ $v->amount }} </strong> (Thời gian: {{$v->create_date->toDateTimeString()}}) {{ $v->create_date->diffForHumans()}}
                  </li>
                </ul>
                @endforeach
              @endif
            </div>
          </div>

        </div>
    </div>
</div>
@endsection
