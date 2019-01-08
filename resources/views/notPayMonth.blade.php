@extends('layouts.autht')
@section('content')
    <div class="info">
        <div class="photo"><img src="{{ session('newimage') }}" class="user-photo"></div>帐号昵称：{{ session('nickname') }}
    </div>
    <form  method="post" action="{{ url('autoRenew') }}" name="vform" style="text-align: left;" id="form">
        {{--<form  method="post" action="{{ url('autoPay') }}" name="vform" style="text-align: left;" id="form">--}}   {{--签约开通自动续费功能--}}
        {{ csrf_field() }}
    <div class="info">
        <h1>富连网影视VIP（享奇异果权益）</h1>
        <ul class="itemlist">
            <li class="active" onload="showJuge()">
                <div class="row item" onclick="showJuge()">
                    <div class="col-xs-8 name"><div>连续包月<div class="sale">首月特价</div></div><p>后续每月自动扣款30元</p></div>
                    <div class="col-xs-4 paid"><span class="dollarsign" >¥</span><input type="hidden" value="19.8" id="tj" name="tj">19.8<p>¥30</p></div>
                </div>
                <div class="row"><div class="col-xs-12 comment">到期前一天自动续费一个月，可随时取消<img src="images/img_tip02.png"></div></div>
            </li>

            <li>
                <div class="row item" onclick="showYue()">
                    <div class="col-xs-8 name"><div>月度VIP<div class="sale minus">减</div></div><p>1个月影视VIP</p></div>
                    <div class="col-xs-4 paid"><span class="dollarsign">¥</span><input type="hidden" value="49.8" id="yue" name="yue">49.8<p>¥99.8</p></div>
                </div>
            </li>
            <li>
                <div class="row item" onclick="showJi()">
                    <div class="col-xs-8 name"><div>季度VIP</div><p>3个月影视VIP</p></div>
                    <div class="col-xs-4 paid"><span class="dollarsign">¥</span><input type="hidden" value="148" id="ji" name="ji">148<p>¥198</p></div>
                </div>
            </li>
            <li>
                <div class="row item" onclick="showBan()">
                    <div class="col-xs-8 name"><div>半年度VIP</div><p>6个月影视VIP</p></div>
                    <div class="col-xs-4 paid"><span class="dollarsign">¥</span><input type="hidden" value="299" id="ban" name="ban">299<p>¥369</p></div>
                </div>
            </li>
            <li>
                <div class="row item" onclick="showNian()">
                    <div class="col-xs-8 name"><div>年度VIP</div><p>12个月影视VIP</p></div>
                    <div class="col-xs-4 paid"><span class="dollarsign">¥</span><input type="hidden" value="498" id="nian" name="nian">498<p>¥569</p></div>
                </div>
            </li>
        </ul>
    </div>
    <!-- .info -->

    <div class="info wechat-pay">
        <div class="row">
            <div class="col-xs-10"><img src="images/btn-social.png" width="30">微信支付</div>
            <div class="col-xs-2"><i class="btn-check checked"></i></div>
        </div>
    </div>
    <!-- .info -->

    <div class="info">
        <h1>会员特权</h1>
        <div class="row vip">
            <div class="col-xs-3"><img src="images/img_movie.png">院线影片抢先看</div>
            <div class="col-xs-3"><img src="images/img_HD.png">极清画质</div>
            <div class="col-xs-3"><img src="images/img_source.png">专属VIP片源</div>
            <div class="col-xs-3"><img src="images/img_AD.png">跳过广告</div>
        </div>
        <div class="row service">
            <a href="#">富连网VIP服务协议<span>|</span></a>
            <a href="#autopay-popup">自动续费服务协议<span>|</span></a>
            <a href="#">爱奇艺黄金VIP领取协议</a>
        </div>
    </div>
    <div style="height: 60px"></div>
    <div class="total">
        <div class="row">
            <div class="col-xs-7">
                总计<span class="dollarsign">¥</span><span class="money" id="JugeTip"><input type="hidden" value="19.8" name="tot">19.8</span>
            </div>
            <div class="col-xs-5"><input type="submit" value="确认支付" class="btn-paid"  id="btnsubmit" name="Submit" /></div>
        </div>
    </div>

</form>

    <div id="autopay-popup" class="overlay">
        <div class="popup service-term">
            <a class="btn-close" href="#"></a>
            <div class="content graytxt">
                <center><h2>自动续费服务声明</h2></center>
                <ol>
                    <li>1.到期前一天为您自动续费，扣款前短信消息通知，完全透明；    </li>
                    <li>2.可随时取消自动续费服务，取消后不再自动续费。    </li>
                </ol>
                <p class="tip">具体操作请咨询客服：400-898-1818</p>

                <center><a href="#" class="btn-default">好的</a></center>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script>
        $(function(){
            $('.itemlist li').click(function(){
                $(this).toggleClass('active').siblings().removeClass('active');
            });
            $('.btn-check').click(function(){
                $(this).toggleClass('checked');
            })
        });
    </script>
    <script>
        function showJuge()
        {
            price = document.getElementById('tj').value*1;
            document.getElementById("JugeTip").innerText = price;
            var input = document.createElement('input');  //创建input节点
            input.setAttribute('type', 'hidden');  //定义类型是文本输入
            input.setAttribute('value', price);    //定义变量初始值
            input.setAttribute('name', 'tot');     //定义变量名
            input.setAttribute('id', 'tot');       //定义变量id
            document.getElementById('form').appendChild(input); //添加到form中显示
        }
        function showYue()
        {
            price = document.getElementById('yue').value*1;
            document.getElementById("JugeTip").innerText = price;
            var input = document.createElement('input');  //创建input节点
            input.setAttribute('type', 'hidden');  //定义类型是文本输入
            input.setAttribute('value', price);    //定义变量初始值
            input.setAttribute('name', 'tot');     //定义变量名
            input.setAttribute('id', 'tot');       //定义变量id
            document.getElementById('form').appendChild(input); //添加到form中显示
        }
        function showJi()
        {
            price = document.getElementById('ji').value*1;
            document.getElementById("JugeTip").innerText = price;
            var input = document.createElement('input');  //创建input节点
            input.setAttribute('type', 'hidden');  //定义类型是文本输入
            input.setAttribute('value', price);    //定义变量初始值
            input.setAttribute('name', 'tot');     //定义变量名
            input.setAttribute('id', 'tot');       //定义变量id
            document.getElementById('form').appendChild(input); //添加到form中显示
        }
        function showBan()
        {
            price = document.getElementById('ban').value*1;
            document.getElementById("JugeTip").innerText = price;
            var input = document.createElement('input');  //创建input节点
            input.setAttribute('type', 'hidden');  //定义类型是文本输入
            input.setAttribute('value', price);    //定义变量初始值
            input.setAttribute('name', 'tot');     //定义变量名
            input.setAttribute('id', 'tot');       //定义变量id
            document.getElementById('form').appendChild(input); //添加到form中显示
        }
        function showNian()
        {
            price = document.getElementById('nian').value*1;
            document.getElementById("JugeTip").innerText = price;
            var input = document.createElement('input');  //创建input节点
            input.setAttribute('type', 'hidden');  //定义类型是文本输入
            input.setAttribute('value', price);    //定义变量初始值
            input.setAttribute('name', 'tot');     //定义变量名
            input.setAttribute('id', 'tot');       //定义变量id
            document.getElementById('form').appendChild(input); //添加到form中显示
        }
    </script>
@endsection
