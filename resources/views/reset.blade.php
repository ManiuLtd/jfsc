@extends('layouts.auth')
@section('content')
    <div class="container">
        <div class="row">
            <p class="tip">请输入6-15个字符新密码，可使用数字、字母与符号</p>
            <form id="reset-form" action="{{ url('reset') }}" method="post" autocomplete="off" class="panel">
                {{ csrf_field() }}
                <div class="field">
                    <div class="form-control">
                        <i class="icon-lock"></i><input type="password" minlength="6" name="resetpassword" placeholder="请输入新密码" data-rule-minlength="6" data-rule-required="true" maxlength="15" id="resetpassword"/>
                    </div>
                </div>
                <center><input class="btn-submit" type="submit" value="确定" id="js-mobile_btn"></center>
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
        $(function(){
            $('#js-mobile_btn').click(function(){
                var password=$('input[name=resetpassword]').val();
                if(password==''){
                    alert('新密码不能为空!');
                    return false;
                }
            });
        })
    </script>
    <script>
        (function(){
            window.alert = function(name){
                var iframe = document.createElement("IFRAME");
                iframe.style.display="none";
                document.documentElement.appendChild(iframe);
                window.frames[0].window.alert(name);
                iframe.parentNode.removeChild(iframe);
            }
        })();
    </script>
    <script>
        $(document).ready(function(){
            $('#resetpassword').val('');
        });
    </script>
@endsection
