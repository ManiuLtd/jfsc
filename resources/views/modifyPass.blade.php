@extends('layouts.autht')
@section('content')
    <form action="{{ url('handleModifyPass') }}" method="post" autocomplete="off" >
        {{ csrf_field() }}
        <input type="hidden" name="zhumima" value="{{ session('pass') }}"/>
        <div class="list-body">
            <div class="form-control no-icon">
                <input type="password" name="oldpassword" placeholder="原始密码" data-rule-minlength="6" data-rule-required="true" minlength="6" maxlength="15"/>
            </div>
            <div class="form-control no-icon">
                <input type="password" name="newpassword" placeholder="新密码" data-rule-minlength="6" data-rule-required="true" minlength="6" maxlength="15"/>
            </div>
            <div class="form-control no-icon">
                <input type="password" name="xgpassword" placeholder="再次输入新密码" data-rule-minlength="6" data-rule-required="true" minlength="6" maxlength="15"/>
            </div>

        </div>
        <input class="btn-submit exit" type="submit" value="保 存" id="js-mobile_btn">
    </form>
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
                var oldpassword=$('input[name=oldpassword]').val();
                var newpassword=$('input[name=newpassword]').val();
                var password=$('input[name=xgpassword]').val();
                var zhumima=$('input[name=zhumima]').val();
                if(oldpassword==''){
                    alert('原始密码不能为空!');
                    return false;
                }
                if(newpassword==''){
                    alert('新密码不能为空!');
                    return false;
                }
                if(password==''){
                    alert('确认密码不能为空!');
                    return false;
                }
                if(oldpassword !== zhumima)
                {
                    alert('原始密码输入有误!');
                    return false;
                }
                if(newpassword !== password)
                {
                    alert('两次输入的密码不一样!');
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
@endsection
