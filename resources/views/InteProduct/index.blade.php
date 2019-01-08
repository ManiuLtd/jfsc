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

</head>
<body>

@if($products)
	@foreach($products as $val)
		<div class="top-cover" style="width:100%;height:0;padding-bottom:62.5%;position: relative;"><img src="{{$val['product_image']}}" style="width:auto;height:auto;max-width:100%;max-height:100%;position: absolute;top: 50%;left: 50%;transform:translate(-50%,-50%);"></div>
		<div class="info">
			<input name="product_id" value="{{$val['product_id']}}" type="hidden">
			<h1>{{$val['product_name']}}</h1>@if($series_num)<p>兑换序号&nbsp;&nbsp;{{ $series_num }}</p>@else<span></span>@endif
			<p class="credits" id="cred">所需积分 {{$val['bonus_point']}}</p>
            <small class="exchange">剩余数量&nbsp;&nbsp;<span class="lastnum">{{$val['remaining_number']}}</span></small>
		</div>
		<!-- .info -->

		<div class="info">
			<h1>详细介绍</h1>
			<p>{{$val['product_description']}}</p>
		</div>
		<!-- .info -->

		<div style="height: 60px"></div>

		<div class="total"  style="bottom: 0;">
			<div class="row">
				<div class="col-xs-4 sum" style="overflow:visible;margin-left:0;padding-left:0;">扣除积分<span class="credits" id="credits" style="font-size: 13px;font-weight:bolder">{{$val['bonus_point']}}</span></div>
				<div class="col-xs-4 num"><button class="minus">-</button><span>1</span><button class="add">+</button></div>
                @if($val['product_kind']==1)
				<div class="col-xs-4" style="overflow:hidden;margin-left:0;padding-left:5px;"><button id="btn-exchanges" class="btn-exchange" >立即兑换</button></div>
                    @else
                    <div class="col-xs-4" style="overflow:hidden;margin-left:0;padding-left:5px;"><button id="newbtn-exchange" class="btn-exchange">立即兑换</button></div>
                @endif
			</div>
		</div>
	@endforeach
@else
	<div style="height:90vh;width:100%;display:table;"><p style="display: table-cell;width: auto;height:auto;text-align: center;vertical-align: middle;">商品不存在</p></div>
@endif
<div id="exchange-popup" style="display:none;z-index: 99;top:50%;left:50%;transform:translate(-50%,-50%);width:100%;height:100%;position:fixed;align-items: center;
		 justify-content: center;">
    <div class="popup">
        <a class="btn-close" href="#"></a>
        <div class="content">
            <img src="../InteMall/images/img_exchange_done.png" width="150">
            <h2>兑换成功</h2>
            <button onclick="location.href='{{action("InteRecordController@index")}}'">查看記錄</button>
            <a href="#" class="btn-default">好的</a>
        </div>
    </div>
</div>
<div id="exchange-fail" style="display:none;z-index: 99;top:50%;left:50%;transform:translate(-50%,-50%);width:100%;height:100%;position:fixed;align-items: center;
    justify-content: center;">
    <div class="popup" style="width: 78%;">
        <a class="btn-close" href="#"></a>
        <div class="content" style="text-align: center;">
            <img src="../InteMall/images/img_exchange_done.png" width="150">
            <h2 style="padding-bottom: 0;margin-top: 20px;font-size: 18px;">兑换失败，稍后重试</h2>
            <button onclick="location.href='{{action("InteRecordController@index")}}'" style="background: no-repeat;font-size: 14px;display: block;margin: 20px auto;color: #0077ff;border-bottom: 1px solid #0077ff;padding: 0;">查看記錄</button>
            <a href="#" class="btn-default">好的</a>
        </div>
    </div>
</div>
<div id="exchange-notenough" style="display:none;z-index: 99;top:50%;left:50%;transform:translate(-50%,-50%);width:100%;height:100%;position:fixed;align-items: center;
    justify-content: center;">
    <div class="popup" style="width: 78%;">
        <a class="btn-close" href="#"></a>
        <div class="content" style="text-align: center;">
            <img src="../InteMall/images/img_exchange_done.png" width="150">
            <h2 style="padding-bottom: 0;margin-top: 20px;font-size: 18px;">积分不足，请先赚取积分</h2>
            <button onclick="location.href='{{action("InteRecordController@index")}}'" style="background: no-repeat;font-size: 14px;display: block;margin: 20px auto;color: #0077ff;border-bottom: 1px solid #0077ff;padding: 0;">查看記錄</button>
            <a href="#" class="btn-default">好的</a>
        </div>
    </div>
