
define(function (require , exports , module) {
    require('paginate');
    require('layer');
    let $           = require('jquery');

    let radioToggle = function () {
        $('.label_radio').bind('click' , function () {
            let _this = $(this);

            if(_this.has('r_off')){
                $('.label_radio.r_on').removeClass('r_on').addClass('r_off').find('input').removeAttr('checked');
                _this.addClass('r_on').find('input').attr('checked' , 'checked');
            }

        });
    };


    let ajaxPost = function (url , data , callback) {
        $.ajax({
            url     : url,
            type    : 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : data ,
            dataType : 'json' ,
            success : function (data) {
                callback(null , data);
            },
            error : function (error) {
                callback(error , {});
            }
        });
    };

    let showPage = function () {
        let lastPage = $('#lastPage').val();
        let page = $('#page').val();

        $("#page").paginate({
            count       :   lastPage ,
            start 		:   page ,
            display     : 24,
            border					: false,
            text_color  			: '#666',
            background_color    	: 'none',
            text_hover_color  		: '#fff',
            background_hover_color	: 'none',
            images		: false,
            mouse		: 'press' ,
            onChange     			: function(page) {
                if (location.search.indexOf("?") != -1) {
                    window.location.href += '&page=' + page;
                } else {
                    window.location.href += "?page=" + page;
                }
            }
        });
    };

    let GetRequest = function (obj) {
        let protocol = location.protocol;
        let host = location.host;
        let url = location.search; //获取url中"?"符后的字串
        let theRequest = new Object();
        if (url.indexOf("?") != -1) {
            let str = url.substr(1);
            strs = str.split("&");
            for(let i = 0; i < strs.length; i ++) {
                theRequest[strs[i].split("=")[0]] = unescape(strs[i].split("=")[1]);
            }
        }
        return theRequest;
    };

    let deleteNotice = function () {
        $('.delete').bind('click' , function () {
            let href = $(this).attr('href');
            let confirm = layer.confirm('您确定要删除此商品？', {
                btn: ['确定','取消'] //按钮
            }, function(yes){
                layer.close(yes);
                var layerLoad = layer.load(1, {
                    shade: [0.1,'#fff'] //0.1透明度的白色背景
                });
                $.ajax({
                    url     : href,
                    type    : 'GET',
                    dataType : 'json' ,
                    success : function (data) {
                        if(data.code == 0){
                            window.location.reload();
                        }else{
                            layer.alert(data.msg);
                        }
                        layer.close(layerLoad);
                    },
                    error : function (error) {
                        layer.alert(error.statusText);
                        layer.close(layerLoad);
                    }
                });
            }, function(no){
                layer.close(no);
            });
        });
    };


    let checkboxSwitch = function () {
        $('input:checkbox').bind('click' , function () {
            if($(this).attr('checked')){
                $(this).removeAttr('checked');
            }else{
                $(this).attr('checked' , true);
            }
        });
    };

    let getCurrentUser = function () {
        $.ajax({
            url : '/admin/current/user',
            type : 'GET',
            dataType : 'JSON',
            success:function (data) {
                if(data.code ==0){
                    $('#userinfo').text(data.data.name);
                    $('#userinfo').attr('uid' , data.data.id);
                }
            }
        });
    };

    exports.getCurrentUser = getCurrentUser;

    exports.checkboxSwitch = checkboxSwitch;
    exports.radioToggle = radioToggle;
    exports.ajaxPost = ajaxPost;
    exports.showPage = showPage;
    exports.deleteNotice = deleteNotice;

});
