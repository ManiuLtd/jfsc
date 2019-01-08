@extends('layouts.autht')
@section('content')

            <form id="reset-form" action="{{ url('nick') }}" method="post" autocomplete="off">
                {{ csrf_field() }}
                <div class="list-body">

                    <div class="form-control no-icon">
                        <input type="text" name="nick" placeholder="请输入您的新昵称" data-rule-minlength="1" data-rule-required="true" maxlength="6"/>
                    </div>

                </div>
                <input class="btn-submit exit" type="submit" value="确 定" id="js-mobile_btn">
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
                var nick=$('input[name=nick]').val();
                if(nick==''){
                    alert('新昵称不能为空!');
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
