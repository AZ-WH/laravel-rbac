@include('web.common.header')
<div id="content">
    <div class="address-add">
        <div class="address-add-item address-add-item-juxb">
            <input type="hidden" name="id" id="aid" value="{{ $address->id }}" />
            <div class="address-add-name">
                <div class="address-add-icon"><i class="iconfont icon-user"></i></div>
                <div><input class="address-add-input" type="text" name="name" id="name" placeholder="收货人姓名" value="{{ $address->name }}"></div>
            </div>
            <div class="address-add-sex" selectSex="{{ $address->sex }}" id="sex">
                <div class="sex-item" style="@if($address->sex == 1) color: #ea4f55 @endif" id="1">女生</div>
                <div class="sex-item" style="@if($address->sex == 2) color: #ea4f55 @endif" id="2">先生</div>
            </div>
        </div>
        <div class="address-add-item">
            <div class="address-add-icon"><i class="iconfont icon-mobile"></i></div>
            <div><input  class="address-add-input" type="text" name="mobile" id="mobile" placeholder="联系电话" value="{{ $address->mobile }}"></div>
        </div>
        <div class="address-add-item">
            <div class="address-add-icon"><i class="iconfont icon-city"></i></div>
            <div>
                <select class="address-add-input address-add-select" name="province" id="province">
                    <option value="0">选择省份</option>
                </select>
            </div>
            <div>
                <select  class="address-add-input address-add-select" name="city" id="city">
                    <option value="0">选择城市</option>
                </select>
            </div>
        </div>
        <div class="address-add-item">
            <div class="address-add-icon"><i class="iconfont icon-address"></i></div>
            <div class="address-detail"><input  class="address-add-input" type="text" name="address" id="address" placeholder="详细地址" value="{{ $address->address }}"></div>
        </div>
        <div class="address-add-item">
            <div class="address-add-icon"><i class="iconfont icon-menpaihao"></i></div>
            <div><input  class="address-add-input" type="text" name="house_number" id="house_number" placeholder="楼号、单元和门牌号" value="{{ $address->house_number }}"></div>
        </div>
    </div>
    <div class="update-address">编辑地址</div>
</div>

<script>
    require(['app/address'] , function (app) {
        app.getProvince({{ $address->province }});
        app.getCity();
        app.cityInit({{ $address->province }} , {{ $address->city }});
        app.changeSex();
        app.updateAddress();
    } );
</script>
@include('web.common.footer')