</div>
<div id="exchange-newfail" style="display:none;z-index: 99;top:50%;left:50%;transform:translate(-50%,-50%);width:100%;height:100%;position:fixed;align-items: center;
    justify-content: center;">
    <div class="popup" style="width: 78%;">
        <a class="btn-close" href="#"></a>
        <div class="content" style="text-align: center;">
            <img src="../InteMall/images/img_exchange_done.png" width="150">
            <h2 style="padding-bottom: 0;margin-top: 20px;font-size: 18px;">库存不足，无法兑换</h2>
            <button onclick="location.href='{{action("InteRecordController@index")}}'" style="background: no-repeat;font-size: 14px;display: block;margin: 20px auto;color: #0077ff;border-bottom: 1px solid #0077ff;padding: 0;">查看記錄</button>
            <a href="#" class="btn-default">好的</a>
        </div>
    </div>
</div>
	<script src="../InteMall/js/jquery.min.js"></script>
<script>
    (function () {
        window.alert = function (name) {
            var iframe = document.createElement("IFRAME");
            iframe.style.display = "none";
            document.documentElement.appendChild(iframe);
            window.frames[0].window.alert(name);
            iframe.parentNode.removeChild(iframe);
        }
    })();
</script>
	<script>
		$(function(){
			var number = $('.num span').text();
			$('.minus').click(function(){
				if(number == 1){
                    number=1;
				}else{
                    number--;
                    $('.num span').text(number);
                    var str=$('#cred').text();
                    var count=str.replace(/[^0-9]/ig,"");
                    count=parseInt(count);
                    var num=parseInt(number);
                    $('#credits').text(count*num);
				}
			});
			$('.add').click(function(){
				number++;
				$('.num span').text(number);
                var str=$('#cred').text();
                var count=str.replace(/[^0-9]/ig,"");
                count=parseInt(count);
                var num=parseInt(number);
                $('#credits').text(count*num);
			});
		});
	</script>
<script>
      $('#btn-exchanges').click(function(){
          var countStr=$('#credits').text();
          var count=parseInt(countStr);
          //取得商品剩余数量
          var lastNum=$('.lastnum').text();
          var last=parseInt(lastNum);
          var product_id=$("input[name='product_id']").val();
          var number=parseInt($(".num span").text());
          $.ajax({
              url:"{{action('InteProductController@getInte')}}",
              type:'GET',
              success:function(obj){
                  //判断如果剩余商品数小于兑换数，提示库存不足
                  if(last<number)
                  {
                      $('#exchange-newfail').css('display','flex');
                      $('#exchange-newfail').css('overflow','hidden');
                  }
                  //反之则可以进行兑换操作
                  else
                  {
                      if(obj<count){
                          $('#exchange-notenough').css('display','flex');
                          $('#exchange-notenough').css('overflow','hidden');
                      }else{
                          window.location.href="addr" +"?product_id="+product_id+"&bonus_point="+count+"&remaining_number="+last+"&number="+number;
                      }
                  }

              },error:function(){
                  alert('错误');
              }
          });
	  });
</script>
<script>
    $('#newbtn-exchange').click(function(){
        var countStr=$('#credits').text();
        var count=parseInt(countStr);
        //取得商品剩余数量
        var lastNum=$('.lastnum').text();
        var last=parseInt(lastNum);
        var product_id=$("input[name='product_id']").val();
        var number=parseInt($(".num span").text());
        $.ajax({
            url:"{{action('InteProductController@getInte')}}",
            type:'GET',
            success:function(obj){
                //判断如果剩余商品数小于兑换数，提示库存不足
                if(last<number)
                {
                    $('#exchange-newfail').css('display','flex');
                    $('#exchange-newfail').css('overflow','hidden');
                }
                //反之则可以进行兑换操作
                else
                {
                    if(obj<count){
                        $('#exchange-notenough').css('display','flex');
                        $('#exchange-notenough').css('overflow','hidden');
                    }else{
                        $.ajax({
                            url:"{{action('InteProductController@exchange')}}",
                            type:'GET',
                            data:{'product_id':product_id,'number':number},
                            success:function(msg){
                                if(msg.success==1){
                                    $('#exchange-popup').css('display','flex');
                                    $('#exchange-popup').css('overflow','hidden');
                                    //setTimeout(function(){$('.popup').parent().fadeOut();},2000);
                                }else{
                                    $('#exchange-fail').css('display','flex');
                                    $('#exchange-fail').css('overflow','hidden');
                                }
                            },error:function(){
                                alert('兑换商品错误');window.location.href=" {{ url('InteMall/index') }}";
                            }
                        })
                    }
                }

            },error:function(){
                alert('错误');window.location.href=" {{ url('InteMall/index') }}";
            }
        });
    });
    $(".btn-default").click(function(){
        var str=$('#cred').text();
        var count=str.replace(/[^0-9]/ig,"");
        count=parseInt(count);
        $('#credits').text(count);
        $('.num span').text(1);
        $('.popup').parent().fadeOut();
    })
</script>
</body>
</html>