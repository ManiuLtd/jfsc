@extends('layouts.autht')
@section ('title', '开通自动续费')
@section('content')
    <center><h3>夏普电视VIP自动续费</h3></center><br>
   <center>深圳市富连网物联网智能家居有限公司</center><p></p>
   <hr>
   <span>用户账号</span><span style="margin-right: 33px;">富连网物联网智能家居</span>
   <span>套餐内容</span><span style="margin-right: 33px;">续费30元/月。套餐到期前1天将通过微信支付为您发起自动续费，自动延长一个月有效期，如关闭则不再主动发起续费</span><br><hr>
   <span>扣款方式</span><span style="margin-right: 33px;"><select name="payMethod"><option value="1">零钱</option><option value="2">银行卡</option></select>></span><br>
   <span>优先从所选扣费方式中扣除，扣费失败时将从其他扣费方式中扣除。</span><p></p><p></p>
    <center><a href="{{ url('wxAutoPay') }}"><button class="btn-submit exit">开通自动续费</button></a> </center>
    <p></p><p></p>
@endsection
