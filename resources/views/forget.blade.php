@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="row">
            <p class="tip">请输入您的手机号以获取短信验证码</p>
            <form id="forget-password-form" action="{{ url('forget') }}" method="post" autocomplete="off" class="panel">
                {{ csrf_field() }}
                {{-- 錯誤提示內容 --}}
                @if($errors->any())
                    <input id="error-message" type="hidden" value="{{$errors->first()}}">
                @else
                    <input id="error-message" type="hidden" value="">
                @endif
                <div class="field">
                    <div class="form-control">
                        <i class="icon-mobile"></i>
                        <input type="number" id="tel" name="tel" pattern="[0-9]*" placeholder="请输入手机号" oninput="if(value.length>11)value=value.slice(0,11)"
                               data-rule-minlength="6" data-rule-required="true" value="{{ old('tel') }}">
                        <div class="underline"></div>
                    </div>
                    <div class="form-control">
                        <i class="icon-code"></i>
                        <input type="number" name="mobile_confirm_code" id="mobile-confirm-code"
                               pattern="[0-9]*" placeholder="请输入验证码" oninput="if(value.length>6)value=value.slice(0,6)" data-rule-minlength="1"
                               data-rule-required="true">
                        <a href="javascript:;">
                            <button class="send-code y" type="button" id="js-get_mobile_vcode">发送验证码</button>
                        </a>
                    </div>
                </div>
                <center><input class="btn-submit" type="submit" value="下一步" id="js-mobile_btn"></center>

            </form>
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

    <script>
        $(document).ready(function(){
            $("#tel").focus(function(){
                $("#js-mobile_btn").attr("class","btn-submit disable");
            });
            $("#tel").blur(function(){
                $("#js-mobile_btn").attr("class","btn-submit");
            });
            $("#mobile-confirm-code").focus(function(){
                $("#js-mobile_btn").attr("class","btn-submit");
            });
            $("#mobile-confirm-code").blur(function(){
                $("#js-mobile_btn").attr("class","btn-submit");
            });
            $("#js-mobile_btn").blur(function(){
                $("#js-mobile_btn").attr("class","btn-submit");
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            // 若有錯誤提示才顯示
            var errorMessage = $('#error-message').val();
            if (errorMessage) {
                console.log('error message is ' + errorMessage);
                alert(errorMessage);
            }

        });
    </script>
    <script>
        $(function () {
            var ag=0;
            //发送验证码
            $('#js-get_mobile_vcode').click(function () {
                ag++;
                var tel = $('input[name=tel]').val();

                if (!/^1[3456789]\d{9}$/.test(tel) || tel == '') {
                    alert('请输入正确的手机号码!');
                    return;
                }

                if(ag==1)
                {
                    // 发送验证码
                    $.get('{{ url('forgetcode') }}', {tel: tel}, function (data) {
                        $('input[name=tel]').attr({'readOnly': true});
                        $('#js-get_mobile_vcode').attr('disabled', 'disabled');
                        $('#js-get_mobile_vcode').html('重发(<span id="show-waiting-span" style="color:#fff;font-size: 8px;position: relative;left:-1px;"></span>)');
                        showTime();
                        if(data.result_code==1)
                        {
                            alert('验证码已发送！');return false;
                        }
                        else
                        {
                            alert(data.message);return false;
                        }
                    })
                }

            });

            // 提交form前先驗證輸入是否正確
            $("#forget-password-form").submit(function (event) {
                event.preventDefault();

                var tel = $('input[name=tel]').val();
                var newnewcode = $('input[name=newnewcode]').val();
                var mobile_confirm_code = $('input[name=mobile_confirm_code]').val();
                if (tel == '') {
                    alert('手机号不能为空!');
                    return false;
                }
                if (!/^1[3456789]\d{9}$/.test(tel)) {
                    alert('请输入正确的手机号码!');
                    return false;
                }

                if (mobile_confirm_code == '') {
                    alert('验证码不能为空!');
                    return false;
                }

                if (mobile_confirm_code.length < 6) {
                    alert('验证码不得少于6位!');
                    return false;
                }

                this.submit();
            });



        })
    </script>

    <script type="text/javascript">
        //设定倒数秒数
        var t = 60;
        //显示倒数秒数
        function showTime() {
            t -= 1;
            document.getElementById('show-waiting-span').innerHTML = t;

            $('#js-get_mobile_vcode').attr('disabled', 'disabled');
            // 若時間倒數完則重新倒數，讓用戶可重發驗證碼
            if (t == 0) {
                $('#js-get_mobile_vcode').removeAttr('disabled').html('发送验证码');
                t = 60;
                return;
            }

            // 每秒檢查一次
            setTimeout(showTime, 1000);
        }
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
@endsection
