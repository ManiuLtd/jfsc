@extends('layouts.auth')

@section ('title', '重設密碼-富連網賬號中心')

@section('content')
    <div id="login-panel">
        <div id="box">
            <center><img src="/flnet/img/flnet.png" width="80">
                <h3>重設密碼</h3></center>

            <p class="tip">請輸入新密碼</p>

            <form id="login-form" class="form-horizontal" action="/reset-password" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="agent" value="mobile">
                <div class="form-control">
                    <i class="font-icon password"></i><input type="password" minlength="6" name="password" size="30" placeholder="密碼" />
                </div>
                <button class="pn pnc btn-submit" type="submit">確認</button>
            </form>
        </div>
    </div>
@endsection
