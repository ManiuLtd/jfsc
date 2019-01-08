<!DOCTYPE html>
<html>
<head>
	<title>富连网物联网智能家居--积分商城</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes">

	<link rel="stylesheet" href="../InteMall/css/bootstrap.css">
	<link rel="stylesheet" href="../InteMall/css/style.css">
	<script src="../InteMall/js/jquery-3.3.1.min.js"></script>
	<!-- SlideBanner -->
	<link rel="stylesheet" href="../InteMall/js/sliderBanner/slippry.css">
	<!-- Animsition -->
	<link rel="stylesheet" href="../InteMall/js/animsitionMaster/animsition.min.css">
	<!-- Modernizr JS -->
	<script src="../InteMall/js/modernizr.js"></script>
</head>
<body>
<div class="wrapper">
	<div class="member shop">
		<div class="container">
			<div class="list">
				<div class="photo">
					<a href="http://iot.flnet.com/displayManage"><img src="{{session('newimage')}}" class="user-photo"></a>
				</div>
				<div class="right">
					<div class="name">
						<a href="http://iot.flnet.com/displayManage">{{session('nickname')}}</a>
						<span class="credits">积分
							@if($res['remaining_point']=='')
								0
							@else
								{{$res['remaining_point']}}
							@endif
						<p>待审核积分
							@if($res['not_active_point']=='')
								0
							@else
								{{$res['not_active_point']}}
							@endif
						</p>
						</span>
					</div>
					<div class="sign" style="text-align: center;">
						@if($status==0)
							<button class="edit fin" id="sign_btn">签到</button>
						@else
							<button class="edit finish" id="sign_btn">已签到</button>
						@endif
						<p class="total-sign y" style="text-align: center;">累计签到{{$count}}日</p>
					</div>
				</div>
				<ul class="function-list">
					<li><a href="{{action('InteMethodController@index')}}"><i class="icon-getcredit"></i>赚取积分</a></li>
					<li><a href="{{action('InteDetailsController@index')}}"><i class="icon-creditlist"></i>积分明细</a></li>
					<li><a href="{{action('InteRecordController@index')}}"><i class="icon-record"></i>兑换纪录</a></li>
				</ul>
				<!--Slider-->
				<div class="carousel-inner">
					<ul id="ad">
						@if($banner1->banner_path)
						<li>
							<a href="{{$banner1->banner_url}}" target="_blank"><img src="{{$banner1->banner_path}}" class="img-responsive" style="width:100%;" alt=""></a>
						</li>
						@endif
						@if($banner2->banner_path)
						<li>
							<a href="{{$banner2->banner_url}}" target="_blank"><img src="{{$banner2->banner_path}}" class="img-responsive" style="width:100%;" alt=""></a>
						</li>
						@endif
						@if($banner3->banner_path)
						<li>
							<a href="{{$banner3->banner_url}}" target="_blank"><img src="{{$banner3->banner_path}}" class="img-responsive" style="width:100%;" alt=""></a>
						</li>
						@endif
					</ul>
				</div>
				<!-- End of Slider -->
				{{--<div class="carousel-inner">--}}
					{{--<ul id="ad">--}}
						{{--<li><a href="{{$banner1->banner_url}}" target="_blank"><img src="{{$banner1->banner_path}}" class="img-responsive" style="width:100%;" alt=""></a></li>--}}
						{{--<li><a href="{{$banner2->banner_url}}" target="_blank"><img src="{{$banner2->banner_path}}" class="img-responsive" style="width:100%;" alt=""></a></li>--}}
						{{--<li><a href="{{$banner3->banner_url}}" target="_blank"><img src="{{$banner3->banner_path}}" class="img-responsive" style="width:100%;" alt=""></a></li>--}}
					{{--</ul>--}}
				{{--</div>--}}
			</div>
		</div>
	</div>
    @if($arr['classes'])
        @foreach($arr['classes'] as $val)
            <div class="panel">
                <div class="container">
                    <h2>{{$val['class_name']}}<a href="{{action('InteListController@index',['class_id'=>$val['class_id']])}}" class="y">更多<i class="icon-angle-right"></i></a></h2>
                        @if($arr['products'])
                            @foreach($arr['products'] as $vo)
                                @if($vo['class_id']==$val['class_id'])
                                    <div class="block" style="text-align: center;">
                                        <a href="{{action('InteProductController@index',['product_id'=>$vo['product_id']])}}">
                                            <div class="cover" style="width:100%;height:0;padding-bottom:62.5%;position: relative;"><img src="{{$vo['product_image']}}" style="width:auto;height:auto;max-width:100%;max-height:100%;position: absolute;top: 50%;left: 50%;transform:translate(-50%,-50%);"></div>
                                            <p>{{$vo['product_name']}}<p class="credits">积分{{$vo['bonus_point']}}</p>
                                            <a href="{{action('InteProductController@index',['product_id'=>$vo['product_id']])}}" class="btn-get">立即兑换</a>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        @else
						<div style="height:30vh;width:100%;display:table;"><p style="display: table-cell;width: auto;height:auto;text-align: center;vertical-align: middle;">该分类下暂无商品</p></div>
                        @endif
                </div>
            </div>
        @endforeach
    @else
		<div style="height:30vh;width:100%;display:table;"><p style="display: table-cell;width: auto;height:auto;text-align: center;vertical-align: middle;">暂无商品</p></div>
	@endif
	<div class="footer">
		<ul>
			<li><a href="{{ url('aboutflnet') }}">关于富连网<span>|</span></a></li>
			<li><a href="#contact-popup" id="contact">联络客服<span>|</span></a></li>
			<li><a href="{{ url('service-terms') }}">服务协议<span>|</span></a></li>
			<li><a href="{{ url('privacy') }}">隐私权政策</a></li>
		</ul>
		<div class="copyright">© 2017-2018 富连网会员服务</div>
	</div>
	{{--<div style="height:60px"></div>--}}
