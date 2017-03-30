<footer>
    <button href="/" class="button-a">
        <i class="iconfont icon-shouye" ></i>
        <div>商城</div>
    </button>
    <button href="/order/cart" class="button-a" >
        <i class="iconfont icon-gouwuche"></i>
        <div class="track-point"></div>
        <div>购物车</div>
    </button>
    <button href="/order" class="button-a">
        <i class="iconfont icon-wodedingdan"></i>
        <div>订单</div>
    </button>
    <button href="/user" class="button-a">
        <i class="iconfont icon-wodejuhuasuan"></i>
        <div>我的</div>
    </button>
</footer>

<script>
    require(['common/common'] , function (common) {
        common.buttonA();
    });
</script>