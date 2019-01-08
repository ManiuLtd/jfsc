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
	<!-- Modernizr JS -->
	<script src="../InteMall/js/modernizr.js"></script>

</head>

<body>

<div class="info">
    <h1 style="margin:10px 0;">收件信息</h1>
      <form class="address"  method="post" autocomplete="off" id="addr_form">
          {{ csrf_field() }}
          <input type="hidden" name="product_id" value="{{ $product_id }}" />
          <input type="hidden" name="remaining_number" value="{{ $remaining_number }}" />
          <input type="hidden" name="number" value="{{ $number }}" />
          <input type="hidden" name="bonus_point" value="{{ $bonus_point }}" />
        <div class="row form-group">
            <label class="col-xs-12">地址信息 <span class="star">*</span></label>
            <div class="col-xs-12">
                <div class="selectwrap"><select id="s_province" name="s_province" value="{{ session('s_province') }}"  class="form-control"><option value="{{ session('s_province') }}">{{ session('s_province') }}</option></select></div>
                <div class="selectwrap" style="margin-left:6px;"><select id="s_city" name="s_city" value="{{ session('s_city')  }}" class="form-control"><option value="{{ session('s_city')  }}">{{ session('s_city')  }}</option></select></div>
                <div class="selectwrap" style="margin-left:6px;"><select id="s_county" name="s_county" value="{{ session('s_county') }}" class="form-control"><option value="{{ session('s_county') }}">{{ session('s_county') }}</option></select></div>
                <div id="show"></div>
            </div>
        </div>
        <div class="row form-group">
            <label class="col-xs-12">详细地址 <span class="star">*</span></label>
            <div class="col-xs-12">
                <input type="text"  name="s_addr"  value="{{ session('s_addr')  }}" class="form-control" placeholder="请输入详细地址信息。如道路、门牌号、小区、楼栋号、单元等信息" data-rule-required="true">
            </div>
        </div>
        <div class="row form-group">
            <label class="col-xs-12">邮政编码</label>
            <div class="col-xs-12">
                <input type="number" pattern="[0-9]*" class="form-control" name="s_code" value="{{ session('s_code')  }}" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,'');}).call(this)" onblur="this.v();" placeholder="请输入邮政编码" data-rule-maxlength="6" oninput="if(value.length>6)value=value.slice(0,6)" data-rule-required="true">
            </div>
        </div>
        <div class="row form-group">
            <label class="col-xs-12">收件人姓名 <span class="star">*</span></label>
            <div class="col-xs-12">
                <input type="text" name="s_name" value="{{ session('s_name')  }}" class="form-control" placeholder="请输入收件人姓名" data-rule-required="true">
            </div>
        </div>
        <div class="row form-group">
            <label class="col-xs-12">手机号码 <span class="star">*</span></label>
            <div class="col-xs-12">
                <div class="selectblock">
                    <select name="" id="" class="country-code">
                        <option value="">+86 </option>
                    </select>
                </div>
                <input type="number" pattern="[0-9]*" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,'');}).call(this)" onblur="this.v();" name="s_mobile" value="{{ session('s_mobile') }}" oninput="if(value.length>11)value=value.slice(0,11)" data-rule-maxlength="11" data-rule-required="true" class="form-control mobile-num" placeholder="请输入手机号码">
            </div>
        </div>
        <div class="row form-group default"><input id="box1" type="checkbox" checked="checked"/><label for="box1">设置为默认收货地址</label></div>
    </form>



</div>

<div style="height: 80px"></div>

<div class="total" style="padding-left:0;">
    <div class="row">
        <div class="col-xs-12"><button class="btn-exchange" id="nes">确认</button></div>
    </div>
</div>

<script src="../InteMall/js/jquery.min.js"></script>
<!-- Area -->
<script src="../InteMall/js/area.js"></script>
<script type="text/javascript">_init_area();</script>
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
<script type="text/javascript">
    $(document).ready(function () {
        /*DatePicker*/
        $('input[name="date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format('YYYY'),10)
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
        });
        /*Area Address*/
        var Gid  = document.getElementById ;
        var showArea = function(){
            Gid('show').innerHTML = "<h3>省" + Gid('s_province').value + " - 市" +
            Gid('s_city').value + " - 县/区" +
            Gid('s_county').value + "</h3>"
        }
        Gid('s_county').setAttribute('onchange','showArea()');
    });
</script>
<div id="exchange-popup" style="display:none;z-index: 99;top:50%;left:50%;transform:translate(-50%,-50%);width:100%;height:100%;position:fixed;align-items: center;
		 justify-content: center;">
    <div class="popup">
        <a class="btn-close" href="#"></a>
        <div class="content">
            <img src="../InteMall/images/img_exchange_done.png" width="150">
            <h2>兑换成功</h2>
            <button onclick="location.href='{{action("InteRecordController@index")}}'">查看记录</button>
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
<script>
    $('#nes').click(function(){
        var s_province = $('#s_province').val();
        var s_city = $('#s_city').val();
        var s_county = $('#s_county').val();
        var s_addr = $('input[name=s_addr]').val();
        var s_code = $('input[name=s_code]').val();
        var s_name = $('input[name=s_name]').val();
        var s_mobile= $('input[name=s_mobile]').val();
        var count=$("input[name='bonus_point']").val();
        //取得商品剩余数量
        var last=$("input[name='remaining_number']").val();
        //取得该商品id
        var product_id=$("input[name='product_id']").val();
        //取得应兑换商品的数量
        var number=$("input[name='number']").val();
        if(s_province=='')
        {
            alert('省不能为空');
            return false;
        }
        if(s_city=='')
        {
            alert('市不能为空');
            return false;
        }
        if(s_county=='')
        {
            alert('县不能为空');
            return false;
        }
        if(s_addr=='')
        {
            alert('详细地址不能为空');
            return false;
        }
        if(s_name=='')
        {
            alert('姓名不能为空');
            return false;
        }
        if(s_mobile=='')
        {
            alert('手机号不能为空');
            return false;
        }
        if(!(/^1(3|4|5|7|8)\d{9}$/.test(s_mobile)) || s_mobile==''){
            alert('请输入正确的手机号码!'); return false;
        }

            $.ajax({
                url:"{{action('InteProductController@newexchange')}}",
                type:'GET',
                data:{'product_id':product_id,'number':number,'s_province':s_province,'s_city':s_city,'s_county':s_county,'s_addr':s_addr,'s_code':s_code,'s_name':s_name,'s_mobile':s_mobile},
                success:function(msg){
                    if(msg.success==1){
                        $('#exchange-popup').css('display','flex');
                        $('#exchange-popup').css('overflow','hidden');
                    }else{
                        $('#exchange-fail').css('display','flex');
                        $('#exchange-fail').css('overflow','hidden');
                    }
                },error:function(){
                    alert('兑换商品失败,请重试！');return false;
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