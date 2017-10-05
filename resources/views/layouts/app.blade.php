<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    @yield('style')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}" title="EnglishHours.net">
                        <img src="{{ asset('images/logo3.png') }}"/>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                          @if (Route::currentRouteName() != "login")
                            <li><a href="{{ route('login') }}">ĐĂNG NHẬP</a></li>
                          @else
                          <li><a href="{{ url('/register') }}">ĐĂNG KÝ</a></li>
                          <li><a href="{{ url('/register/teacher') }}">TUTOR'S PORTAL</a></li>
                          @endif
                        @else

                            <!-- Admin -->
                            @if ($auth->is_admin == 1)
                            <li><a href="{{ url('/adminDashboard') }}">Admin Dashboard</a></li>
                            @endif
                            <!-- Student -->
                            @if ($auth->is_student == 1)
                              <li><a href="{{ url('/reserveTeacher') }}">Chọn giáo viên</a></li>
                              <li><a href="{{ url('/lessons') }}">Lịch học của tôi</a></li>
                              <li><a href="{{ url('/books') }}">Sách</a></li>
                              <li><a href="{{ url('/messages') }}">Tin nhắn</a></li>
                              <li class="dropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                      {{ Auth::user()->email }} <span class="caret"></span>
                                  </a>

                                  <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/scheduleCredit') }}">Tài khoản của tôi<!--My Credits--></a></li>
                                    <li><a href="{{ url('/profile') }}">Thông tin cá nhân của tôi<!--My Profile--></a></li>
                                    <!-- <li>
                                        <a href="/home">My Dasboard</a>
                                    </li> -->
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Đăng xuất<!--Logout-->
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                  </ul>
                              </li>
                            @else
                              <!-- Teacher -->
                              <li class="dropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                      Schedule <span class="caret"></span>
                                  </a>

                                  <ul class="dropdown-menu" role="menu">
                                      <li><a href="{{ url('/schedule') }}">My Schedule</a></li>
                                      <li><a href="{{ url('/schedule/create') }}">Create Schedule</a></li>
                                  </ul>
                              </li>
                              <li><a href="{{ url('/messages') }}">Messages</a></li>
                              <li><a href="{{ url('/books') }}">Books</a></li>
                              <li><a href="{{ url('/wage') }}">Wage</a></li>
                              <li class="dropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                      {{ Auth::user()->email }} <span class="caret"></span>
                                  </a>

                                  <ul class="dropdown-menu" role="menu">
                                      <!-- <li>
                                          <a href="/home">My Dasboard</a>
                                      </li> -->
                                      <li><a href="{{ url('/teacherProfile') }}">My Profile</a></li>
                                      <li>
                                          <a href="{{ route('logout') }}"
                                              onclick="event.preventDefault();
                                                       document.getElementById('logout-form').submit();">
                                              Logout
                                          </a>

                                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                              {{ csrf_field() }}
                                          </form>
                                      </li>
                                  </ul>
                              </li>
                            @endif

                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @if ($auth->is_admin == 1 || $auth->is_student == 0)
        <!-- Display server time -->
        <div class='time-frame'>
            <span>VIETNAM DATE/TIME:</span>
            <div id='date-part'></div>
            <div id='time-part'></div>
        </div>
        @endif

        @yield('content')
    </div>

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/moment-timezone.min.js') }}"></script>
    @yield('javascript')

    @if ($auth->is_admin == 1 || $auth->is_student == 0)
    <script type="text/javascript">
      $(document).ready(function() {
        var interval = setInterval(function() {
            var momentNow = moment().tz('Asia/Ho_Chi_Minh');
            $('#date-part').html(momentNow.format('dddd') + ', ' + momentNow.format('DD MMMM YYYY'));
            $('#time-part').html(momentNow.format('hh:mm:ss A'));
        }, 100);

        $('#stop-interval').on('click', function() {
            clearInterval(interval);
        });
      });
    </script>
    @endif
</body>
</html>
