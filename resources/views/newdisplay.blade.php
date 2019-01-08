@extends('layouts.autht')
@section('content')
    <div class="wrapper">
    <div class="card default">
        <div class="container member">
            <div class="row">
                <div class="list-body">
                    <div class="list">
                        @if((session('status')==1))
                            <div class="photo">@if(session('newimage'))<img src="{{ session('newimage') }}" class="user-photo">@else<img src="images/img_defaultuser.png" class="user-photo">@endif</div>
                            @if(session('nickname')) {{ session('nickname') }} @else {{ session('mobile') }} @endif
                            <a href="{{ url('displayManage') }}" class="edit y">管理</a>
                            @if(session('res'))
                            <ul class="active-service">

                                @foreach(session('res') as $v)
                                        @if($v['fsk_package_provide']=='IQIYI' && $v['fsk_right_limitdate']>session('time') && ($v['fsk_right_limitdate']>=session('iqiyilimitdate')))
                                <li class="row">
                                    <div class="col-xs-7">富连网影视VIP<p>享奇异果权益</p></div>
                                    <div class="col-xs-5 date">{{ date('Y-m-d', $v['fsk_right_limitdate'] / 1000 + 8 * 60 * 60) }} 到期</div>
                                </li>
                                        @elseif($v['fsk_package_provide']=='YOUKU' && $v['fsk_right_limitdate']>session('time') && ($v['fsk_right_limitdate']>=session('youkulimitdate')))
                                <li class="row">
                                    <div class="col-xs-7 ">富连网影视VIP<p>享酷喵权益</p></div>
                                    <div class="col-xs-5 date">{{ date('Y-m-d', $v['fsk_right_limitdate'] / 1000 + 8 * 60 * 60) }} 到期</div>
                                </li>
                                        @elseif($v['fsk_package_provide']=='BESTV:PPTV' && $v['fsk_right_limitdate']>session('time') && ($v['fsk_right_limitdate']>=session('pptvlimitdate')))
                                <li class="row">
                                    <div class="col-xs-7 ">富连网影视VIP<p>享百视通影视权益</p></div>
                                    <div class="col-xs-5 date">{{ date('Y-m-d', $v['fsk_right_limitdate'] / 1000 + 8 * 60 * 60) }} 到期</div>
                                </li>
                                        @elseif($v['fsk_package_provide']=='BESTV' && $v['fsk_right_limitdate']>session('time') && ($v['fsk_right_limitdate']>=session('bestvlimitdate')))
                                            <li class="row">
                                                <div class="col-xs-7 ">富连网影视VIP<p>享百视通NBA权益</p></div>
                                                <div class="col-xs-5 date">{{ date('Y-m-d', $v['fsk_right_limitdate']/ 1000 + 8 * 60 * 60) }} 到期</div>
                                            </li>
                                        @endif
                                @endforeach
                            </ul>
                            @else
                                <span></span>
                            @endif
                        @else
                            <div class="photo"><img src="images/img_defaultuser.png" class="user-photo"></div>未登录
                            <a href="{{ url('newLogin') }}" class="edit y">登录</a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <p class="title">富连网影视VIP权益</p>
    <div class="list-body">
        <div class="container">
            <div class="list">
                @if((session('status')==1))
                    {{--<a href="#waiting-popup">--}}
                    <a href="{{ url('recharge') }}">
                         <div class="left"><i class="icon-vip"></i>VIP充值</div>
                         <div class="right"><i class="icon-angle-right"></i></div>
                        </a>
                 @else
                    <a href="{{ url('newLogin') }}">
                        <div class="left"><i class="icon-vip"></i>VIP充值</div>
                        <div class="right"><i class="icon-angle-right"></i></div>
                    </a>
                @endif
            </div>
            <div class="list">
                @if((session('status')==1))
                    <a href="#waiting-popup">
                        <div class="left"><i class="icon-pay"></i>消费记录</div>
                        <div class="right"><i class="icon-angle-right"></i></div>
                    </a>
                @else
                    <a href="{{ url('newLogin') }}">
                        <div class="left"><i class="icon-pay"></i>消费记录</div>
                        <div class="right"><i class="icon-angle-right"></i></div>
                    </a>
                @endif
            </div>
        </div>
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
</div>
    <div id="tabar">
        <ul>
            @if(session('status')==1)
                <li class="active"><a href="#"><i class="ico ico-home"></i>首页</a></li>
                <li><a href="{{ url('InteMall/index') }}"><i class="ico ico-shop"></i>积分商城</a></li>
                <li><a href="{{ url('display') }}"><i class="ico ico-my"></i>我的</a></li>
            @else
                <span></span>
            @endif
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

    <div id="waiting-popup" class="overlay">
        <div class="popup">
            <a class="btn-close" href="#"></a>
            <div class="content">
                <a class="close" href="#"><img src="images/bg_waiting.png" width="100%"></a>
            </div>
        </div>
    </div>

@endsection
