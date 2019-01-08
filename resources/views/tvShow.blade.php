@extends('layouts.autht')
@section('content')
    @if(session('rechargeDisplay'))
        @foreach(session('rechargeDisplay') as $value)
            @if($value['providerName']=='IQIYI' && ($value['devices'][0]['provider']=='IQIYI'))
                @foreach($value['devices'] as $v)
                    <p class="title">设备({{ $v['model'] }})</p>
                    <div class="list-body">
                        <div class="container">
                            <div class="list">
                                <div class="left">机型名称</div>
                                <div class="right">{{ $v['model'] }}</div>
                            </div>
                            <div class="list">
                                <div class="left">MAC地址</div>
                                <div class="right">{{ $v['mac'] }}</div>
                            </div>
                            <div class="list">
                                <div class="left">SN码</div>
                                <div class="right">{{ $v['deviceSn'] }}</div>
                            </div>
                            <div class="list">
                                <div class="left">影视权益</div>
                                <div class="right">@if($v['provider']=='IQIYI')爱奇艺@endif</div>
                            </div>
                            <div class="list">
                                <div class="left">权益到期日</div>
                                <div class="right">{{ date('Y-m-d', $v['limitDate'] / 1000 + 8 * 60 * 60) }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach

            @elseif($value['providerName']=='YOUKU' && ($value['devices'][0]['provider']=='YOUKU'))
                @foreach($value['devices'] as $v)
                    <p class="title">设备({{ $v['model'] }})</p>
                    <div class="list-body">
                        <div class="container">
                            <div class="list">
                                <div class="left">机型名称</div>
                                <div class="right">{{ $v['model'] }}</div>
                            </div>
                            <div class="list">
                                <div class="left">MAC地址</div>
                                <div class="right">{{ $v['mac'] }}</div>
                            </div>
                            <div class="list">
                                <div class="left">SN码</div>
                                <div class="right">{{ $v['deviceSn'] }}</div>
                            </div>
                            <div class="list">
                                <div class="left">影视权益</div>
                                <div class="right">@if($v['provider']=='YOUKU')优酷@endif</div>
                            </div>
                            <div class="list">
                                <div class="left">权益到期日</div>
                                <div class="right">{{ date('Y-m-d', $v['limitDate'] / 1000 + 8 * 60 * 60) }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach

            @elseif($value['providerName']=='BESTV:PPTV' && ($value['devices'][0]['provider']=='BESTV:PPTV'))
                @foreach($value['devices'] as $v)
                    <p class="title">设备({{ $v['model'] }})</p>
                    <div class="list-body">
                        <div class="container">
                            <div class="list">
                                <div class="left">机型名称</div>
                                <div class="right">{{ $v['model'] }}</div>
                            </div>
                            <div class="list">
                                <div class="left">MAC地址</div>
                                <div class="right">{{ $v['mac'] }}</div>
                            </div>
                            <div class="list">
                                <div class="left">SN码</div>
                                <div class="right">{{ $v['deviceSn'] }}</div>
                            </div>
                            <div class="list">
                                <div class="left">影视权益</div>
                                <div class="right">@if($v['provider']=='BESTV:PPTV')百视通影视 @endif</div>
                            </div>
                            <div class="list">
                                <div class="left">权益到期日</div>
                                <div class="right">{{ date('Y-m-d', $v['limitDate'] / 1000 + 8 * 60 * 60) }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach

            @elseif($value['providerName']=='BESTV' && ($value['devices'][0]['provider']=='BESTV'))
                @foreach($value['devices'] as $v)
                    <p class="title">设备({{ $v['model'] }})</p>
                    <div class="list-body">
                        <div class="container">
                            <div class="list">
                                <div class="left">机型名称</div>
                                <div class="right">{{ $v['model'] }}</div>
                            </div>
                            <div class="list">
                                <div class="left">MAC地址</div>
                                <div class="right">{{ $v['mac'] }}</div>
                            </div>
                            <div class="list">
                                <div class="left">SN码</div>
                                <div class="right">{{ $v['deviceSn'] }}</div>
                            </div>
                            <div class="list">
                                <div class="left">影视权益</div>
                                <div class="right">@if($v['provider']=='BESTV')百视通NBA @endif</div>
                            </div>
                            <div class="list">
                                <div class="left">权益到期日</div>
                                <div class="right">{{ date('Y-m-d', $v['limitDate'] / 1000 + 8 * 60 * 60) }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <span></span>
            @endif
        @endforeach
    @else
        <span></span>
    @endif
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
