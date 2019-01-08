<!DOCTYPE html>
<html>

<head>
	<title>富连网物联网智能家居--积分商城</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="../InteMall/css/bootstrap.css">
	<!-- MainCSS -->
	<link rel="stylesheet" href="../InteMall/css/style.css">
	<!-- SlideBanner -->
	<link rel="stylesheet" href="../InteMall/js/sliderBanner/slippry.css">
	<!-- Modernizr JS -->
	<script src="../InteMall/js/modernizr.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
		<script src="../InteMall/js/respond.min.js"></script>
	<![endif]-->
</head>

<body>

	<!-- <header><a href="index.html"><i class="icon-cancel"></i></a>为您精选</header> -->

<div class="wrapper container itemlist">
	@if($product)
		@foreach($product as $val)
			<div class="block">
				<a href="{{action('InteProductController@index',['product_id'=>$val['product_id']])}}">
					<div class="tag hot">热门</div>
					<div class="cover" style="width:100%;height:0;padding-bottom:62.5%;position: relative;"><img src="{{$val['product_image']}}" style="width:auto;height:auto;max-width:100%;max-height:100%;position: absolute;top: 50%;left: 50%;transform:translate(-50%,-50%);"></div>
					<p>{{$val['product_name']}}<p class="credits">积分{{$val['bonus_point']}}</p>
					<a href="{{action('InteProductController@index',['product_id'=>$val['product_id']])}}" class="btn-get">立即兑换</a>
				</a>
			</div>
		@endforeach
	@else
		<div style="height:90vh;width:100%;display:table;"><p style="display: table-cell;width: auto;height:auto;text-align: center;vertical-align: middle;">该分类下暂无产品</p></div>
	@endif
	<div class="footer">
		<ul>
			<li><a href="{{ url('aboutflnet') }}">关于富连网<span>|</span></a></li>
			<li><a href="#contact-popup">联络客服<span>|</span></a></li>
			<li><a href="{{ url('service-terms') }}">服务协议<span>|</span></a></li>
			<li><a href="{{ url('privacy') }}">隐私权政策</a></li>
		</ul>
		<div class="copyright">© 2017-2018 富连网会员服务</div>
	</div>
</div><!--wrapper -->	

	<!-- 置底選單列 -->
	<div id="tabar"  style="bottom: 0;">
		<ul>
			<li><a href="{{action('Auth\RegisterController@newDisplay')}}"><i class="ico ico-home"></i>首页</a></li>
			<li class="active"><a href="{{action('InteMallController@index')}}"><i class="ico ico-shop"></i>积分商城</a></li>
			<li><a href="{{action('Auth\RegisterController@displayManage')}}"><i class="ico ico-my"></i>我的</a></li>
		</ul>
	</div>


	<div id="contact-popup" class="overlay">
		<div class="popup">
			<a class="btn-close" href="#"></a>
			<div class="content">
				<center><h2>联络客服</h2></center>
				客服热线：<a href="tel:400-823-1900">400-823-1900</a><br>服务时间：24小时服务（法定节假日除外）
				<br><br><center><a href="#" class="btn-default">我知道了</a></center>
			</div>
		</div>
	</div>

	<!-- BannerSlider-->
	<script src="../InteMall/js/jquery.min.js"></script>
    <script src="../InteMall/js/sliderBanner/slippry.min.js"></script>
    <script type="text/javascript">
	    $(function() {
	        var slider = $("#ad").slippry({
	            transition: 'horizontal',				
	        });
	        $('.prev').click(function() {
	            slider.goToPrevSlide();
	            return false;
	        });
	        $('.next').click(function() {
	            slider.goToNextSlide();
	            return false;
            });
        });
    </script>

	
</body>

</html>