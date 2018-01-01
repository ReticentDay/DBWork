<!DOCTYPE html>
<html>
<head>
    <title>Fix</title>
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
									<a href="/discount/create">折扣管理系統</a>
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
										<form>
											<input type="text" value="Search" onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = '';}">
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
            <h2 class=" products-in">訂單</h2>
            <div class="clearfix"></div>
            <div class="col-md-6 contact-top">
                <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><h3>下單人ID</h3></th>
                                <th><h3>下單人姓名</h3></th>
                                <th><h3>下單人identity</h3></th>
                                <th><h3>下單人地址</h3></th>
                                <th><h3>單號</h3></th>
                                <th><h3>狀態</h3></th>
                                <th><h3>下單日期</h3></th>
                            </tr>
                        </thead>
                        <tbody>
                           <tr>
                               <th>{{$orderList[0]->id}}</th>
                               <th>{{$orderList[0]->name}}</th>
                               <th>{{$orderList[0]->identity_card_number}}</th>
                               <th>{{$orderList[0]->address}}</th>
                               <th>{{$orderList[0]->shop_id}}</th>
                               <th>{{$orderList[0]->state}}</th>
                               <th>{{$orderList[0]->buy_date}}</th>
                           </tr>
                        </tbody>
                    </table>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><h3>品名</h3></th>
                                <th><h3>單價</h3></th>
                                <th><h3>數量</h3></th>
							    <th><h3>折扣</h3></th>
                                <th><h3>售價</h3></th>
                                <th><h3>總金額</h3></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orderList as $order)
                            <tr>
                                <td>{{$order->product_name}}</td>
                                <td>{{$order->price}}</td>
                                <th>{{$order->quantity}}</th>
                                <td>
                                    @if($order->rate != null)
                                        {{$order->rate}}
                                    @else
                                        1
                                    @endif
                                </td>
                                <td>
                                    @if($order->rate != null)
                                        {{$order->quantity * $order->price * $order->rate}}
                                    @else
                                        {{$order->quantity * $order->price}}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$total}}</td>
                            </tr>
                        </tbody>
                    </table>
                <form action="/shop/{{$orderList[0]->shop_id}}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <select name='state'>
                        <option value='Not delivered'>未出貨</option>
                        <option value='Delivered'>出貨</option>
                    </select>
                    <input type='submit' value='修改'>
                </form>
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
