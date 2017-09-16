<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>English Hours - Vietnam</title>

    <!-- Bootstrap -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  	<link href="{{ asset('css/responsive-slider.css') }}" rel="stylesheet">
  	<link rel="stylesheet" href="{{ asset('css/animate.css') }}">
  	<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
  	<link href="{{ asset('css/homestyle.css') }}" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <header>
		<div class="container">
			<div class="row">
				<nav class="navbar navbar-default" role="navigation">
					<div class="container-fluid">
						<div class="navbar-header">
							<div class="navbar-brand">
								<a href="{{ url('') }}" title="EnglishHours.net"><img class="logo" src="{{asset('images/logo2.png')}}" /></a>
							</div>
						</div>
						<div class="menu">
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#courses">Các khóa học</a></li>
                @if (Auth::check() && $auth->is_student == 1)
                <li role="presentation"><a href="{{ url('/lessons') }}">Những bài học của tôi</a></li>
                <li role="presentation"><a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    Đăng xuất
                </a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                @elseif(Auth::check() && $auth->is_student == 0)
                <li role="presentation"><a href="{{ url('/schedule') }}">My Schedule</a></li>
                <li role="presentation"><a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    Logout
                </a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                @else
								<li role="presentation"><a href="{{ url('/register') }}">ĐĂNG KÝ</a></li>
								<li role="presentation"><a href="{{ url('/register/teacher') }}">TUTOR'S PORTAL</a></li>
								<li role="presentation"><a href="{{ url('/login') }}">ĐĂNG NHẬP</a></li>
                @endif
							</ul>
						</div>
					</div>
				</nav>
			</div>
		</div>
	</header>

	<!-- Responsive slider - START -->
	<div class="slider">
	<div class="container">
		<div class="row">
			<div class="responsive-slider" data-spy="responsive-slider" data-autoplay="true">
				<div class="slides" data-group="slides">
					<ul>
						<li>
							<div class="slide-body" data-group="slide">
								<img src="{{ asset('img/2a.jpg') }}" alt="">
								<div class="caption header" data-animate="slideAppearUpToDown" data-delay="500" data-length="300">
									<button class="btn btn-primary"><h2>Chạy trong máy tính để bàn</h2></button>
									<div class="caption-sub" data-animate="slideAppearDownToUp" data-delay="1200" data-length="300"><button class="btn btn-primary"><h4><span>Đăng ký MIỄN PHÍ TRƯỚC</span></h4></button></div>
									<div class="caption-sub" data-animate="slideAppearLeftToRight" data-delay="900" data-length="300"><button class="btn btn-primary"><h3>Chỉ cung cấp hạn chế</h3></button></div>
								</div>
							</div>
						</li>
						<li>
							<div class="slide-body" data-group="slide">
								<img src="{{ asset('img/1.jpg') }}" alt="">
								<div class="caption header" data-animate="slideAppearDownToUp" data-delay="500" data-length="300">
									<button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off"><h2>Đáp ứng</h2></button>
									<div class="caption-sub" data-animate="slideAppearUpToDown" data-delay="800" data-length="300"><button class="btn btn-primary"><h4><span>Chạy trong máy tính bảng và điện thoại di động</span></h4></button></div>
									<div class="caption-sub" data-animate="slideAppearRightToLeft" data-delay="1200" data-length="300"><button class="btn btn-primary"><h3>Thử ngay bây giờ</h3></button></div>
								</div>
							</div>
						</li>
						<li>
							<div class="slide-body" data-group="slide">
								<img src="{{ asset('img/10.jpg') }}" alt="">
								<div class="caption header" data-animate="slideAppearUpToDown" data-delay="500" data-length="300">
								  <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off"><h2>Học tập thật dễ dàng</h2></button>
								  <div class="caption-sub" data-animate="slideAppearLeftToRight" data-delay="800" data-length="300"><button class="btn btn-primary"><h4>Học tập dễ dàng với chúng tôi</h4></button></div>
								  <div class="caption-sub" data-animate="slideAppearDownToUp" data-delay="1200" data-length="300"><button class="btn btn-primary"><h3>Hãy thử hệ thống của chúng tôi ngay bây giờ</h3></button></div>

								</div>
							</div>
						</li>

					</ul>
				</div>

				<a class="slider-control left" href="#" data-jump="prev"><i class="fa fa-angle-left fa-2x"></i></a>
				<a class="slider-control right" href="#" data-jump="next"><i class="fa fa-angle-right fa-2x"></i></a>
			</div>
		</div>
	</div>
	</div>
    <!-- Responsive slider - END -->

	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="contents">
					<h2>Dễ dàng sử dụng ứng dụng</h2>
          <p>Có thể được sử dụng trong máy tính để bàn, máy tính bảng và điện thoại di động</p>
				</div>
			</div>
		</div>
	</div>

  <!-- Social Network -->
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
          <ul class="social-network">
            <li><a href="mailto:info@englishhours.net" data-placement="top" title="info@englishhours.net" class="email-icon"><i class="fa fa-envelope fa-3x"></i></a></li>
            <li><a href="skype:live:jhanlay?call" data-placement="top" title="julius.garcia3" class="skype-icon"><i class="fa fa-skype fa-3x"></i></a></li>
            <li><a href="#" data-placement="top" title="Phone Numbers" class="phone-icon"><i class="fa fa-phone fa-3x"></i></a></li>
            <li><a href="https://www.facebook.com/Tienganhquaskype/" data-placement="top" title="Facebook" class="facebook-icon"><i class="fa fa-facebook fa-3x"></i></a></li>
          </ul>
      </div>
    </div>
  </div>
  <!-- end Social Network -->

  <!-- Courses and User Feedback -->
	<div class="container">
  <div class="row">

    <div class="col-md-8 courses">
      <div id="courses">
    		<div class="row">
    			<div class="recent">
    				<h2>KHÓA HỌC</h2>
    				<hr>
    			</div>
    		</div>
    	</div>
      <div class="row">
        <div class="content">
          <div class="col-md-3">
            <h3 class="course-title">IELTS/TOEIC/TOEFL</h3>
            <div class="wow bounceIn" data-wow-offset="0" data-wow-delay="0.4s">
              <div class="align-center course-wrapper ielts-course">
                <div class="icon">
                  <i class="fa fa-list fa-2x"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <h3 class="course-title">TIẾNG ANH THƯƠNG MẠI</h3>
            <div class="wow bounceIn" data-wow-offset="0" data-wow-delay="0.8s">
              <div class="align-center course-wrapper business-course">
                <div class="icon">
                  <i class="fa fa-location-arrow fa-2x"></i>

                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <h3 class="course-title">TIẾNG ANH GIAO TIẾP</h3>
            <div class="wow bounceIn" data-wow-offset="0" data-wow-delay="1.2s">
              <div class="align-center course-wrapper freetalk-course">
                <div class="icon">
                  <i class="fa fa-cloud fa-2x"></i>

                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <h3 class="course-title">TIẾNG ANH THIẾU NHI</h3>
            <div class="wow bounceIn" data-wow-offset="0" data-wow-delay="1.2s">
              <div class="align-center course-wrapper kids-course">
                <div class="icon">
                  <i class="fa fa-comments fa-2x"></i>

                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="row">
        <div class="content">
          <div class="col-md-3">
            <h3 class="course-title">TIẾNG ANH THUYẾT TRÌNH</h3>
            <div class="wow bounceIn" data-wow-offset="0" data-wow-delay="1.2s">
              <div class="align-center course-wrapper public-course">
                <div class="icon">
                  <i class="fa fa-bullhorn fa-2x"></i>

                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <h3 class="course-title">LUYỆN ĐỌC VÀ VIẾT TIẾNG ANH</h3>
            <div class="wow bounceIn" data-wow-offset="0" data-wow-delay="1.2s">
              <div class="align-center course-wrapper writing-course">
                <div class="icon">
                  <i class="fa fa-file-text fa-2x"></i>

                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <h3 class="course-title">LUYỆN ĐỌC</h3>
            <div class="wow bounceIn" data-wow-offset="0" data-wow-delay="1.2s">
              <div class="align-center course-wrapper reading-course">
                <div class="icon">
                  <i class="fa fa-book fa-2x"></i>

                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <h3 class="course-title">NGHE</h3>
            <div class="wow bounceIn" data-wow-offset="0" data-wow-delay="1.2s">
              <div class="align-center course-wrapper listening-course">
                <div class="icon">
                  <i class="fa fa-play fa-2x"></i>

                </div>
              </div>
            </div>
          </div>

        </div>
      </div>


    </div> <!-- end col-md-8 -->
    <div class="col-md-4">
      <div id="user-feedback">
    		<div class="row">
    			<div class="recent">
    				<h2>User's Feedback</h2>
    				<hr>
    			</div>
    		</div>
    	</div>
      <div class="row feedback-wrapper">
        <div class="content feedback">
          <div class="col-md-12">
            <!-- List of user's feedback -->
            <div class="panel panel-default">
              <div class="panel-heading"><i class="fa fa-comment"></i> Janet</div>
              <div class="panel-body">
                Please try our system and give us feedback.
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading"><i class="fa fa-comment"></i> Julius</div>
              <div class="panel-body">
                Cool. Run on my phone's web browser @ iphone 5s.
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading"><i class="fa fa-comment"></i> Kenith</div>
              <div class="panel-body">
                Great stuff to learn english!
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>
	</div>
  <!-- end Courses and User Feedback -->

  <!-- Teacher Profile -->
  <div class="container">
    <div class="row">
      <div class="recent">
        <h2>TEACHER PROFILE</h2>
        <hr>
      </div>
    </div>
    <div class="row">
      <div class="content">
        <div class="text-center profile-photo">
          <?php $teachers = $common->getActiveTeacherProfile();?>
          <?php $counter = 0; ?>
          @foreach($teachers AS $v)
            <div class="col-md-3 profile-photo">
              <a href="{{ url('reserveTeacher/'.$v->user_id) }}">
              @if($v->photo != null)
              <img src="{{ asset('images/profile/') }}/{{ $v->photo }}"/>
              @else
              <img src="{{ asset('images/profile/default_') }}{{ $v->gender }}.png"/>
              @endif
              </a>
              <br/>
              <a href="{{ url('reserveTeacher/'.$v->user_id) }}">{{ $v->fname }} {{ $v->lname }}</a>
            </div>
            <?php $counter++; ?>
            @if ($counter % 4 == 0)
              </div>
              <div class="row text-center">
            @endif
          @endforeach
          <?php $remaining = 4 - ($counter % 4); ?>
          @if($remaining != 4)
            @for($i = 0; $i < $remaining; $i++)
              <div class="col-md-3">&nbsp;</div>
            @endfor
          @endif
        </div>
      </div>
    </div>
  </div>
  <!-- end Teacher Profile -->

  <footer>
		<div id="sub-footer">
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						<div class="copyright">
							<p>
								<span>&copy; EnglishHours.net {{ date('Y') }}. All right reserved.
							</p>
						</div>
					</div>
					<div class="col-lg-6">

					</div>
				</div>
			</div>
		</div>
	</footer>
	<!--end footer-->


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{ asset('js/jquery.js') }}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/responsive-slider.js') }}"></script>
	<script src="{{ asset('js/wow.min.js') }}"></script>
	<script>
	wow = new WOW(
	 {

		}	)
		.init();
	</script>
  </body>
</html>
