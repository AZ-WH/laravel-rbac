define(function (require , exports , module) {

    require('baiduTemplate');

    let $       = require('jquery');
    let common  = require('common/common');
    let layer   = require('layer');

    let addPermission = function () {

        $('.form-submit').bind('click' , function () {
            let formItem = $('.form-item');
            let formData = {};

            formItem.each(function(index , item){
                formData[$(item).attr('name')] = $(item).val();
            });

            formData['rule'] = [];
            let ruleLength = 0;

            $('.rule').each(function (index , rule) {
                if($(rule).attr('checked')){
                    formData['rule'].push($(rule).val());
                }
            });

            let layerLoad = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            common.ajaxPost('/admin/permission/add' , formData , function (error , data) {
                if(error == null && data.code == 0){
                    layer.msg('添加成功');
                    window.location.reload();
                }else if(error == null){
                    layer.msg(data.msg)
                }else{
                    layer.alert(error)
                }

                layer.close(layerLoad);
            });

        });
    };


    let updatePermission = function () {

        $('.form-submit').bind('click' , function () {
            let formItem = $('.form-item');
            let formData = {};

            formItem.each(function(index , item){
                formData[$(item).attr('name')] = $(item).val();
            });

            formData['rule'] = [];
            let ruleLength = 0;

            $('.rule').each(function (index , rule) {
                if($(rule).attr('checked')){
                    formData['rule'].push($(rule).val());
                }
            });

            let layerLoad = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            common.ajaxPost('/admin/permission/update' , formData , function (error , data) {
                if(error == null && data.code == 0){
                    layer.msg('修改成功');
                    window.location.reload();
                }else if(error == null){
                    layer.msg(data.msg)
                }else{
                    layer.alert(error)
                }
            });

        });
    };

    let getCheckedPermission = function (selectItem) {

        let _this = $(selectItem);
        if(_this.hasClass('child') && _this.prop('checked')){
            $('.father-' + _this.attr('pid')).prop('checked' , 'checked');
        }

        if(_this.hasClass('father') && _this.prop('checked')){
            $('.child-' + _this.val()).prop('checked' , 'checked');
        }

        if(_this.hasClass('father') && !_this.prop('checked')){
            $('.child-' + _this.val()).each(function (index , item) {
                __this = $(item);
                if(__this.prop('checked')){
                    $('.father-' + __this.attr('pid')).prop('checked' , 'checked');
                }
            });
        }

        let permission = [];
        $('.permission').each(function (index , item) {
            if($(item).prop('checked')){
                permission.push($(item).val());
            }
        });

        return permission;
    };

    let initRolePermission = function () {
        let __this = $($('.role')[0]);
        let roleId = __this.attr('role-id');
        let roleName = __this.attr('role-name');

        $('.current_role').attr('role-id' , roleId);
        $('.current_role').text(roleName);
        getRolePermission(roleId);
    };

    let changRole = function () {
        $('.table').on('click' , '.eye' , function () {

            $('.permission').each(function (index , item) {
                $(item).prop('checked' , '');
            });

            let __this = $(this);
            let roleId = __this.attr('role_id');
            let roleName = __this.attr('role_name');
            $('.current_role').attr('role-id' , roleId);
            $('.current_role').text(roleName);

            getRolePermission(roleId);
        });

    };

    let getRolePermission = function (roleId) {
        $.ajax({
            url : '/admin/roles/permission/' + roleId,
            type : 'GET',
            dataType : 'JSON',
            success : function (data) {
                data.data.forEach(function (permission) {

                    $('.permission').each(function (index , item) {
                        if(permission == $(item).val()){
                            $(item).prop('checked' , 'checked');
                        }
                    });
                });

            },
            error : function (error) {
                console.log(error);
            }
        });
    };
    
    let updateRoleName = function () {
        $('.update').bind('click' , function () {

            let roleId      = $(this).attr('role_id');
            let roleName    = $(this).attr('role_name');

            let html = baidu.template('edit-role', {
                roleId : roleId,
                roleName : roleName
            });

            layerDialog = layer.open({
                type: 1,
                skin: 'layui-layer-demo', //样式类名
                closeBtn: 1,
                area : ['600px' , '300px'],
                shadeClose: true, //开启遮罩关闭
                title : '修改角色',
                content: html
            });
        });  
    };

    let doupdateRoleName = function () {
        $('body').on('click' , '.update-form-button' , function () {
            let formData = {};
            $('.update-item').each(function(index , item){
                formData[$(item).attr('name')] = $(item).val();
            });
            common.ajaxPost('/admin/roles/update' , formData , function (error , data) {
                if(error == null && data.code == 0){
                    layer.msg('修改成功');
                }else if(error == null){
                    layer.msg(data.msg)
                }else{
                    layer.alert(error)
                }

                layer.close(layerDialog);
            });
        });
    };

    let addRole = function () {
        $('.form-submit').bind('click' , function () {
            let formData = {};
            $('.form-item').each(function(index , item){
                formData[$(item).attr('name')] = $(item).val();
            });
            common.ajaxPost('/admin/role/add' , formData , function (error , data) {
                if(error == null && data.code == 0){
                    layer.msg('添加成功');
                }else if(error == null){
                    layer.msg(data.msg)
                }else{
                    layer.alert(error)
                }
            });
        });
    };

    let addUser = function () {

        $('.form-submit').bind('click' , function () {

            let layerLoad = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });


            let formData = getFormData();

            common.ajaxPost('/admin/adminuser/add' , formData , function (error , data) {
                if(error == null && data.code == 0){
                    layer.msg('添加成功');
                    window.location.reload();
                }else if(error == null){
                    layer.msg(data.msg);
                }else{
                    layer.alert(error);
                }
                layer.close(layerLoad);
            });
        });
    };

    let getFormData = function () {
        let formData = {};
        $('.form-item').each(function(index , item){
            formData[$(item).attr('name')] = $(item).val();
        });

        let role = [];
        $('.role').each(function (index , item) {
            let __this = $(item);
            if(__this.prop('checked')){
                role.push(__this.val());
            }
        });

        formData['role'] = role;

        return formData;
    };

    let editUser = function () {

        $('.form-submit').bind('click' , function () {

            let layerLoad = layer.load(1, {
                shade: [0.1,'#fff']
            });

            let formData = getFormData();
            console.log(formData);

            common.ajaxPost('/admin/adminuser/update' , formData , function (error , data) {
                if(error == null && data.code == 0){
                    layer.msg('修改成功');
                    window.location.reload();
                }else if(error == null){
                    layer.msg(data.msg);
                }else{
                    layer.msg(error);
                }
                layer.close(layerLoad);
            });
        });
    };


    let initUserPermission = function () {
        let __this = $($('.user')[0]);
        let userId = __this.attr('user-id');
        let userName = __this.attr('user-name');

        $('.current_user').attr('user-id' , userId);
        $('.current_user').text(userName);

        getUserPermission(userId);
    };

    let changUser = function () {
        $('.table').on('click' , '.eye' , function () {

            $('.permission').each(function (index , item) {
                $(item).prop('checked' , '');
            });

            let __this = $(this);
            let userId = __this.attr('user-id');
            let userName = __this.attr('user-name');
            $('.current_user').attr('user-id' , userId);
            $('.current_user').text(userName);

            getUserPermission(userId);
        });

    };

    let getUserPermission = function (userId) {
        $.ajax({
            url : '/admin/adminuser/permission/' + userId,
            type : 'GET',
            dataType : 'JSON',
            success : function (data) {
                data.data.forEach(function (permission) {

                    $('.permission').each(function (index , item) {
                        if(permission == $(item).val()){
                            $(item).prop('checked' , 'checked');
                        }
                    });
                });

            },
            error : function (error) {
                console.log(error);
            }
        });
    };

    let updateRolePermission = function () {
        $('.table').on('click' , '.permission' , function () {

            let permission = getCheckedPermission(this);

            let roleId = $('.current_role').attr('role-id');
            common.ajaxPost('/admin/roles/update' , {id: roleId , permission:permission} , function (error , data) {
                if(error == null && data.code == 0){
                    layer.msg('修改成功');
                }else{
                    layer.alert(error)
                }
            });

        });
    };

    let updateUserPermission = function () {
        $('.table').on('click' , '.permission' , function () {

            let permission = getCheckedPermission(this);

            let userId = $('.current_user').attr('user-id');
            common.ajaxPost('/admin/adminuser/update/permission' , {id: userId , permission:permission} , function (error , data) {
                if(error == null && data.code == 0){
                    layer.msg('修改成功');
                }else{
                    layer.alert(error)
                }
            });

        });
    };

    let userlogin = function () {
        $('.form-submit').bind('click' , function () {
            let formData = {};
            $('.form-item').each(function(index , item){
                formData[$(item).attr('name')] = $(item).val();
            });

            common.ajaxPost('/admin/login' , formData , function (error , data) {
                if(error == null && data.code == 0){
                    window.location.href = '/admin/index';
                }
            });

        });
    };


    exports.login = userlogin;

    exports.addUser = addUser;
    exports.editUser = editUser;
    exports.initUserPermission = initUserPermission;
    exports.changUser = changUser;
    exports.updateUserPermission = updateUserPermission;


    exports.initRolePermission = initRolePermission;
    exports.updateRolePermission = updateRolePermission;
    exports.changRole = changRole;
    exports.updateRoleName = updateRoleName;
    exports.doupdateRoleName = doupdateRoleName;
    exports.addRole = addRole;


    exports.updatePermission = updatePermission;
    exports.addPermission = addPermission;
});