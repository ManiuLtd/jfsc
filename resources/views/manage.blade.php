@extends('layouts.autht')

@section('content')
    <div class="wrapper">
        <div class="nickname">
            @if(session('newimage'))
                <div class="photo"><img src="{{ session('newimage') }}" class="user-photo"></div>
            @else
                <div class="photo"><img src="images/img_defaultuser.png" class="user-photo"></div>
            @endif
            <p>@if(session('nickname')) {{ session('nickname') }} @else {{ session('mobile') }} @endif</p>
        </div>

        <p class="title">我的设备</p>
        <div class="list-body">
            <div class="container">

                @if(session('rechargeDisplay'))
                    @foreach(session('rechargeDisplay') as $val)

                        @if($val['providerName']=='IQIYI' || $val['providerName']=='YOUKU' || $val['providerName']=='BESTV:PPTV' || $val['providerName']=='BESTV')
                            <span></span>
                        @endif

                    @endforeach
                    <div class="list">
                        <a href="{{ url('tvShow') }}">
                            <div class="left pl">夏普电视</div>
                            <div class="y link">{{ session('rechargeDisplay')[0]['devices'][0]['model'] }}<i class="icon-angle-right"></i></div>
                        </a></div>


                @else
                    <div class="list">
                        <a href="#">
                            <div class="left pl">夏普电视</div>
                            <div class="y unlink">未关联</div>
                        </a></div>
                @endif
                @if(session('userdev'))
                    @foreach(session('userdev') as $val)
                        @if($val['type']==5)
                            <div class="list">
                                <a href="{{ url('airFresh') }}">
                                    <div class="left pl">夏普空清</div>
                                    <div class="y link">{{ $val['model'] }}<i class="icon-angle-right"></i></div>
                                </a></div>

                        @endif

                    @endforeach
                    <div class="list">
                        <a href="#">
                            <div class="left pl">夏普空清</div>
                            <div class="y unlink">未关联</div>
                        </a></div>
                @else
                    <div class="list">
                        <a href="#">
                            <div class="left pl">夏普空清</div>
                            <div class="y unlink">未关联</div>
                        </a></div>
                @endif

            </div>

        </div>

        <p class="title">我的账号</p>
        <div class="list-body">
            <div class="container">
                <div class="list">
                    <a href="{{ url('accountDetail') }}">
                        <div class="left pl">账号</div>
                        <div class="right"><i class="icon-angle-right"></i></div>
                    </a>
                </div>
                <div class="list">
                    <a href="{{ url('modifyPass') }}">
                        <div class="left pl">修改密码</div>
                        <div class="right"><i class="icon-angle-right"></i></div>
                    </a>
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
                <li><a href="/"><i class="ico ico-home"></i>首页</a></li>
                <li><a href="{{ url('InteMall/index') }}"><i class="ico ico-shop"></i>积分商城</a></li>
                <li  class="active"><a href="{{ url('display') }}"><i class="ico ico-my"></i>我的</a></li>
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
@endsection
