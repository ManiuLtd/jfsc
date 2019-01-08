@extends('layouts.autht')
@section('content')
    <div class="info">
        <div class="photo"><img src="{{ session('newimage') }}" class="user-photo"></div>帐号昵称：{{ session('nickname') }}
    </div>
    <form  method="post" action="{{ url('notAutoRenew') }}" name="vform" style="text-align: left;" id="form">
        {{ csrf_field() }}
        <div class="info">
            <h1>富连网影视VIP（享百视通NBA权益）</h1>
            <ul class="itemlist">
                <li class="active">
                    <div class="row item" onclick="showYue()">
                        <div class="col-xs-8 name"><div>{{ $yueName }}VIP</div><p>{{ $yueMonth }}个月影视VIP</p></div>
                        <div class="col-xs-4 paid"><span class="dollarsign">¥</span><input type="hidden" value="{{ $yuePackageId }}" id="YuePid" name="YuePid"><input type="hidden" value="{{ $yuePrice }}" id="yue" name="yue">{{ $yuePrice }}<p>¥{{ $yuePrice }}</p></div>
                    </div>
                </li>
                <li>
                    <div class="row item" onclick="showJi()">
                        <div class="col-xs-8 name"><div>{{ $jiName }}VIP</div><p>{{ $jiMonth }}个月影视VIP</p></div>
                        <div class="col-xs-4 paid"><span class="dollarsign">¥</span><input type="hidden" value="{{ $jiPackageId }}" name="JiPid" id="JiPid"><input type="hidden" value="{{ $jiPrice }}" id="ji" name="ji">{{ $jiPrice }}<p>¥{{ $jiPrice }}</p></div>
                    </div>
                </li>
                <li>
                    <div class="row item" onclick="showBan()">
                        <div class="col-xs-8 name"><div>{{ $halfYearName }}VIP</div><p>{{ $halfYearMonth }}个月影视VIP</p></div>
                        <div class="col-xs-4 paid"><span class="dollarsign">¥</span><input type="hidden" value="{{ $halfPackageId }}" name="HalfPid" id="HalfPid"><input type="hidden" value="{{ $halfYearPrice }}" id="ban" name="ban">{{ $halfYearPrice }}<p>¥{{ $halfYearPrice }}</p></div>
                    </div>
                </li>
                <li>
                    <div class="row item" onclick="showNian()">
                        <div class="col-xs-8 name"><div>{{ $yearName }}VIP</div><p>{{ $yearMonth }}个月影视VIP</p></div>
                        <div class="col-xs-4 paid"><span class="dollarsign">¥</span><input type="hidden" value="{{ $yearPackageId }}" name="YearPid" id="YearPid"><input type="hidden" value="{{ $yearPrice }}" id="nian" name="nian">{{ $yearPrice }}<p>¥{{ $yearPrice }}</p></div>
                    </div>
                </li>
            </ul>
            {{--<ul class="itemlist">
                <li class="active">
                    <div class="row item" onclick="showYue()">
                        <div class="col-xs-8 name"><div><b style="font-size: 35px;">{{ $yueName }}</b><div style="margin-top:-48px;margin-left: 80px;"><img src="images/vipvip.png" ></div></div></div>
                        <div class="col-xs-4 paid"><input type="hidden" value="{{ $yuePackageId }}" id="YuePid" name="YuePid"><input type="hidden" value="{{ $yuePrice }}" id="yue" name="yue"><span style="font-size: 28px;">¥{{ $yuePrice }}</span><p style="text-decoration:line-through;font-size: 16px;color:#000000">原价：¥{{ $yzPrice }}</p></div>
                    </div>
                </li>
                <li>
                    <div class="row item" onclick="showJi()">
                        <div class="col-xs-8 name"><div><b style="font-size: 35px;">{{ $jiName }}</b><div style="margin-top:-48px;margin-left: 80px;"><img src="images/vipvip.png" ></div></div></div>
                        <div class="col-xs-4 paid"><input type="hidden" value="{{ $jiPackageId }}" id="JiPid" name="JiPid"><input type="hidden" value="{{ $jiPrice }}" id="ji" name="ji"><span style="font-size: 28px;">¥{{ $jiPrice }}</span><p style="text-decoration:line-through;font-size: 16px;color:#000000">原价：¥{{ $jzPrice }}</p></div>
                    </div>
                </li>
                <li>
                    <div class="row item" onclick="showBan()">
                        <div class="col-xs-8 name"><div><b style="font-size: 35px;">{{ $halfYearName }}</b><div style="margin-top:-48px;margin-left: 115px;"><img src="images/vipvip.png" ></div></div></div>
                        <div class="col-xs-4 paid"><input type="hidden" value="{{ $halfPackageId }}" id="HalfPid" name="HalfPid"><input type="hidden" value="{{ $halfYearPrice }}" id="ban" name="ban"><span style="font-size: 28px;">¥{{ $halfYearPrice }}</span><p style="text-decoration:line-through;font-size: 16px;color:#000000">原价：¥{{ $hzPrice }}</p></div>
                    </div>
                </li>
                <li>
                    <div class="row item" onclick="showNian()">
                        <div class="col-xs-8 name"><div><b style="font-size: 35px;">{{ $yearName }}</b><div style="margin-top:-48px;margin-left: 80px;"><img src="images/vipvip.png" ></div></div></div>
                        <div class="col-xs-4 paid"><input type="hidden" value="{{ $yearPackageId }}" id="YearPid" name="YearPid"><input type="hidden" value="{{ $yearPrice }}" id="nian" name="nian"><span style="font-size: 28px;">¥{{ $yearPrice }}</span><p style="text-decoration:line-through;font-size: 16px;color:#000000">原价：¥{{ $nzPrice }}</p></div>
                    </div>
                </li>

            </ul>--}}
        </div>

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
                <a href="{{ url('vipserv') }}  ">富连网VIP服务协议<span>|</span></a>
                {{--<a href="#autopay-popup">自动续费服务协议<span>|</span></a>--}}
                <a href="#">爱奇艺黄金VIP领取协议</a>
            </div>
        </div>
        <div style="height: 60px"></div>
        <div class="total">
            <div class="row">
                <div class="col-xs-7">
                    {{--总计<span class="dollarsign">¥</span><span class="money" id="JugeTip"><input type="hidden" value="0.01" name="tot">0.01</span>--}}
                    总计<span class="dollarsign">¥</span><span class="money" id="JugeTip"><input type="hidden" value="{{ $yuePrice }}" name="tot">{{ $yuePrice }}</span>
                    <span id="PackageId"><input type="hidden" value="{{ $yuePackageId }}" name="packageid"></span>
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
                <p class="tip">具体操作请咨询客服：<a href="tel:400-898-1818">400-898-1818</a></p>

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
        function showPrice()
        {
            price = document.getElementById('price').value*1;
            document.getElementById("JugeTip").innerText = price;
            var input = document.createElement('input');  //创建input节点
            input.setAttribute('type', 'hidden');  //定义类型是文本输入
            input.setAttribute('value', price);    //定义变量初始值
            input.setAttribute('name', 'tot');     //定义变量名
            input.setAttribute('id', 'tot');       //定义变量id
            document.getElementById('form').appendChild(input); //添加到form中显示
        }
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

            pid=document.getElementById('YuePid').value;
            //document.getElementById("PackageId").innerText = pid;
            var inputs = document.createElement('input');  //创建input节点
            inputs.setAttribute('type', 'hidden');  //定义类型是文本输入
            inputs.setAttribute('value', pid);    //定义变量初始值
            inputs.setAttribute('name', 'packageid');     //定义变量名
            inputs.setAttribute('id', 'packageid');       //定义变量id

            document.getElementById('form').appendChild(input); //添加到form中显示
            document.getElementById('form').appendChild(inputs); //添加到form中显示
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

            pid=document.getElementById('JiPid').value;
            //document.getElementById("PackageId").innerText = pid;
            var inputs = document.createElement('input');  //创建input节点
            inputs.setAttribute('type', 'hidden');  //定义类型是文本输入
            inputs.setAttribute('value', pid);    //定义变量初始值
            inputs.setAttribute('name', 'packageid');     //定义变量名
            inputs.setAttribute('id', 'packageid');       //定义变量id

            document.getElementById('form').appendChild(input); //添加到form中显示
            document.getElementById('form').appendChild(inputs); //添加到form中显示
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

            pid=document.getElementById('HalfPid').value;
            //document.getElementById("PackageId").innerText = pid;
            var inputs = document.createElement('input');  //创建input节点
            inputs.setAttribute('type', 'hidden');  //定义类型是文本输入
            inputs.setAttribute('value', pid);    //定义变量初始值
            inputs.setAttribute('name', 'packageid');     //定义变量名
            inputs.setAttribute('id', 'packageid');       //定义变量id

            document.getElementById('form').appendChild(input); //添加到form中显示
            document.getElementById('form').appendChild(inputs); //添加到form中显示
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

            pid=document.getElementById('YearPid').value;
            //document.getElementById("PackageId").innerText = pid;
            var inputs = document.createElement('input');  //创建input节点
            inputs.setAttribute('type', 'hidden');  //定义类型是文本输入
            inputs.setAttribute('value', pid);    //定义变量初始值
            inputs.setAttribute('name', 'packageid');     //定义变量名
            inputs.setAttribute('id', 'packageid');       //定义变量id

            document.getElementById('form').appendChild(input); //添加到form中显示
            document.getElementById('form').appendChild(inputs); //添加到form中显示
        }
    </script>
@endsection
