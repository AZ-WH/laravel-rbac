@include('web.common.header')
    <div id="content">
        @foreach( $address as $a)
        <div class="address">
            <div class="address-left">
                <div class="address-left-content">
                    <div>{{ $a->name }}</div>
                    <div class="address-left-tel">{{ $a->mobile }}</div>
                </div>
                <div class="address-left-address">{{ $a->address }} {{ $a->house_number }}</div>
            </div>
            <div class="address-right" id="{{ $a->id }}"><i class="iconfont icon-bianji"></i></div>
        </div>
        @endforeach
        <div class="new-build-address">新建收货地址</div>
    </div>

    <script>
        require(['app/address'] , function (app) {
            app.alertAddAddressHtml();
            app.alertEditAddressHtml();
        });
    </script>
@include('web.common.footer')