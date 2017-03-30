define(function (require , exports , module) {
    let $       = require('jquery');
    let common  = require('common/common');
    let layer   = require('layer');

    let post = function () {
        $('.form-submit').bind('click' , function () {

            var layerLoad = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });

            let formData = {};
            let formDataItem = $('.form-control');

            formDataItem.each(function (index , item) {
                formData[$(item).attr('name')] = $(item).val();
            });

            common.ajaxPost('/admin/wechat/add' , formData , function (error , data) {
                if (error == null && data.code == 0){
                    window.location.reload();
                }else if(error == null){
                    layer.alert(data.msg);
                }else{
                    layer.alert(error);
                }
                layer.close(layerLoad);
            });
        });
    }


    exports.post = post;
});