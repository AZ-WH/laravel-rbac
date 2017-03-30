define(function (require , exports , module) {
    require('baiduTemplate');

    const $         = require('jquery');
    const layer     = require('layer');
    const common    = require('common/common');

    let alertAddAddressHtml = function () {
        $('.new-build-address').bind('click' , function () {
            window.location.href = "/user/address-add";
        });
    };

    let alertEditAddressHtml = function () {
        $('.address-right').bind('click' , function () {
            let aid = $(this).attr('id');
            window.location.href = "/user/address-update/" + aid;
        });
    };

    let getProvince = function (selectId = 0) {
        $.ajax({
            'url'       : '/area?pid=0&level=province',
            'type'      : 'GET',
            'dataType'  : 'JSON',
            'success'   : function (data) {
                if(data.code == 0){
                    let html = '<option id="0">选择省份</option>';
                    for (let area of data.data){
                        if(selectId == area.id) {
                            html += '<option selected="true" value="' + area.id + '">' + area.name + '</option>';
                        }else {
                            html += '<option value="' + area.id + '">' + area.name + '</option>';
                        }
                    }
                    $('#province').html(html);
                }
            },
            'error'     : function (error) {
                layer.open({
                    content : '服务器链接错误' ,
                    skin : 'msg' ,
                    time : 2
                });
            }
        });
    };

    let getCity = function () {
        $('#province').bind('change' , function () {
            let pid = $(this).val();
            cityInit(pid);
        });
    };

    let cityInit = function (pid , selectId = 0) {

        $.ajax({
            'url'       : '/area?pid='+ pid +'&level=city',
            'type'      : 'GET',
            'dataType'  : 'JSON',
            'success'   : function (data) {
                if(data.code == 0){
                    let html = '<option id="0">选择城市</option>';
                    for (let area of data.data){
                        if(selectId == area.id) {
                            html += '<option selected="true" value="' + area.id + '">' + area.name + '</option>';
                        }else {
                            html += '<option value="' + area.id + '">' + area.name + '</option>';
                        }
                    }
                    $('#city').html(html);
                }
            },
            'error'     : function (error) {
                layer.open({
                    content : '服务器链接错误' ,
                    skin : 'msg' ,
                    time : 2
                });
            }
        });
    };

    let changeSex = function () {
        $('.sex-item').bind('click' , function () {
            $('.sex-item').css({color:'#666'});
            $(this).css({color:'#ea4f55'});
            $('#sex').attr('selectSex' , $(this).attr('id'));
        });
    };
    
    let addAddress = function () {
        $('.build-address').bind('click' , function () {
            let saveData = new Object();
            saveData.name            = $('#name').val();
            saveData.sex             = $('#sex').attr('selectSex');
            saveData.mobile          = $('#mobile').val();
            saveData.province        = $('#province').val();
            saveData.city            = $('#city').val();
            saveData.address         = $('#address').val();
            saveData.house_number    = $('#house_number').val();

            common.ajaxPost('/user/address-add' , saveData , function (error , data) {
                if(error == null && data.code == 0){
                    window.location.href = '/user/address';
                }else{
                    layer.open({
                        content : '添加失败' ,
                        skin : 'msg' ,
                        time : 2
                    });
                }
            });
        });  
    };

    let updateAddress = function () {
        $('.update-address').bind('click' , function () {
            let saveData = new Object();
            saveData.name            = $('#name').val();
            saveData.sex             = $('#sex').attr('selectSex');
            saveData.mobile          = $('#mobile').val();
            saveData.province        = $('#province').val();
            saveData.city            = $('#city').val();
            saveData.address         = $('#address').val();
            saveData.house_number    = $('#house_number').val();
            saveData.id              = $('#aid').val();

            common.ajaxPost('/user/address-update' , saveData , function (error , data) {
                if(error == null && data.code == 0){
                    window.location.href = '/user/address';
                }else{
                    layer.open({
                        content : '修改失败' ,
                        skin : 'msg' ,
                        time : 2
                    });
                }
            });
        });
    };

    exports.alertAddAddressHtml = alertAddAddressHtml;
    exports.alertEditAddressHtml = alertEditAddressHtml;
    exports.getProvince = getProvince;
    exports.getCity = getCity;
    exports.cityInit = cityInit;
    exports.addAddress = addAddress;
    exports.updateAddress = updateAddress;
    exports.changeSex = changeSex;
});