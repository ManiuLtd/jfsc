<!DOCTYPE html>
<html>
<head>
	<title>富连网物联网智能家居--积分商城</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes">
	<link rel="stylesheet" href="../InteMall/css/bootstrap.css">
	<link rel="stylesheet" href="../InteMall/css/style.css">
	<script src="../InteMall/js/jquery-3.3.1.min.js"></script>
	<script src="../InteMall/js/modernizr.js"></script>
	<script src="../InteMall/js/respond.min.js"></script>
</head>
<body class="bg-credit">
	<div class="container">
		<div class="paper">
			<div class="content">
				<div class="diagram">
					<div><i class="icon-angle-left" onclick="reduce();"></i><span>{{$thisMonth}}</span><i class="icon-angle-right" onclick="add();"></i></div>
					<hr>
					<div id="lineChart" style="height: 230px;overflow:hidden;"></div>
					<input id="lineContents" type="hidden">
				</div>
				<div class="line"></div>
				<div id="content-list">
				@if($arr['list'])
					@foreach($arr['list'] as $vol)
						<div class="list small">
							@if($vol['definition']=='首次登入奖励')
								<i class="icon-login"></i>
							@elseif($vol['definition']=='每天签到成功')
								<i class="icon-sign"></i>
							@elseif($vol['definition']=='分享文章')
								<i class="icon-share"></i>
							@elseif($vol['definition']=='绑定设备')
								<i class="icon-device"></i>
							@elseif($vol['definition']=='vip影视充值权益')
								<i class="icon-video"></i>
							@elseif($vol['definition']=='vip影视退款')
								<i class="icon-comment"></i>
							@elseif($vol['definition']=='个人資料完善')
								<i class="icon-data"></i>
							@else
								<i class="icon-activity"></i>
							@endif
							@if($vol['definition']=='vip影视退款')
								<div class="left">{{$vol['definition']}} <p class="description">-{{$vol['bonus_point']}}积分&nbsp;&nbsp;<span style="color:#0077ff !important">@if($vol['is_active']==1)*已生效@else*未生效@endif</span></p></div>
							@else
								<div class="left">{{$vol['definition']}} <p class="description">+{{$vol['bonus_point']}}积分&nbsp;&nbsp;<span style="color:#0077ff !important">@if($vol['is_active']==1)*已生效@else*未生效@endif</span></p></div>
							@endif
							<div class="right unlink">{{$vol['original_created_at']}}</div>
						</div>
					@endforeach
				@else
						<div style='height:40vh;width:100%;display:table;'><p style='display: table-cell;width: auto;height:auto;text-align: center;vertical-align: middle;'>暂无积分记录</p></div>
				@endif
				</div>
			</div>
		</div>
		<div class="shadow"></div>
	</div>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/echarts.min.js"></script>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts-gl/echarts-gl.min.js"></script>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts-stat/ecStat.min.js"></script>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/dataTool.min.js"></script>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/china.js"></script>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/world.js"></script>
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=ZUONbpqGBsYGXNIYHicvbAbM"></script>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/bmap.min.js"></script>
	<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/simplex.js"></script>
	<!-- highcharts -->
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<script>
        function reduce(){
            $('#content-list').empty();
            var str=$('.diagram span').text();
            var aa=str.split('-');
            if(parseInt(aa[1])>1){
                var month=parseInt(aa[1])-1;
                var year=parseInt(aa[0]);
            }else if(parseInt(aa[1])==1){
                var year=parseInt(aa[0])-1;
                var month=12;
            }
            if(month<10){
                month='0'+month;
            }
            var dates=year+'-'+month;
            $('.diagram span').text(dates);
            ajaxline(dates);
            InteContents(dates);
        }
        function add(){
            $('#content-list').empty();
            var str=$('.diagram span').text();
            var aa=str.split('-');
            if(parseInt(aa[1])<12){
                var month=parseInt(aa[1])+1;
                var year=parseInt(aa[0]);
            }else if(parseInt(aa[1])==12){
                var year=parseInt(aa[0])+1;
                var month=1;
            }
            if(month<10){
                month='0'+month;
            }
            var dates=year+'-'+month;
            $('.diagram span').text(dates);
            ajaxline(dates);
            InteContents(dates);
        }
        function InteContents(dates){
            $.ajax({
                type:'GET',
                url:"{{action('InteDetailsController@resContents')}}",
                data:{'dates':dates},
                success:function(res){
                    if(res.success==1){
                        if(res.list!=''){
                            $.each(res.list,function(key,val){
                                var icons='';
                                var contents='';
                                if(val['definition']=='首次登入奖励'){
                                    icons='<i class="icon-login"></i>';
                                }else if(val['definition']=='每天签到成功'){
                                    icons='<i class="icon-sign"></i>';
                                }else if(val['definition']=='分享文章'){
                                    icons='<i class="icon-share"></i>';
                                }else if(val['definition']=='绑定设备'){
                                    icons='<i class="icon-device"></i>';
                                }else if(val['definition']=='vip影视充值权益'){
                                    icons='<i class="icon-video"></i>';
                                }else if(val['definition']=='vip影视退款'){
                                    icons='<i class="icon-comment"></i>';
                                }else if(val['definition']=='个人資料完善'){
                                    icons='<i class="icon-data"></i>';
                                }else{
                                    icons='<i class="icon-activity"></i>';
                                }
                                if(val['definition']=='vip影视退款'){
                                    if(val['is_active']==1){
                                        contents='<div class="left">'+val['definition']+'<p class="description">-'+val['bonus_point']+'积分&nbsp;&nbsp;<span style="color:#0077ff !important">*生效</span></p></div>';
                                    }else{
                                        contents='<div class="left">'+val['definition']+'<p class="description">-'+val['bonus_point']+'积分&nbsp;&nbsp;<span style="color:#0077ff !important">*未生效</span></p></div>';
                                    }
                                }else{
                                    if(val['is_active']==2){
                                        contents='<div class="left">'+val['definition']+'<p class="description">+'+val['bonus_point']+'积分&nbsp;&nbsp;<span style="color:#0077ff !important">*生效</span></p></div>';
                                    }else{
                                        contents='<div class="left">'+val['definition']+'<p class="description">+'+val['bonus_point']+'积分&nbsp;&nbsp;<span style="color:#0077ff !important">*未生效</span></p></div>';
                                    }
                                }
                                var date = new Date(val['created_at'] * 1000);
                                var Y = date.getFullYear() + '-';
                                var M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
                                var D = date.getDate() + ' ';
                                var datestime=Y+M+D;
                                var times='<div class="right unlink">'+datestime+'</div>';
                                $('#content-list').append('<div class="list small">'+icons+contents+times+'</div>');
                            })
                        }else{
                            $('#content-list').append("<div style='height:40vh;width:100%;display:table;'><p style='display: table-cell;width: auto;height:auto;text-align: center;vertical-align: middle;'>暂无积分记录</p></div>");
                        }
                    }else{
                        $('#content-list').append("<div style='height:40vh;width:100%;display:table;'><p style='display: table-cell;width: auto;height:auto;text-align: center;vertical-align: middle;'>暂无积分记录</p></div>");
                    }
                },error:function(){
                    alert('错误');
                }
            })
        }
        function ajaxline(dates){
            $.ajax({
                type:'GET',
                url:"{{action('InteDetailsController@curve')}}",
                data:{'dates':dates},
                dataType:'json',
                success:function(res){
                    var linecon=[];
                    $.each(res,function(index,item){
                        linecon.push(item);
                    });
                    viewchart(linecon);
                }
            })
        }
       function viewchart(linecon){
           Highcharts.chart('lineChart', {
               chart: {
                   type: 'spline',
               },
               title: {
                   text: ''
               },
               exporting: {
                   enabled: false
               },
               legend: {
                   enabled: false
               },
               xAxis: {
                   categories: ['01', '03', '05', '07', '09', '11', '13', '15', '17', '19', '21', '23', '25', '27', '29', '31'],
                   labels: {
                       style: { "color": "#ccc" }
                   },
                   tickColor: '#E9E9E9',
                   tickLength: 5
               },
               yAxis: {
                   title: {
                       text: ''
                   },
                   labels: {
                       style: { "color": "#ccc" }
                   }
               },
               colors: ['#0077ff'],

               plotOptions: {
                   spline: {
                       lineWidth: 3,
                       states: {
                           hover: {
                               lineWidth: 5
                           }
                       },
                       marker: {
                           enabled: false
                       },
                   }
               },
               series: [{
                   name: 'credit',
                   data: linecon,
                   //data: [1, 3, 5, 6, 4, 3, 5, 10, 3, 8, 6, 3, 7, 9, 2, 3, 5, 2, 3, 6, 4, 3, 2, 0, 5, 6, 4, 8, 3, 1, 6],
                   marker: {
                       enabled: false
                   },
               }],

           });
	   }
			Highcharts.chart('lineChart', {
				chart: {
					type: 'spline',
				},
				title: {
					text: ''
				},
				exporting: {
					enabled: false
				},
				legend: {
					enabled: false
				},
				xAxis: {
					categories: ['01', '03', '05', '07', '09', '11', '13', '15', '17', '19', '21', '23', '25', '27', '29', '31'],
					labels: {
						style: { "color": "#ccc" }
					},
					tickColor: '#E9E9E9',
					tickLength: 5
				},
				yAxis: {
					title: {
						text: ''
					},
					labels: {
						style: { "color": "#ccc" }
					}
				},
				colors: ['#0077ff'],

				plotOptions: {
					spline: {
						lineWidth: 3,
						states: {
							hover: {
								lineWidth: 5
							}
						},
						marker: {
							enabled: false
						},
					}
				},
				series: [{
					name: 'credit',
					data: [{{$curve_line}}],
					marker: {
						enabled: false
					},
				}],

			});
	</script>
</body>

</html>