@extends('layouts.auth')

@section ('title', '登录')

@section('content')
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="welcome">
                    @if(session('newimage'))
                        <img src="{{ session('newimage') }}" class="user-photo">
                    @else
                        <img src="images/user02.jpg" class="user-photo">
                    @endif
                    <i class="icon-link"></i>
                    <img src="images/img_logo_flnet.svg">
                    <h1>一个账号畅游富连网所有服务</h1>
                </div>
                <form id="normal-login" action="{{ url('login') }}" method="post" autocomplete="off" class="panel" style="display: none;">
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
                            <input type="number" id="username" name="username" pattern="[0-9]*" placeholder="手机号"
                                   oninput="if(value.length>11)value=value.slice(0,11)" minlength="11" data-rule-maxlength="11" data-rule-required="true"
                                   value="{{ old('username') }}">
                            <div class="underline"></div>
                        </div>
                        <div class="form-control">
                            <i class="icon-lock"></i>
                            <input type="password" placeholder="请输入密码" id="dlpassword" name="dlpassword"
                                   maxlength="15"/>
                        </div>
                    </div>
                    <div class="function">
                        <p class="z"><a href="#" class="fast">快捷登录</a></p>
                        <p class="y"><a href="{{ url('forgetPass') }}" title="忘记密码">忘记密码</a></p>
                    </div>
                    <input class="btn-submit" type="submit" value="登   录" id="js-mobile_btn">
                </form>

                <form action="{{ url('fastLogin') }}" class="panel" id="fast-login"  method="post" autocomplete="off">
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
                            <input type="number" id="usernames" name="usernames" pattern="[0-9]*" placeholder="手机号"
                                   oninput="if(value.length>11)value=value.slice(0,11)" data-rule-maxlength="11" data-rule-required="true"
                                   value="{{ old('usernames') }}">
                            <div class="underline"></div>
                        </div>
                        <div class="form-control">
                            <i class="graphcode"></i><input type="text" id="confirm_code" name="confirm_code"  placeholder="图形验证码" data-rule-required="true" data-rule-minlength="1" oninput="if(value.length>4)value=value.slice(0,4)"  maxlength="4">
                            <div class="code y">
                                <img src="{{ url('captchaUpdate/1') }}" class="refresh" alt="验证码" title="刷新图片" width="100" height="20" id="c2c98f0de5a04167a9e427d883690ff6" border="0">
                            </div>
                            <div class="underline"></div>
                        </div>
                       <div class="form-control">
                            <i class="icon-code"></i>
                            <input type="number" name="mobile_confirm_code" id="mobile_confirm_code" pattern="[0-9]*"
                                   placeholder="短信验证码"  oninput="if(value.length>6)value=value.slice(0,6)" data-rule-minlength="1" data-rule-required="true"  maxlength="6">
                            <a href="javascript:;">
                                <button class="send-code y" type="button" id="js-get_mobile_vcode">发送验证码</button>
                            </a>

                        </div>
                    </div>

                    <div class="function">
                        <p class="z"><a href="#" class="normal">普通登录</a></p>
                    </div>

                    <input class="btn-submit" type="submit" value="快捷登录" id="js-mobile_btns">
                </form>

                <div class="no-account">还没有账号？@if(session('status')==1) <a href="{{ url('newDisplay') }}">立即注册</a> @else <a
                        href="{{ url('newRegister') }}">立即注册</a>@endif</div>
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
    </div>
    <script src="js/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.fast').click(function(){
                $('#normal-login').hide();
                $('#fast-login').show();
            });
            $('.normal').click(function(){
                $('#normal-login').show();
                $('#fast-login').hide();
            });
        });
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

    <script>
        $(function () {
            var cg=0;
            // 若有錯誤提示才顯示
            var errorMessage = $('#error-message').val();
            if (errorMessage) {
                console.log('error message is ' + errorMessage);
                alert(errorMessage);
            }
            //刷新验证码
            $(".refresh").click(function(){
                $url = "{{ url('/captchaUpdate') }}";
                $url = $url + "/" + Math.random();
                document.getElementById('c2c98f0de5a04167a9e427d883690ff6').src=$url;
                return false;
            });
            //发送快捷登录验证码
            $('#js-get_mobile_vcode').click(function () {
                cg++;
                var tel = $('input[name=usernames]').val();
                var anotherMobile = $('input[name=anotherMobile]').val();
                var confirm_code = $('input[name=confirm_code]').val();
                var mobile_confirm_code = $('input[name=mobile_confirm_code]').val();
                if(tel=='')
                {
                    alert('手机号不能为空');
                    return false;
                }
                if (!/^1[3456789]\d{9}$/.test(tel) || tel == '') {
                    alert('请输入正确的手机号码!'); return false;
                }
                if(confirm_code=='')
                {
                    alert('图形验证码不能为空');
                    return false;
                }

                if(cg==1)
                {
                    // 发送快捷登录验证码
                    $.get('{{ url('sendFastCode') }}', {tel: tel,captcha:confirm_code}, function (data) {
                        $('input[name=usernames]').attr({'readOnly': true});
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
                    });
                }
            });
            // 提交普通form前先驗證輸入是否正確
            $("#normal-login").submit(function (event) {
                    event.preventDefault();
                    var tel = $('input[name=username]').val();
                    var password = $('input[name=dlpassword]').val();
                    if (tel == '') {
                        alert('手机号不能为空!');
                        return false;
                    }
                    if (!/^1[3456789]\d{9}$/.test(tel)) {
                        alert('请输入正确的手机号码!');
                        return false;
                    }
                    if (tel.length < 11) {
                        alert('请输入11位手机号码!');
                        return false;
                    }
                    if (password == '') {
                        alert('密码不能为空!');
                        return false;
                    }
                    if (password.length < 6) {
                        alert('请输入6-15位密码!');
                        return false;
                    }
                    this.submit();
            });
            // 提交快捷form前先驗證輸入是否正確
            $("#fast-login").submit(function (event) {
                    event.preventDefault();
                    var tel = $('input[name=usernames]').val();
                    var anotherMobile = $('input[name=anotherMobile]').val();
                    var confirm_code = $('input[name=confirm_code]').val();
                    var mobile_confirm_code = $('input[name=mobile_confirm_code]').val();
                    if(tel=='')
                    {
                        alert('手机号不能为空');
                        return false;
                    }
                    if (!/^1[3456789]\d{9}$/.test(tel) || tel == '')
                    {
                        alert('请输入正确的手机号码!'); return false;
                    }
                    if (tel.length < 11) {
                        alert('请输入11位手机号码!');
                        return false;
                    }
                    if(confirm_code=='')
                    {
                        alert('图形验证码不能为空');
                        return false;
                    }
                    if (confirm_code.length < 4) {
                        alert('请输入4位图形验证码!');
                        return false;
                    }
                    if(mobile_confirm_code=='')
                    {
                        alert('手机验证码不能为空');
                        return false;
                    }
                    if (mobile_confirm_code.length < 6) {
                        alert('请输入6位手机验证码!');
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
        $(document).ready(function () {
            $('#dlpassword').val('');
        });
    </script>
@endsection

