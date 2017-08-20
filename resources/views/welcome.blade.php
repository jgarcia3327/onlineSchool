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
								<li role="presentation" class="active"><a href="#courses">Courses</a></li>

								<li role="presentation"><a href="{{ url('/register') }}">Student Registration</a></li>
								<li role="presentation"><a href="{{ url('/register/teacher') }}">Teacher Registration</a></li>
								<li role="presentation"><a href="{{ url('/login') }}">Login</a></li>
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
									<button class="btn btn-primary"><h2>Our system can run using desktop</h2></button>
									<div class="caption-sub" data-animate="slideAppearDownToUp" data-delay="1200" data-length="300"><button class="btn btn-primary"><h4><span>Try it now, it's free for a limited time offer only</span></h4></button></div>
									<div class="caption-sub" data-animate="slideAppearLeftToRight" data-delay="900" data-length="300"><button class="btn btn-primary"><h3>Easy to use online english tutorial</h3></button></div>
								</div>
							</div>
						</li>
						<li>
							<div class="slide-body" data-group="slide">
								<img src="{{ asset('img/1.jpg') }}" alt="">
								<div class="caption header" data-animate="slideAppearDownToUp" data-delay="500" data-length="300">
									<button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off"><h2>You can use tablets / mobile phones</h2></button>
									<div class="caption-sub" data-animate="slideAppearUpToDown" data-delay="800" data-length="300"><button class="btn btn-primary"><h4><span>Just visit www.englishhours.net with your favorite tablet/mobile browser</span></h4></button></div>
									<div class="caption-sub" data-animate="slideAppearRightToLeft" data-delay="1200" data-length="300"><button class="btn btn-primary"><h3>And your ready to have a class</h3></button></div>
								</div>
							</div>
						</li>
						<li>
							<div class="slide-body" data-group="slide">
								<img src="{{ asset('img/10.jpg') }}" alt="">
								<div class="caption header" data-animate="slideAppearUpToDown" data-delay="500" data-length="300">
								  <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off"><h2>Learning is easy with us</h2></button>
								  <div class="caption-sub" data-animate="slideAppearLeftToRight" data-delay="800" data-length="300"><button class="btn btn-primary"><h4>Try our system</h4></button></div>
								  <div class="caption-sub" data-animate="slideAppearDownToUp" data-delay="1200" data-length="300"><button class="btn btn-primary"><h3><span>And register</span></h3></button></div>

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
					<h2>Easy to use apps.</h2>
          <p>Can be used in desktop, tablet, and in mobile phone.</p>
					<p><a href="{{ url('/register') }}">SIGN UP FOR FREE TRIAL</a></p>
				</div>
			</div>
		</div>
	</div>



	<div class="container" id="courses">
		<div class="row">
			<div class="recent">
				<button class="btn-primarys"><h3>Courses</h3></button>
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
							<p>
							 We have teachers that are highly qualified to teach IELTS/TOEIC/TOEFL courses.
							</p>

						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="wow flipInY" data-wow-offset="0" data-wow-delay="0.8s">
						<div class="align-center">
							<h4>BUSINESS/OFFICE ENGLISH</h4>
							<div class="icon">
								<i class="fa fa-location-arrow fa-3x"></i>

							</div>
							<p>
							 We offer english courses that are suitable for business and office.
							</p>
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
							<p>
							 We offer english FREETALK course for conversational english exercises.
							</p>
						</div>
					</div>
				</div>
        <div class="col-md-4">
					<div class="wow flipInY" data-wow-offset="0" data-wow-delay="1.2s">
						<div class="align-center">
							<h4>ENGLISH FOR KIDS</h4>
							<div class="icon">
								<i class="fa fa-comments fa-3x"></i>

							</div>
							<p>
							 We offer english courses for kids.
							</p>
						</div>
					</div>
				</div>
        <div class="col-md-4">
					<div class="wow flipInY" data-wow-offset="0" data-wow-delay="1.2s">
						<div class="align-center">
							<h4>PUBLIC SPEAKING</h4>
							<div class="icon">
								<i class="fa fa-bullhorn fa-3x"></i>

							</div>
							<p>
							 We offer english courses for public speaking.
							</p>
						</div>
					</div>
				</div>
        <div class="col-md-4">
					<div class="wow flipInY" data-wow-offset="0" data-wow-delay="1.2s">
						<div class="align-center">
							<h4>WRITING AND COMPOSITION</h4>
							<div class="icon">
								<i class="fa fa-file-text fa-3x"></i>

							</div>
							<p>
							 We offer english courses for writing and composition.
							</p>
						</div>
					</div>
				</div>
        <div class="col-md-4">
					<div class="wow flipInY" data-wow-offset="0" data-wow-delay="1.2s">
						<div class="align-center">
							<h4>READING AND COMPREHENSION</h4>
							<div class="icon">
								<i class="fa fa-book fa-3x"></i>

							</div>
							<p>
							 We offer english courses for reading and comprehension.
							</p>
						</div>
					</div>
				</div>
        <div class="col-md-4">
					<div class="wow flipInY" data-wow-offset="0" data-wow-delay="1.2s">
						<div class="align-center">
							<h4>LISTENING</h4>
							<div class="icon">
								<i class="fa fa-play fa-3x"></i>

							</div>
							<p>
							 We offer english courses for listening.
							</p>
						</div>
					</div>
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
