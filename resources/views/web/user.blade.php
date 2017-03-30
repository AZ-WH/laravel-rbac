@include('web.common.header')
<div id="content">
    <div class="user-item">
        <div class="user-item-icon"><i class="iconfont icon-mobile"></i></div>
        <div class="user-item-title">账号:{{ $user->mobile }}</div>
        <div>更换</div>
    </div>
    <a href="/user/address" class="user-item">
        <div class="user-item-icon"><i class="iconfont icon-province"></i></div>
        <div class="user-item-title">收货地址</div>
        <div><i class="iconfont icon-enter"></i></div>
    </a>
</div>
@include('web.common.footer-bottom')
@include('web.common.footer')