@include('web.common.header')
    <header>
        <button id="nav-button"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
        <div id='title'>确认订单</div>
    </header>
    <div id="content">
        <div class="cart-address">
            <div class="order-peisong-notice">配送至</div>
            <div class="cart-address-name">
                <div>{{ $order->name }}</div>
                <div>{{ $order->address }}</div>
            </div>
            <div class="cart-address-tel">{{ $order->mobile }}</div>
        </div>
        <div class="order-comfirm-title">支付方式</div>
        <div class="order-pay-type-box">
            <div class="order-pay-type">
               <!--  <div class="order-pay-type-item bottom-line">
                    <img src="../imgs/alipay.png">
                    <span>支付宝支付</span>
                    <input type="radio" id="alipay" name="">
                    <label></label>
                </div> -->
                <div class="order-pay-type-item">
                    <img src="{{ URL::asset('/') }}web/imgs/wechat.png">
                    <span>微信支付</span>
                    <label class="label_radio ">
                    <i style="color: #ea4f55;" class="fa fa-check" aria-hidden="true"></i>
                        <input type="radio" checked="checked" id="wechat" name="">
                    </label>
                </div>
            </div>
        </div>
        <div class="order-comfirm-title">订单价格</div>
        <div class="order-pay-price-box">
            <div class="order-pay-price">
                <div class="order-pay-price-item bottom-line">
                    <div>商品总价</div>
                    <div>￥{{ $order->g_total_price }}</div>
                </div>
                <div class="order-pay-price-item bottom-line">
                    <div>服务费</div>
                    <div>￥{{ $order->service_charge }}</div>
                </div>
                {{--<div class="order-pay-price-item bottom-line">--}}
                    {{--<div>优惠券抵扣</div>--}}
                    {{--<div>￥0.00</div>--}}
                {{--</div>--}}
                <div class="order-pay-price-item order-pay-price-total">
                    <div>实际需支付</div>
                    <div class="order-pay-price-total-num">￥{{ $order->pay_total }}</div>
                </div>
            </div>
        </div>
        <div class="order-comfirm-title">商品清单</div>
        <div class="cart">
            @foreach( $order->goods  as $og )
            <div class="cart-bottom">
                <div class="cart-bottom-left"><img src="{{ $og->img['imgUrl'] }}" alt="{{ $og->show_title }}" title="{{ $og->show_title }}" class=""></div>
                <div class="cart-bottom-center">
                    <div class="cart-bottom-right-title">{{ $og->show_title }}</div>
                    <div class="cart-bottom-right-price">￥{{ $og->now_price }}/{{ $og->unit }}</div>
                </div>
                <div class="cart-bottom-right">
                    {{ $og->buy_num }}份
                </div>
            </div>
            @endforeach
        </div>
        <div class="cart-total-price">
            <div class="total">总价:<span class="total-price">￥{{ $order->pay_total }}</span></div>
            <button>去支付</button>
        </div>
    </div>
@include('web.common.footer')