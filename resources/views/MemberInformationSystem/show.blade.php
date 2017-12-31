<!DOCTYPE html>
<html>
	<head>
		<title>Show</title>
		<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="../js/jquery.min.js"></script>
		<!-- Custom Theme files -->
		<!--theme-style-->
		<link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
		<!--//theme-style-->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="" />
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		<!--fonts-->
		<link href='https://fonts.googleapis.com/css?family=Exo:100,200,300,400,500,600,700,800,900' rel='stylesheet' type='text/css'>
		<!--//fonts-->
		<script type="text/javascript" src="../js/move-top.js"></script>
		<script type="text/javascript" src="../js/easing.js"></script>
						<script type="text/javascript">
							jQuery(document).ready(function($) {
								$(".scroll").click(function(event){
									event.preventDefault();
									$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
								});
							});
						</script>
		<!--slider-script-->
				<script src="../js/responsiveslides.min.js"></script>
					<script>
						$(function () {
						$("#slider1").responsiveSlides({
							auto: true,
							speed: 500,
							namespace: "callbacks",
							pager: true,
						});
						});
					</script>
		<!--//slider-script-->
		<script>$(document).ready(function(c) {
			$('.alert-close').on('click', function(c){
				$('.message').fadeOut('slow', function(c){
					$('.message').remove();
				});
			});
		});
		</script>
		<script>$(document).ready(function(c) {
			$('.alert-close1').on('click', function(c){
				$('.message1').fadeOut('slow', function(c){
					$('.message1').remove();
				});
			});
		});
		</script>
	</head>
<body>
<!--header-->
<div class="header">
	<div class="header-top">
		<div class="container">
			<div class="header-top-in">
				<div class="logo">
					<a href="{{ url('/') }}">
						<img src="/wm.jpg" alt="Smiley face" height="30" width="30" style="display:inline;">AATS</a>
				</div>
				<div class="header-in">
					<ul class="icon1 sub-icon1">
						@guest
						<li>
							<a href="{{ route('login') }}">Login</a>
						</li>
						<li>
							<a href="{{ route('register') }}">Register</a>
						</li>
						@else
						<li class="dropdown">
							<a href="/user/{{ Auth::user()->id }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"
							 aria-haspopup="true">
								{{ Auth::user()->name }}
							</a>
						</li>
						<li>
							<a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
								Logout
							</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
						</li>
						@endguest
					</ul>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<div class="header-bottom">
		<div class="container">
			<div class="h_menu4">
				<a class="toggleMenu" href="#">Menu</a>
				<ul class="nav">
					<li>
						<a href="{{ url('/') }}">
							<i> </i>首頁</a>
					</li>
					<li>
						<a href="/product">商品瀏覽</a>
					</li>
					<li>
						<a href="/shop/list">購物車</a>
					</li>
					<li>
						<a href="/product/create">管理系統</a>
						<ul class="drop">
							<li>
								<a href="/discount/serch">折扣管理系統</a>
							</li>
							<li>
								<a href="/shop/serch">訂單管理系統</a>
							</li>
							<li>
								<a href="/user/type">會員管理系統</a>
							</li>
							<li>
								<a href="/product/create">財務報表系統</a>
							</li>
						</ul>
					</li>
					<div class="container">
						<div class="header-bottom-on">
							<div class="header-can">
								<div class="search">
									<form action='/product/serch' method='get'>
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="text" name='key' value="search" onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = '';}">
										<input type="submit" value="">
									</form>
								</div>

								<div class="clearfix"> </div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</ul>

				<script type="text/javascript" src="../js/nav.js"></script>
			</div>

		</div>
	</div>
</div>
<!---->
  		<div class="container">
  			<div class="products">
  					<h2 class=" products-in">會員資訊</h2>
  					<div class="clearfix"></div>
  					<div class="col-md-6 contact-top">
  						<table class="table table-hover">
  							<thead>
  								<tr>
  									<th><h3>項目</h3></th>
  									<th><h3>內容</h3></th>
  								</tr>
  							</thead>
  							<tbody>
  								<tr>
  									<td>Name</td>
  									<td>{{$users[0]->name}}</td>
                                </tr>
                                <tr>
  									<td>User Type</td>
  									<td>{{$users[0]->user_type}}</td>
                                </tr>
                                <tr>
  									<td>加入時間</td>
  									<td>{{$users[0]->created_at}}</td>
  								</tr>
  								<tr>
  									<td>Email</td>
  									<td>{{$users[0]->email}}</td>
  								</tr>
  								<tr>
  									<td>Birthday</td>
  									<td>{{$users[0]->birthday}}</td>
  								</tr>
                                <tr>
                                    <td>ID Card Number</td>
                                    <td>{{$users[0]->Identity_card_number}}</td>
                                </tr>
                                <tr>
                                    <td>Sex</td>
                                    <td>{{$users[0]->sex}}</td>
                                </tr>
                                <tr>
  									<td>Phone</td>
  									<td>{{$users[0]->phont}}</td>
  								</tr>
                                <tr>
  									<td>address</td>
  									<td>{{$users[0]->address}}</td>
                                </tr>
                                
  							</tbody>
  						</table>
  					</div>
  					<div class="clearfix"></div>
  					<div class="white">
                        <a href="/user/{{Auth::user()->id}}/edit" class="hvr-shutter-in-vertical hvr-shutter-in-vertical2">修改</a>
  					</div>
  			</div>
  		</div>

		<!---->
		<div class="footer">
			<p class="footer-class">Copyright &copy; 2017.北科資工資料庫Project</p>
			<script type="text/javascript">
						$(document).ready(function() {
							/*
							var defaults = {
					  			containerID: 'toTop', // fading element id
								containerHoverID: 'toTopHover', // fading element hover id
								scrollSpeed: 1200,
								easingType: 'linear'
					 		};
							*/

							$().UItoTop({ easingType: 'easeOutQuart' });

						});
					</script>
				<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>

		</div>
</body>
</html>
