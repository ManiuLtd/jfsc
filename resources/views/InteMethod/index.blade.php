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

	<!-- Modernizr JS -->
	<script src="../InteMall/js/modernizr.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="../InteMall/js/respond.min.js"></script>
	<![endif]-->
</head>
<body class="bg-credit">
<div class="container">
	<div class="paper">
		<div class="content">
			<div class="credit">
				<h3>@if($arr['remaining_point']=='')
						0
						@else
						{{$arr['remaining_point']}}
						@endif
					<span style="font-size: 0.25em;">积分</span></h3>
				<p class="today">待审核积分
					@if($arr['not_active_point']=='')
						0
					@else
						{{$arr['not_active_point']}}
					@endif
					| 今日已赚取
					@if($today_point=='')
						0
					@else
						{{$today_point}}
					@endif
					积分</p>
			</div>
			<div class="line"></div>
			@if(!empty($res))
				@foreach($res as $vo)
					@if($vo->integral_id==6)
					@else
						<div class="list">
							<i class="{{$vo->integral_icon}}"></i>
							<div class="left">{{$vo->integral_name}} <span class="credits">{{$vo->integral_point}}</span><p class="description">{{$vo->integral_contents}}</p></div>
							<div class="right unlink">
								<a href="{{$vo->integral_url}}">去完成</a>
								<i class="icon-angle-right"></i>
							</div>
						</div>
					@endif
				@endforeach
			@else
				暂无赚取积分方法
			@endif
		</div><!-- .content -->
	</div>
	<div class="shadow"></div>
</div>
</body>
</html>