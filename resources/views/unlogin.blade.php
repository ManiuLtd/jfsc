@extends('layouts.autht')
@section('content')
    <div class="info">
        <div class="photo"><img src="{{ session('newimage') }}" class="user-photo"></div>帐号昵称：{{ session('nickname') }}
    </div>

    <div class="info tip-info">
        <img src="images/img_tip.png" width="25">
        <p></p>此账号未在任何电视设备上领取或购买过影视权益，无法提供充值服务。请先在设备上完成领取或购买后重试。
        </p>
    </div>

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
