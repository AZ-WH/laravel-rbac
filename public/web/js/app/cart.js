define(function (require , exports , module) {
    require('baiduTemplate');

    const $         = require('jquery');
    const layer     = require('layer');
    const common    = require('common/common');

    let alertAddressHtml = function () {
        $('.cart-address').bind('click' , function () {
            window.location.href = "/user/address";
        });
    };

    let alertComfirmHtml = function () {
        $('.comfirm').bind('click' , function () {

            $goods      = window.localStorage.getItem('cart');
            $addressId  = $('#choice-address').attr('address-id');

            common.ajaxPost('/order/init' , {
                goods : $goods,
                address_id : $addressId
            } , function (error , data) {
                if(error == null && data.code == 0){
                    window.localStorage.removeItem('cart');
                    $.ajax({
                        url : '/order/cart-clear',
                        type : 'GET',
                        dataType : 'JSON',
                        success : function (data) {
                            
                        }
                    });
                    window.location.href = '/order/comfirm/' + data.data;
                }else{
                    layer.open({
                        content : '结算失败,稍后再试' ,
                        skin : 'msg' ,
                        time : 2
                    });
                }

            });

            // window.location.href = "/order/comfirm";
        });
    };

    exports.alertComfirmHtml = alertComfirmHtml;
    exports.alertAddressHtml = alertAddressHtml;
});