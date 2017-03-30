define(function (require , exports , module) {
    require('dmuploader');
    require('sortable');

    let $       = require('jquery');
    let common  = require('common/common');
    let layer   = require('layer');

    let message = {
        addLog: function (id, status, str) {
            let d = new Date();
            let li = $('<li />', {'class': 'demo-' + status});

            let message = '[' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds() + '] ';

            message += str;

            li.html(message);

            $(id).prepend(li);
        },

        addFile: function (id, i, file) {
            let url = window.URL || window.webkitURL;
            let imgURL = URL.createObjectURL(file);
            let template = '<div style="overflow: hidden;float: left;height: 186px;margin: 15px 0;" class="col-lg-3" id="demo-file' + i + '">' +
                '<div class="remove"><i class="icon-remove"></i></div>'+
                '<img class="goods-imgs" id="img-' + i + '" style="width: 100%;height:100%;" src="'+ imgURL +'">'+
                // '<span class="demo-file-id">#' + i + '</span> - ' + file.name + ' <span class="demo-file-size">(' + message.humanizeSize(file.size) + ')</span> - Status: <span class="demo-file-status">Waiting to upload</span>' +
                '<div style="position: absolute;top: 50%;margin-left: -15px;z-index: 100;" class="col-lg-12">'+
                '<div class="progress progress-striped active">' +
                '<div class="progress-bar" role="progressbar" style="width: 0%;">' +
                '<span class="sr-only">0% Complete</span>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';

            let i = $(id).attr('file-counter');
            if (!i) {
                $(id).empty();

                i = 0;
            }

            i++;

            $(id).attr('file-counter', i);

            $(id).append(template);
        },

        updateFileStatus: function (i, status, message) {
            $('#demo-file' + i).find('span.demo-file-status').html(message).addClass('demo-file-status-' + status);
        },

        updateFileProgress: function (i, percent) {

            $('#demo-file' + i).find('div.progress-bar').width(percent);

            $('#demo-file' + i).find('span.sr-only').html(percent + ' Complete');

        },

        humanizeSize: function (size) {
            let i = Math.floor(Math.log(size) / Math.log(1024));
            return ( size / Math.pow(1024, i) ).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
        }
    };

    let upImg = function () {
        $('#drag-and-drop-zone').dmUploader({
            url : '/admin/upload/img/goods',
            dataType : 'json',
            fileName : 'imgs',
            allowedTypes : 'image/*',
            onInit: function(){
                message.addLog('#demo-debug', 'default', 'Plugin initialized correctly');
            },
            onBeforeUpload: function(id){

                message.addLog('#demo-debug', 'default', 'Starting the upload of #' + id);

                message.updateFileStatus(id, 'default', 'Uploading...');
            },
            onNewFile: function(id, file){
                if(id >= 4){
                    alert('只允许上传4张图')
                    return false;
                }else {
                    message.addFile('#demo-files', id, file);
                }
            },
            onComplete: function(){
                message.addLog('#demo-debug', 'default', 'All pending tranfers completed');
            },
            onUploadProgress: function(id, percent){
                let percentStr = percent + '%';

                message.updateFileProgress(id, percentStr);
            },
            onUploadSuccess: function(id, data){
                message.addLog('#demo-debug', 'success', 'Upload of file #' + id + ' completed');

                message.addLog('#demo-debug', 'info', 'Server Response for file #' + id + ': ' + JSON.stringify(data));

                message.updateFileStatus(id, 'success', 'Upload Complete');

                message.updateFileProgress(id, '100%');

                if(data.code == 0){
                    $('#img-' + id).attr('src' , data.img_path);
                    let html = '<div style="background: #000;text-align: center;color: #fff"><i class="icon-ok-sign"></i>上传成功</div>';
                }else{
                    let html = '<div style="background: #000;text-align: center;color: #fff"><i class="icon-ok-sign"></i>上传成功</div>';
                }
                $('#demo-file' + id).find('div.progress').parent().html(html);
            },
            onUploadError: function(id, message){
                message.updateFileStatus(id, 'error', message);

                message.addLog('#demo-debug', 'error', 'Failed to Upload file #' + id + ': ' + message);
            },
            onFileTypeError: function(file){
                message.addLog('#demo-debug', 'error', 'File \'' + file.name + '\' cannot be added: must be an image');
            },
            onFileSizeError: function(file){
                message.addLog('#demo-debug', 'error', 'File \'' + file.name + '\' cannot be added: size excess limit');
            },
            /*onFileExtError: function(file){
             message.addLog('#demo-debug', 'error', 'File \'' + file.name + '\' has a Not Allowed Extension');
             },*/
            onFallbackMode: function(message){
                message.addLog('#demo-debug', 'info', 'Browser not supported(do something else here!): ' + message);
            }
        });
    };


    let ajaxAddGoods = function () {
        $('.form-submit').bind('click' , function () {
            let layerLoad = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });

            let formData = {};
            let formDataItem = $('.form-control');

            formDataItem.each(function (index , item) {
                formData[$(item).attr('name')] = $(item).val();
            });

            console.log(formData);
            let goodsImgs = $('#demo-files').find('.goods-imgs');

            if(goodsImgs.length == 0){
                layer.alert('请先上传商品图片');
            }else {
                let imgs = [];
                let sort = 1;
                goodsImgs.each(function (index , img) {
                    let img_tmp = {};
                    img_tmp['imgUrl']   = $(img).attr('src');
                    img_tmp['imgId']    = $(img).attr('img-id');
                    img_tmp['sort']     = sort;
                    imgs.push(img_tmp);
                    sort++;
                });

                formData['imgs'] = imgs;

                common.ajaxPost('/admin/goods/add', formData, function (error, data) {
                    if (error == null && data.code == 0) {
                        layer.msg('添加成功');
                        window.location.reload();
                    } else if (error == null && data.code != 0) {
                        layer.alert(data.msg);
                    } else {
                        layer.alert(error.statusText);
                    }
                    layer.close(layerLoad);
                });
            }
        });
    };
    
    let ajaxUpdateGoods = function () {
        $('.form-submit').bind('click' , function () {
            let layerLoad = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });

            let formData = {};
            let formDataItem = $('.form-control');

            formDataItem.each(function (index , item) {
                if($(item).attr('name') == 'status'){
                    if($(item).attr('checked') == 'checked'){
                        formData[$(item).attr('name')] = $(item).val();
                    }
                }else{
                    formData[$(item).attr('name')] = $(item).val();
                }
            });

            let goodsImgs = $('#demo-files').find('.goods-imgs');

            if(goodsImgs.length == 0){
                layer.alert('请先上传商品图片');
            }else {
                let imgs = [];
                let sort = 1;
                goodsImgs.each(function (index , img) {
                    let img_tmp = {};
                    img_tmp['imgUrl']   = $(img).attr('src');
                    img_tmp['imgId']    = $(img).attr('img-id');
                    img_tmp['sort']     = sort;

                    imgs.push(img_tmp);
                    sort++;
                });

                formData['imgs'] = imgs;

                common.ajaxPost('/admin/goods/update', formData, function (error, data) {
                    if (error == null && data.code == 0) {
                        layer.msg('修改成功');
                        window.location.reload();
                    } else if (error == null && data.code != 0) {
                        layer.alert(data.msg);
                    } else {
                        layer.alert(error.statusText);
                    }
                    layer.close(layerLoad);
                });
            }
        });
    };

    let sortImg = function () {
        $('#demo-files').sortable({
            group: 'photo',
            animation: 150
        });
    };

    let removeImg = function () {
        $('#demo-files').on('click' ,'.remove' , function () {
            $(this).parent().remove();
        });
    };


    exports.removeImg = removeImg;
    exports.upImg = upImg;
    exports.sortImg = sortImg;
    exports.ajaxAddGoods = ajaxAddGoods;
    exports.ajaxUpdateGoods = ajaxUpdateGoods;
});