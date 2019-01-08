<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', '')</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="@yield('meta_description', '富连网物联网智能家居会员服务')">
    <meta name="author" content="@yield('meta_author', '富连网物联网')">
    <meta name="keywords" content="富连网, 富连网物联网, 物联网, 会员服务,智能家居,家居">
    <script type="text/javascript">
        //调用微信JS api 支付
        function jsApiCall()
        {
            WeixinJSBridge.invoke(
                    'getBrandWCPayRequest',
                    <?php echo $jspay; ?>,
                    function(res){
                        if(res.err_msg=='get_brand_wcpay_request:ok')
                        {
                            alert('您的权益将在5分钟内生效！');
                            window.location.href='{{ url('newDisplay') }}';
                        }
                        else
                        {
                            alert('微信支付失败');window.history.back(-1);
                        }
                    }
            );
        }
        function callpay()
        {
            if (typeof WeixinJSBridge == "undefined"){
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            }else{
                jsApiCall();
            }
        }
    </script>
    <script type="text/javascript">

        window.onload = function(){
            if (typeof WeixinJSBridge == "undefined"){
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', editAddress, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', editAddress);
                    document.attachEvent('onWeixinJSBridgeReady', editAddress);
                }
            }else{
                editAddress();
            }
        };


    </script>
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
</head>
<body onload="callpay()">
</body>
</html>
