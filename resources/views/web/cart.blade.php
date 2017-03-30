@include('web.common.header')
    <div id="content">
        <div class="cart-address">
            @if($address)
            <div class="cart-address-name" id="choice-address" address-id="1">
                <div>吴辉</div>
                <div>融科橄榄城</div>
            </div>
            <div class="cart-address-tel">18874130125</div>
            @else
                <div>没有收货地址,去添加一个</div>
            @endif
            <div class="cart-address-icon"><i class="iconfont icon-enter" ></i></div>
        </div>
        <div class="cart">
            @foreach($carts as $c)
            <div class="cart-bottom">
                <div class="cart-bottom-left"><img src="{{ $c->img }}" alt="{{ $c->show_title }}" title="{{ $c->show_title }}" class=""></div>
                <div class="cart-bottom-center">
                    <div class="cart-bottom-right-title">{{ $c->show_title }}</div>
                    <div class="cart-bottom-right-price">￥<span class="price now-price-{{ $c->g_id }}">{{ $c->now_price }}</span>/{{ $c->unit }})</div>
                </div>
                <div class="cart-bottom-right">
                    <button gid="{{ $c->g_id }}" class="reduceCart"><i class="iconfont icon-jianhao"></i></button>
                    <input class="buy-num buy-num-{{ $c->g_id}}" type="text" name="" value="{{ $c->buy_num }}">
                    <button gid="{{ $c->g_id }}" class="addCart"><i  class="iconfont icon-jiahao1 "></i></button>
                </div>
            </div>
            @endforeach
        </div>
        <div class="cart-total-price">
            <div class="total">总价:<span class="total-price">￥<span class="total-price-num">00.00</span></span></div>
            <button class="comfirm">结算</button>
        </div>
    </div>


<script>

    require(['app/cart'   , 'common/common'] , function (app , common) {

        app.alertAddressHtml();
        app.alertComfirmHtml();

        common.addCart();
        common.reduceCart();
        common.countPrice();
    });
</script>
@include('web.common.footer-bottom')
@include('web.common.footer')