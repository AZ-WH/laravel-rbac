define(function (require , exports , module) {
    require('baiduTemplate');
    require('dropload');

    const $         = require('jquery');
    const layer     = require('layer');
    const common    = require('../common/common');

    let dropload = function() {
        // 上拉加载-----start------
        dropload = $('#content').dropload({
            distance : 100,
            domDown : {
                domClass   : 'dropload-down',
                domRefresh : '<div class="dropload-refresh">↑上拉加载更多</div>',
                domLoad    : '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
                domNoData  : '<div class="dropload-noData">暂无数据</div>'
            },
            loadDownFn : function(load){
                let page = $('#page').val();
                //这里的sessionStorage是为了解决微信内置浏览器返回上一页强制刷新的问题
                if(window.sessionStorage.length == 0){
                    $.ajax({
                        type: 'GET',
                        url: '/goods/list?page=' + page,
                        dataType: 'json',
                        success: function(data){
                            if(data.code == 0) {
                                if (data.data.list.length == 0) {
                                    load.noData(true);
                                    load.resetload();
                                }else {
                                    $('#page').val(data.data.pageData.page * 1 + 1);
                                    let uList = $('.list');
                                    let boxLen = uList.find('li').length;

                                    //更新商品的购买数量
                                    for (let list of data.data.list) {
                                        for (let cart of data.data.cartList) {
                                            if (list.id == cart.g_id) {
                                                list.buy_num = cart.buy_num;
                                            }
                                        }
                                    }

                                    //更新localstorage
                                    let cartStorage = window.localStorage.getItem('cart');
                                    cartStorage = JSON.parse(cartStorage);
                                    if(cartStorage == null){
                                        cartStorage = new Array;
                                        for (let cartl of data.data.cartList) {
                                            let addItem = new Object();
                                            addItem.goods_id = cartl.g_id;
                                            addItem.buy_num = cartl.buy_num;

                                            buyNum = addItem.buy_num;
                                            cartStorage.push(addItem);
                                        }
                                    }else {
                                        for (let cartl of data.data.cartList) {
                                            let finded = false;
                                            for (let carts of cartStorage) {
                                                if (cartl.g_id == carts.goods_id) {
                                                    carts.buy_num = cartl.buy_num;
                                                    finded = true;
                                                }
                                            }
                                            if(!finded){
                                                let addItem = new Object();
                                                addItem.goods_id = cartl.g_id;
                                                addItem.buy_num = cartl.buy_num;

                                                buyNum = addItem.buy_num;
                                                cartStorage.push(addItem);
                                            }
                                        }
                                    }
                                    window.localStorage.setItem('cart', JSON.stringify(cartStorage));

                                    let html = baidu.template('goodsList', {data: data.data.list, len: boxLen});
                                    uList.append(html);
                                    load.resetload();
                                }
                            }else{
                                load.noData(true);
                                load.resetload();
                            }
                        },
                        error: function(xhr, type){
                            layer.open({
                                content : '服务器链接错误' ,
                                skin : 'msg' ,
                                time : 2
                            });
                            // 即使加载出错，也得重置
                            load.noData(true);
                            load.resetload();
                        }
                    });
                }else{
                    $('.list').append(sessionStorage.getItem('storageHtml'));
                    document.body.scrollTop = sessionStorage.getItem('top');
                    sessionStorage.removeItem('storageHtml');
                    sessionStorage.removeItem('top');
                    load.resetload();
                }

            }
        });
        return dropload;
    };

    let storageGoods = function () {
        $('#content').on('click' , '.list a' , function () {
            /**
             * 微信内置浏览器返回上一页强制刷新
             */
            var storageHtml = $('.list').html();
            sessionStorage.setItem("storageHtml", storageHtml);
            sessionStorage.setItem("top",document.body.scrollTop);

        });
    };

    exports.storageGoods = storageGoods;
    exports.dropload = dropload;
});