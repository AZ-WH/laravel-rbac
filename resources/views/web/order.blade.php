@include('web.common.header')
    <div id="content">
        @foreach($order as $o)
        <div class="cart">
            <div class="order-title">
                <div>订单编号:{{ $o->order_num }}</div>
                <div class="order-status" order_status="{{ $o->status }}">{{ $o->status_msg }}</div>
            </div>
            @foreach($o->goods as $og)
            <div class="cart-bottom">
                <div class="cart-bottom-left"><img src="{{ $og->img['imgUrl'] }}" title="{{ $og->show_title }}" alt="{{ $og->show_title }}" class=""></div>
                <div class="cart-bottom-center">
                    <div class="cart-bottom-right-title">{{ $og->show_title }}</div>
                    <div class="cart-bottom-right-price">￥{{ $og->now_price }}/{{ $og->unit }}</div>
                </div>
                <div class="cart-bottom-right">
                    {{ $og->buy_num }}份
                </div>
            </div>
            @endforeach
            <div class="order-pay-price-item order-pay-price-total">
                <div>总计</div>
                <div class="order-pay-price-total-num">￥{{ $o->pay_total }}</div>
            </div>
        </div>
        @endforeach
    </div>
@include('web.common.footer-bottom')
@include('web.common.footer')