</div>
<div id="tabar" style="bottom: 0;">
	<ul>
		<li><a href="{{action('Auth\RegisterController@succUrl')}}"><i class="ico ico-home"></i>首页</a></li>
		<li class="active"><a href="{{action('InteMallController@index')}}"><i class="ico ico-shop"></i>积分商城</a></li>
		<li><a href="{{action('Auth\RegisterController@displayManage')}}"><i class="ico ico-my"></i>我的</a></li>
	</ul>
</div>
<div id="sign-popup" style="display:none;z-index: 99;top:50%;left:50%;transform:translate(-50%,-50%);width:100%;height:100%;position:fixed;align-items: center;
    justify-content: center;">
	<div class="popup">
		<a class="btn-close" href="#"></a>
		<div class="content">
			<img src="../InteMall/images/img_sign_done.png" width="135">
			<h2>签到成功！</h2>
			<button onclick="location.href='{{action("InteDetailsController@index")}}'">查看記錄</button>
			<a href="#" class="btn-default">好的</a>
		</div>
	</div>
</div>
<div id="sign-over" style="display:none;z-index: 99;top:50%;left:50%;transform:translate(-50%,-50%);width:100%;height:100%;position:fixed;align-items: center;
    justify-content: center;">
    <div class="popup" style="width: 78%;">
        <a class="btn-close" href="#"></a>
        <div class="content" style="text-align: center;">
            <img src="../InteMall/images/img_sign_done.png" width="135">
            <h2 style="padding-bottom: 0;margin-top: 20px;font-size: 18px;">今日已签到，明日再来喔！</h2>
            <button onclick="location.href='{{action("InteDetailsController@index")}}'" style="background: no-repeat;font-size: 14px;display: block;margin: 20px auto;color: #0077ff;border-bottom: 1px solid #0077ff;padding: 0;">查看記錄</button>
            <a href="#" class="btn-default">好的</a>
        </div>
    </div>
</div>
<div id="sign-fail" style="display:none;z-index: 99;top:50%;left:50%;transform:translate(-50%,-50%);width:100%;height:100%;position:fixed;align-items: center;
    justify-content: center;">
    <div class="popup" style="width: 78%;">
        <a class="btn-close" href="#"></a>
        <div class="content" style="text-align: center;">
            <img src="../InteMall/images/img_sign_done.png" width="135">
            <h2 style="padding-bottom: 0;margin-top: 20px;font-size: 18px;">签到失败，请稍后重试！</h2>
            <button onclick="location.href='{{action("InteDetailsController@index")}}'" style="background: no-repeat;font-size: 14px;display: block;margin: 20px auto;color: #0077ff;border-bottom: 1px solid #0077ff;padding: 0;">查看記錄</button>
            <a href="#" class="btn-default">好的</a>
        </div>
    </div>
</div>
<div id="contact-popup" style="display:none;z-index: 99;top:50%;left:50%;transform:translate(-50%,-50%);width:100%;height:100%;position:fixed;align-items: center;
    justify-content: center;">
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
<script src="js/jquery.min.js"></script>
<script src="js/sliderBanner/slippry.min.js"></script>
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
<script type="text/javascript">
    $(function() {
        $('#sign_btn').click(function(){
            $.ajax({
				url:"{{action('InteMallController@getStatus')}}",
				type:'GET',
				dataType:'json',
                success:function(obj){
				    if(obj.code==1){
                        $('.edit.y').text('已签到');
                        $('.edit.y').css('background','#bebebe');
						$('#sign-popup').css('display','flex');
                        $('#sign-popup').css('overflow','hidden');
					}else if(obj.code==2){
                        $('#sign-over').css('display','flex');
                        $('#sign-over').css('overflow','hidden');
					}else if(obj.code==0){
                        $('#sign-fail').css('display','flex');
                        $('#sign-fail').css('overflow','hidden');
                    }
				}
			})
		});
        $('#contact').click(function(){
            $('#contact-popup').css('display','flex');
            $('#contact-popup').css('overflow','hidden');
        });
		$(".btn-default").click(function(){
            $('.popup').parent().fadeOut();
            window.location.reload();
		})
    });
</script>
</body>
</html>