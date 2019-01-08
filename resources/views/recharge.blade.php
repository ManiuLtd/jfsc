@extends('layouts.autht')
@section('content')
    <div class="info">
        <div class="photo"><img src="{{ session('newimage') }}" class="user-photo"></div>帐号昵称：{{ session('nickname') }}
    </div>
    <div class="container">
                @if($res || $newRes)
                <div class="y question"><a href="#info-popup"><i class="icon-question"></i></a></div>
                @endif


            @if($res)
                @foreach($res as $vs)
                     @if(($vs['providerName']=='IQIYI' && $vs['devices']) )
                    <div class="vipcard">
                        <div class="cover"><h3>富连网影视VIP<span>享奇异果权益</span></h3><a href="{{ url('iqiyi') }}" class="btn-default y">充值</a></div>
                        @if($vs['devices'])
                            <ul class="card-info">
                                <li>您关联的设备</li>
                                @foreach($vs['devices'] as $vv)
                                    @if($vv['limitDate']>$time && ($vv['provider']=='IQIYI') && ($vv['limitDate']!=''))
                                        <li>{{ $vv['model'] }}（设备VIP {{ date('Y-m-d', $vv['limitDate'] / 1000 + 8 * 60 * 60) }} 到期）</li>
                                    @elseif($vv['limitDate']<$time && ($vv['provider']=='IQIYI') && ($vv['limitDate']!=''))
                                        <li>{{ $vv['model'] }}（设备VIP已到期）</li>
                                    @elseif($vv['limitDate']=='' && ($vv['provider']=='IQIYI'))
                                        <li>{{ $vv['model'] }}（设备VIP正在查询中…）</li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <ul class="card-info">
                                <li>您关联的设备</li>
                                <li>此账号下未关联任何设备</li>
                            </ul>
                        @endif
                    </div>

                    @else
                        <span></span>
                    @endif
                @endforeach

            @else
                <span></span>


            @endif


        @if($res)
            @foreach($res as $vs)
                @if(($vs['providerName']=='YOUKU' && $vs['devices']) )
                                <div class="vipcard">
                        <div class="cover"><h3>富连网影视VIP<span>享酷喵权益</span></h3><a href="{{ url('youku') }}" class="btn-default y">充值</a></div>
                        @if($vs['devices'])
                            <ul class="card-info">
                                <li>您关联的设备</li>
                                @foreach($vs['devices'] as $vv)
                                    @if($vv['limitDate']>$time && ($vv['provider']=='YOUKU') && ($vv['limitDate'] !=''))
                                        <li>{{ $vv['model'] }}（设备VIP {{ date('Y-m-d', $vv['limitDate'] / 1000 + 8 * 60 * 60) }} 到期）</li>
                                    @elseif($vv['limitDate']<$time && ($vv['provider']=='YOUKU') && ($vv['limitDate'] !=''))
                                        <li>{{ $vv['model'] }}（设备VIP已到期）</li>
                                    @elseif($vv['limitDate']=='' && ($vv['provider']=='YOUKU'))
                                        <li>{{ $vv['model'] }}（设备VIP正在查询中…）</li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <ul class="card-info">
                                <li>您关联的设备</li>
                                <li>此账号下未关联任何设备</li>
                            </ul>
                        @endif
                    </div>

                @else
                    <span></span>
                @endif
            @endforeach
        @else
                <span></span>
            @endif

        @if($res)
            @foreach($res as $vs)
                @if(($vs['providerName']=='BESTV:PPTV' && $vs['devices']) || ($vs['providerName']=='BESTV' && $vs['devices']) )
                                        <div class="vipcard">
                        <div class="cover"><h3>富连网影视VIP<span>享百事通影视权益</span></h3><a href="{{ url('baishitong') }}" class="btn-default y">充值</a></div>
                        @if($vs['devices'])
                            <ul class="card-info">
                                <li>您关联的设备</li>
                                @foreach($vs['devices'] as $vv)
                                    @if($vv['limitDate']>$time && ($vv['provider']=='BESTV:PPTV') && ($vv['limitDate'] !=''))
                                        <li>{{ $vv['model'] }}（设备VIP {{ date('Y-m-d', $vv['limitDate'] / 1000 + 8 * 60 * 60) }} 到期）</li>
                                    @elseif($vv['limitDate']<$time && ($vv['provider']=='BESTV:PPTV') && ($vv['limitDate'] !=''))
                                        <li>{{ $vv['model'] }}（设备VIP已到期）</li>
                                    @elseif($vv['limitDate']=='' && ($vv['provider']=='BESTV:PPTV'))
                                        <li>{{ $vv['model'] }}（设备VIP正在查询中…）</li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <ul class="card-info">
                                <li>您关联的设备</li>
                                <li>此账号下未关联任何设备</li>
                            </ul>
                        @endif
                    </div>


                    <div class="vipcard">
                        <div class="cover"><h3>富连网影视VIP<span>享百视通NBA权益</span></h3><a href="{{ url('nba') }}" class="btn-default y">充值</a></div>
                        @if($vs['devices'])
                            <ul class="card-info">
                                <li>您关联的设备</li>
                                @foreach($vs['devices'] as $vv)
                                    @if($vv['limitDate']>$time && ($vv['provider']=='BESTV') && ($vv['limitDate'] !=''))
                                        <li>{{ $vv['model'] }}（设备VIP {{ date('Y-m-d', $vv['limitDate'] / 1000 + 8 * 60 * 60) }} 到期）</li>
                                    @elseif($vv['limitDate']<$time && ($vv['provider']=='BESTV') && ($vv['limitDate'] !=''))
                                        <li>{{ $vv['model'] }}（设备VIP已到期）</li>
                                    @elseif($vv['limitDate']=='' && ($vv['provider']=='BESTV'))
                                        <li>{{ $vv['model'] }}（设备VIP正在查询中…）</li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <ul class="card-info">
                                <li>您关联的设备</li>
                                <li>此账号下未关联任何设备</li>
                            </ul>
                        @endif
                    </div>
                @else
                    <span></span>
                @endif
            @endforeach
                @else
                   {{-- <span></span>--}}
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
                @endif

    </div>
    <div id="info-popup" class="overlay">
        <div class="popup">
            <a class="btn-close" href="#"></a>
            <div class="content">
                <center><h2>帮助说明</h2></center>
                <span class="notice">注意 :</span>当您的<span class="notice">设备VIP<small>１</small></span>未到期， 我们不建议您进行购买<span class="notice">影视VIP<small>２</small></span>，否则会同时并行消耗您的设备VIP观影权益与影视VIP权益!为了避免您的损失，请确保设备VIP已经使用到期后，再进行购买影视VIP。
                <br><br>
                <p class="comment-info"><span>设备VIP<small>１</small>：</span>是指您的机器首次登录后赠送的VIP观影权益（免费）。</p>
                <p class="comment-info"><span>影视VIP<small>２</small>：</span>是指您在观看电视的过程中，通过支付购买而获得的VIP观影权益。(一般是指月卡、季卡、半年卡、年卡、NBA等，因视频来源不同而有差异。 )</p>
                <br><br>
                <center><a href="#" class="btn-default">我知道了</a></center>
            </div>
        </div>
    </div>

@endsection
