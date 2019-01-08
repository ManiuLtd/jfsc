<!DOCTYPE html>
<html>
<head>
    <title>富连网物联网智能家居--积分商城</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="../InteMall/css/bootstrap.css">
    <!-- MainCSS -->
    <link rel="stylesheet" href="../InteMall/css/style.css">
    <!-- Modernizr JS -->
    <script src="../InteMall/js/modernizr.js"></script>
    <!-- FOR IE9 below -->
    <!--[if lt IE 9]>
    <script src="../InteMall/js/respond.min.js"></script>
    <![endif]-->
</head>
<body class="bg-credit">
<div class="container">
    <div class="paper">
        <div class="content">
            <div class="credit num-list">
                <ul>
                    <li><h3 style="font-size:2em;">@if($exchange_integral=='')
                                0
                            @else
                                {{$exchange_integral}}
                            @endif
                        </h3><p class="txt">已兑换积分</p></li>
                    <li><h3 style="font-size:2em;">@if($remaining_point=='')
                                0
                            @else
                                {{$remaining_point}}
                            @endif
                        </h3><p class="txt">我的积分</p></li>
                    <li><h3 style="font-size:2em;">
                            @if($count=='')
                                0
                            @else
                                {{$count}}
                            @endif
                        </h3><p class="txt">兑换商品</p></li>
                </ul>
            </div>
            <div class="line"></div>
            @if(empty($HistoryRecords))
                <div style="height:65vh;width:100%;display:table;"><p style="display: table-cell;width: auto;height:auto;text-align: center;vertical-align: middle;">暂无兑换记录</p></div>
            @else
                @foreach($HistoryRecords as $val)
                    <div class="list small excharge">
                        <a class="description" href="{{action('InteProductController@index',['product_id'=>$val['products_id'],'sernum'=>$val['serial_number']])}}">
                            <img src="{{$val['product_image']}}">
                            <div class="left"><p>{{$val['name']}}</p><p class="description">已兑换积分:{{$val['bonus_point']}}</p>@if($val['product_kind']==2)<p class="description" style="margin-top:-8px;">兑换序号:{{$val['serial_number']}}</p>@else<p class="description" style="margin-top:-8px;">收货地址:{{$val['send_info']['s_addr']}}</p>@endif</div>
                            <div class="right unlink">{{date("Y-m-d",$val['created_at'])}}</div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="shadow"></div>
</div>
</body>
</html>