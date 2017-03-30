
define(function (require , exports , module) {

    let $           = require('jquery');

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


    let buttonA = function () {
        $('.button-a').bind('click' , function () {
            window.location.href = $(this).attr('href');
        });

    };


    let addCart = function () {
        $('#content').on('click' , '.addCart' ,function () {
            let gid         = $(this).attr('gid');
            let buyNum      = 0;
            let buyNumItem  = $('.buy-num-'+gid);
            let finded      = false;
            let price       = $('.now-price-'+gid);

            let cartStorage = window.localStorage.getItem('cart');
            cartStorage = JSON.parse(cartStorage);

            if(cartStorage == null){
                cartStorage = new Array;
            }else {
                for (let cart of cartStorage) {
                    if (cart.goods_id == gid) {
                        cart.buy_num++;
                        buyNum = cart.buy_num;
                        finded = true;
                        break;
                    }
                }
            }

            if(!finded){
                let addItem = new Object();
                addItem.goods_id = gid;
                addItem.buy_num = 1;

                buyNum = addItem.buy_num;

                cartStorage.push(addItem);
            }

            ajaxPost('/order/update-cart' , {gid : gid , buy_num : buyNum} , function (error , data) {
                if(error === null && data.code == 0) {

                    if(buyNumItem.is('input')){
                        buyNumItem.val(buyNum);
                        buyNumItem.show();
                    }else{
                        buyNumItem.text(buyNum);
                        buyNumItem.show();
                    }

                    window.localStorage.setItem('cart', JSON.stringify(cartStorage));
                    countPrice();
                }else{
                    layer.open({
                        content : '添加购物车失败' ,
                        skin : 'msg' ,
                        time : 2
                    });
                }
            });


        })
    };


    let reduceCart = function () {
        $('#content').on('click' , '.reduceCart' ,function () {
            let gid         = $(this).attr('gid');
            let buyNumItem  = $('.buy-num-'+gid);
            let finded      = false;
            let buyNum      = 0;

            if(buyNumItem.is('input')){
                buyNum = buyNumItem.val();
            }else{
                buyNum = buyNumItem.text();
            }

            if(buyNum > 0){
                let cartStorage = window.localStorage.getItem('cart');
                cartStorage = JSON.parse(cartStorage);
                for (let cart of cartStorage) {
                    if (cart.goods_id == gid) {
                        cart.buy_num--;
                        buyNum = cart.buy_num;
                        break;
                    }
                }

                ajaxPost('/order/update-cart' , {gid : gid , buy_num : buyNum} , function (error , data) {
                    if(error === null && data.code == 0) {

                        if(buyNumItem.is('input')){
                            buyNumItem.val(buyNum);
                        }else{
                            buyNumItem.text(buyNum);
                            if(buyNum == 0){
                                buyNumItem.hide();
                            }
                        }

                        window.localStorage.setItem('cart', JSON.stringify(cartStorage));
                        countPrice();
                    }else{
                        layer.open({
                            content : '添加购物车失败' ,
                            skin : 'msg' ,
                            time : 2
                        });
                    }
                });

            }else{
                layer.open({
                    content : '已经没有了' ,
                    skin : 'msg' ,
                    time : 2
                });
            }
        })
    };


    let countPrice =  function () {
        let totalPrice = 0;
        let buyNum = $('.buy-num');
        $('.price').each(function (index , p) {
            let price = $(p).text();
            let num = $(buyNum[index]).val();

            totalPrice += price * num;
        });

        $('.total-price-num').text(totalPrice.toFixed(2));
    };

    exports.buttonA = buttonA;
    exports.ajaxPost = ajaxPost;
    exports.addCart = addCart;
    exports.reduceCart = reduceCart;
    exports.countPrice = countPrice;

});
