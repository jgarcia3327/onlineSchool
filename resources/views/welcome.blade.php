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
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
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
  			<div class="responsive-slider" data-spy="responsive-slider" data-autoplay="true" data-interval="4000" data-transitiontime="600">
  				<div class="slides" data-group="slides">
  					<ul>
  						<li>
  							<div class="slide-body" data-group="slide">
  								<img src="{{ asset('img/1.jpg') }}" alt="">
  								<div class="caption header" data-animate="slideAppearUpToDown" data-delay="500" data-length="300">
                    <div class="caption-body">
                      <h3>Học tiếng anh MỌI LÚC, MỌI NƠI cùng English Hours</h3>
                    </div>
                    <div class="caption-body-bottom">
                      <h3>There's always an HOUR to learn ENGLISH.<!-- <span class="sub-caption1">Học tiếng anh MỌI LÚC, MỌI NƠI cùng English Hours</span> --></h3>
                    </div>
                  </div>
  							</div>
  						</li>
  						<li>
  							<div class="slide-body" data-group="slide">
  								<img src="{{ asset('img/2.jpg') }}" alt="">
  								<div class="caption header" data-animate="slideAppearDownToUp" data-delay="500" data-length="300">
  									<div class="caption-body">
                      <h3>Với English Hours, SỰ TỰ TIN luôn đồng hành cùng bạn</h3>
                    </div>
                    <div class="caption-body-bottom">
                      <h3>Confidence comes from HOURS of learning ENGLISH.</h3>
                    </div>
  								</div>
  							</div>
  						</li>
  						<li>
  							<div class="slide-body" data-group="slide">
  								<img src="{{ asset('img/3.jpg') }}" alt="">
  								<div class="caption header" data-animate="slideAppearUpToDown" data-delay="500" data-length="300">
                    <div class="caption-body">
                      <h3>English Hour - phương pháp ƯU VIỆT SỐ 1 tại Việt Nam</h3>
                    </div>
                    <div class="caption-body-bottom">
                      <h3>ENGLISH HOUR is the best hour.</h3>
                    </div>
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
					<h2 class="intro-title">PHƯƠNG PHÁP HỌC TIẾNG ANH HIỆU QUẢ TỪ
            <br/>ENGLISH HOURS CENTER</h2>
            <p class="text-left"><strong>Chúng tôi tự tin sẽ mang đến cho bạn một phương pháp học hiệu quả, tiết kiệm và ưu việt nhất từ trước đến nay với những ưu điểm :</strong></p>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">LỚP HỌC TRỰC TIẾP 1 GIÁO VIÊN – 1 HỌC VIÊN</h3>
              </div>
              <div class="panel-body text-left">
                Khác với các phương pháp học trực tuyến khác, học viên được học bằng phương pháp đối thoại trực tiếp với giáo viên nước ngoài, được hướng dẫn, giảng dạy trong suốt buổi học 1 giáo viên /1 học viên.
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">GIÁO VIÊN NƯỚC NGOÀI TRÌNH ĐỘ CAO</h3>
              </div>
              <div class="panel-body text-left">
                100% giáo viên nước ngoài đến từ các quốc gia sử dụng tiếng anh làm ngôn ngữ chính thức, có chứng chỉ giảng dạy quốc tế TESOL, LET, TEFL, ..., có kinh nghiệm, trình độ cao, được tuyển chọn kĩ  bởi đội ngũ giáo viên có nhiều kinh nghiệm của trung tâm.
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">GIÁO TRÌNH EBOOK CHUYÊN NGHIỆP, HIỆN ĐẠI</h3>
              </div>
              <div class="panel-body text-left">
                Hệ thống tài liệu, giáo trình học đa dạng, phong phú,  liên tục được cập nhật phù hợp với nhu cầu của từng học viên ở mọi cấp độ.              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">THỜI GIAN LINH HOẠT – CHI PHÍ TIẾT KIỆM</h3>
              </div>
              <div class="panel-body text-left">
                Thời gian mỗi buổi học được sắp xếp linh động, phù hợp với thời gian của học viên, đặc biệt học viên được hoàn tiền buổi học đã đăng ký vào tài khoản gói học nếu học viên nghỉ học có thông báo trước với trung tâm.              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">ĐỘI NGŨ CHĂM SÓC HỌC VIÊN CHU ĐÁO</h3>
              </div>
              <div class="panel-body text-left">
                Đội ngũ tư vấn luôn sẵn sàng hỗ trợ học viên, đồng hành và tư vấn mọi thắc mắc của học viên trong suốt quá trình học. Đồng thời, giúp học viên xây dựng một lộ trình học tập phù hợp, hiệu quả.              </div>
            </div>
        </div>
			</div>
		</div>
	</div>

  <!-- Social Network -->
  <div class="container social-wrapper">
    <div class="row">
      <div class="col-lg-12 text-center">
          <ul class="social-network">
            <li><a href="mailto:info@englishhours.net" data-placement="top" title="info@englishhours.net" class="email-icon"><i class="fa fa-envelope fa-3x"></i></a></li>
            <li><a href="skype:live:aqua.dinh?call" data-placement="top" title="aqua.dinh" class="skype-icon"><i class="fa fa-skype fa-3x"></i></a></li>
            <li><a href="tel:0935680606" data-placement="top" title="Phone Numbers" class="phone-icon"><i class="fa fa-phone fa-3x"></i></a></li>
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
    				<h2>CÁC KHÓA HỌC</h2>
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
            <h3 class="course-title">LUYỆN VIẾT</h3>
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
            <h3 class="course-title">LUYỆN NGHE</h3>
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
    				<h2>PHẢN HỒI CỦA HỌC VIÊN</h2>
    				<hr>
    			</div>
    		</div>
    	</div>
      <div class="row feedback-wrapper">
        <div class="content feedback">
          <div class="col-md-12">
            <!-- List of user's feedback -->
            <?php $feeds = $common->getFeaturedFeeback(); ?>
            @foreach ($feeds AS $v)
            <div class="panel panel-default">
              <div class="panel-heading"><i class="fa fa-comment"></i> {{empty($v->student)? ucfirst($v->teacher) : ucfirst($v->student)}}</div>
              <div class="panel-body">
                {{$v->remark}}
              </div>
            </div>
            @endforeach

          </div>
        </div>
      </div>
    </div>

  </div>
	</div>
  <!-- end Courses and User Feedback -->

  <!-- Youtube videos -->
  <div class="container">
    <div class="row">
      <div class="recent">
        <h2>LỚP HỌC MẪU</h2>
        <hr>
      </div>
    </div>
    <div class="row">
      <div class="content">
        <div class="col-md-6">
          <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/-srL9IwaJ0A?rel=0&controls=0" frameborder="0" allowfullscreen></iframe>
          </div>
        </div>
        <div class="col-md-6">
          <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/V3jcyR_lIdk?rel=0&controls=0" frameborder="0" allowfullscreen></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end Youtube videos -->

  <!-- Teacher Profile -->
  <div class="container">
    <div class="row">
      <div class="recent">
        <h2>THÔNG TIN CỦA GIÁO VIÊN</h2>
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
              <p class="profile-name-link"><a class="text-success" href="{{ url('reserveTeacher/'.$v->user_id) }}">{{ ucfirst($v->fname) }} {{ ucfirst($v->lname) }}</a></p>
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

  <!--instruction-->

    <div class="container">
        <div class="row">
          <div class="recent">
            <h2>HƯỚNG DẪN CÁC BƯỚC ĐỂ HỌC</h2>
            <hr>
          </div>
        </div>
        <div class="row">
          <div class="row-slider">
            <div>
              <div class="col-lg-12 mar-bot30">

                <!-- Start slide -->
                <div id="EnglishHoursInstruction" class="carousel slide" data-ride="carousel" data-interval="false">
                  <!-- Indicators -->
                  <ol class="carousel-indicators">
                    @for ($i = 0; $i < 16; $i++)
                    <li data-target="#EnglishHoursInstruction" data-slide-to="{{$i}}" {{ ($i == 0)? "class=active" : ''}}></li>
                    @endfor
                  </ol>

                  <!-- Wrapper for slides -->
                  <div class="carousel-inner">
                    @for ($i = 1; $i <= 16; $i++)
                    <div class="item {{ ($i == 1)? 'active' : ''}}">
                      <img src="{{asset('img/instructions/'.$i.'.jpg')}}" alt="Hướng dẫn 6 bước học - ngang - {{$i}}">
                    </div>
                    @endfor
                  </div>

                  <!-- Left and right controls -->
                  <a class="left carousel-control" href="#EnglishHoursInstruction" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#EnglishHoursInstruction" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
                <!-- End slide -->

              </div>
            <div class="col-lg-12">
              <div class="wow fadeInUp" data-wow-offset="0" data-wow-delay="0.6s">
                <div class="thumnails">
                  <h4>HƯỚNG DẪN CHO HỌC VIÊN BẮT ĐẦU HỌC
                    <br/>TẠI ENGLISH HOURS</h4>
                  <ul class="instruction-summary">
                    <li>Bước 1: Cài đặt Skype và tạo tài khoản Skype</li>
                    <li>Bước 2: Đăng kí tài khoản học tại EnglishHours.net</li>
                    <li>Bước 3: Học phí và cách nộp học phí</li>
                    <li>Bước 4: Kích hoạt nạp tiền và mua gói học</li>
                    <li>Bước 5: Chọn giáo viên và đặt lịch học</li>
                    <li>Bước 6: Tiến hành học</li>
                    <li>Chú ý: Hướng dẫn và quy định khi hủy buổi học</li>
                  </ul>
                  <p class="instruction-summary">
                    <span style="display:block; padding-bottom: 9px;">CÁC BẠN CẦN HỖ TRỢ XIN LIÊN LẠC:</span>
                    <span style="display:block;">Inbox Facebook: <a href="https://www.facebook.com/tienganhquaskype" target="_blank">https://www.facebook.com/tienganhquaskype</a></span>
                    <span style="display:block;">Skype: <a href="skype:live:Englishhourscenter@gmail.com?call">Englishhourscenter@gmail.com</a></span>
                    <span style="display:block;">Điện thoại: <a href="tel:0935680606">0935 680 606</a></span>
                  </p>
                  <div class="ficon">
                    <a href="{{url('/uploaded_books/EnglishHours_manual.pdf')}}" alt="Hướng dẫn 6 bước học" target="_blank">Xem hướng dẫn chi tiết tại đây</a> <i class="fa fa-long-arrow-right"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  <!--/instruction-->

  <footer>
		<div id="sub-footer">
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						<div class="copyright">
							<p>
                <!--
                <span>Email: <a href="mailto:info@englishhours.net" target="_blank">info@englishhours.net</a></span>
                <span>Skype: <a href="skype:live:Englishhourscenter@gmail.com?call">Englishhourscenter@gmail.com</a></span>
                <span>Điện thoại: <a href="tel:0935680606">0935 680 606</a></span>
                <span>Facebook: <a href="https://www.facebook.com/tienganhquaskype" target="_blank">https://www.facebook.com/tienganhquaskype</a></span>
                -->
                <span>&copy; EnglishHours.net {{ date('Y') }}. All right reserved.</span>
              </p>
						</div>
					</div>
					<div class="col-lg-6">
            <!--
              <ul class="social-network">
                <li><a href="mailto:info@englishhours.net" data-placement="top" title="info@englishhours.net" class="email-icon"><i class="fa fa-envelope fa-3x"></i></a></li>
                <li><a href="skype:live:aqua.dinh?call" data-placement="top" title="aqua.dinh" class="skype-icon"><i class="fa fa-skype fa-3x"></i></a></li>
                <li><a href="tel:0935680606" data-placement="top" title="Phone Numbers"><i class="fa fa-phone fa-3x"></i></a></li>
                <li><a href="https://www.facebook.com/Tienganhquaskype/" data-placement="top" title="Facebook" class="facebook-icon"><i class="fa fa-facebook fa-3x"></i></a></li>
              </ul>
            -->
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
	 {}	)
		.init();
	</script>
  </body>
</html>
