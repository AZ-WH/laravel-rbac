@include('web.common.header')
    <div id="content">
        <div class="address-add">
            <div class="address-add-item address-add-item-juxb">
                <div class="address-add-name">
                    <div class="address-add-icon"><i class="iconfont icon-user"></i></div>
                    <div><input class="address-add-input" type="text" name="name" id="name" placeholder="收货人姓名"></div>
                </div>
                <div class="address-add-sex" selectSex="1" id="sex">
                    <div class="sex-item" style="color: #ea4f55" id="1">女生</div>
                    <div class="sex-item" id="2">先生</div>
                </div>
            </div>
            <div class="address-add-item">
                <div class="address-add-icon"><i class="iconfont icon-mobile"></i></div>
                <div><input  class="address-add-input" type="text" name="mobile" id="mobile" placeholder="联系电话"></div>
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
                <div class="address-detail"><input  class="address-add-input" type="text" name="address" id="address" placeholder="详细地址"></div>
            </div>
            <div class="address-add-item">
                <div class="address-add-icon"><i class="iconfont icon-menpaihao"></i></div>
                <div><input  class="address-add-input" type="text" name="house_number" id="house_number" placeholder="楼号、单元和门牌号"></div>
            </div>
        </div>
        <div class="build-address">添加地址</div>
    </div>

<script>
    require(['app/address'] , function (app) {
        app.getProvince();
        app.getCity();
        app.addAddress();
        app.changeSex();
    } );
</script>
@include('web.common.footer')