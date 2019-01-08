@extends('layouts.autht')
@section('content')
    <div class="list-body">
        <div class="container">
            <div class="list">
                账号
                <span class="y account">{{ session('mobile') }}</span>
            </div>
            <div class="list">
                {{--<a href="{{ url('editnick') }}">
                    <div class="left">修改昵称</div>
                    <div class="right"><i class="icon-angle-right"></i></div>
                </a>--}}
                昵称
                <span class="y account">{{ session('nickname') }}</span>
            </div>
            <div class="list">
                已绑定的微信号
                <span class="y account">{{ session('wxnickname')}} </span>
            </div>

        </div>
    </div>
    <center><a href="{{ url('logout') }}"><button class="btn-submit exit">退 出</button></a> </center>
    <div class="footer">
        <ul>
            <li><a href="{{ url('aboutflnet') }}">关于富连网<span>|</span></a></li>
            <li><a href="#contact-popup">联络客服<span>|</span></a></li>
            <li><a href="{{ url('service-terms') }}">服务协议<span>|</span></a></li>
            <li><a href="{{ url('privacy') }}">隐私权政策</a></li>
        </ul>
        <div class="copyright">© 2017-2018 富连网会员服务</div>
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
@endsection
