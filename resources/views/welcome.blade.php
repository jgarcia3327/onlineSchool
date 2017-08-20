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
								<a href="{{ url('') }}"><h1>EnglishHours.net</h1></a>
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
								<li role="presentation"><a href="{{ url('/register') }}">Đăng ký sinh viên</a></li>
								<li role="presentation"><a href="{{ url('/register/teacher') }}">Đăng ký giáo viên</a></li>
								<li role="presentation"><a href="{{ url('/login') }}">Đăng nhập</a></li>
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
					<p><a href="{{ url('/register') }}">Đăng ký MIỄN PHÍ TRƯỚC</a></p>
				</div>
			</div>
		</div>
	</div>



	<div class="container" id="courses">
		<div class="row">
			<div class="recent">
				<button class="btn-primarys"><h3>Các khóa học</h3></button>
				<hr>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="content">
				<div class="col-md-4">
					<div class="wow flipInY" data-wow-offset="0" data-wow-delay="0.4s">
						<div class="align-center">
							<h4>IELTS/TOEIC/TOEFL</h4>
							<div class="icon">
								<i class="fa fa-list fa-3x"></i>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="wow flipInY" data-wow-offset="0" data-wow-delay="0.8s">
						<div class="align-center">
							<h4>VĂN PHÒNG KINH DOANH / VĂN PHÒNG</h4>
							<div class="icon">
								<i class="fa fa-location-arrow fa-3x"></i>

							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="wow flipInY" data-wow-offset="0" data-wow-delay="1.2s">
						<div class="align-center">
							<h4>FREETALK</h4>
							<div class="icon">
								<i class="fa fa-cloud fa-3x"></i>

							</div>
						</div>
					</div>
				</div>
      </div>
    </div>
    <div class="row">
			<div class="content">
        <div class="col-md-4">
					<div class="wow flipInY" data-wow-offset="0" data-wow-delay="1.2s">
						<div class="align-center">
							<h4>TIẾNG ANH CHO CON</h4>
							<div class="icon">
								<i class="fa fa-comments fa-3x"></i>

							</div>
						</div>
					</div>
				</div>
        <div class="col-md-4">
					<div class="wow flipInY" data-wow-offset="0" data-wow-delay="1.2s">
						<div class="align-center">
							<h4>NÓI TRƯỚC CÔNG CHÚNG</h4>
							<div class="icon">
								<i class="fa fa-bullhorn fa-3x"></i>

							</div>
						</div>
					</div>
				</div>
        <div class="col-md-4">
					<div class="wow flipInY" data-wow-offset="0" data-wow-delay="1.2s">
						<div class="align-center">
							<h4>Viết và thành phần</h4>
							<div class="icon">
								<i class="fa fa-file-text fa-3x"></i>

							</div>
						</div>
					</div>
				</div>
      </div>
    </div>
    <div class="row">
      <div class="content">
        <div class="col-md-4">
					<div class="wow flipInY" data-wow-offset="0" data-wow-delay="1.2s">
						<div class="align-center">
							<h4>ĐỌC VÀ THAM GIA</h4>
							<div class="icon">
								<i class="fa fa-book fa-3x"></i>

							</div>
						</div>
					</div>
				</div>
        <div class="col-md-4">
					<div class="wow flipInY" data-wow-offset="0" data-wow-delay="1.2s">
						<div class="align-center">
							<h4>Nghe</h4>
							<div class="icon">
								<i class="fa fa-play fa-3x"></i>

							</div>
						</div>
					</div>
				</div>

        <div class="col-md-4">

				</div>
			</div>
		</div>
	</div>

		<div class="container">
			<div class="row">
				<hr>
			</div>
		</div>

		<div id="sub-footer">
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						<div class="copyright">
							<p>
								<span>&copy; EnglishHours.net {{ date('Y') }} All right reserved.
							</p>
						</div>
					</div>
					<div class="col-lg-6">
						<ul class="social-network">
							<li><a href="#" data-placement="top" title="Facebook"><i class="fa fa-facebook fa-1x"></i></a></li>
							<li><a href="#" data-placement="top" title="Twitter"><i class="fa fa-twitter fa-1x"></i></a></li>
							<li><a href="#" data-placement="top" title="Linkedin"><i class="fa fa-linkedin fa-1x"></i></a></li>
							<li><a href="#" data-placement="top" title="Pinterest"><i class="fa fa-pinterest fa-1x"></i></a></li>
							<li><a href="#" data-placement="top" title="Google plus"><i class="fa fa-google-plus fa-1x"></i></a></li>
						</ul>
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
