<!-- Modal -->
<div class="modal fade" id="permission" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal tasi-form" method="post" action='/admin/admin/user/permission/update'>
                <input type="hidden" value="" id="roleId">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">角色权限</h4>
                </div>
                <div class="modal-body">
                    <section class="panel">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                            <tr>
                                <th style="text-align: center" width="20%">模块</th>
                                <th style="text-align: center" >方法</th>
                            </tr>
                            </thead>
                            <tbody class="dragsort permission_content">

                            </tbody>
                        </table>
                    </section>

                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
                    <button class="btn btn-success permission_submit" type="button">保存</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal -->

<script>
    $('.eye').bind('click' , function () {
        var roleId = $(this).attr('role_id');
        $('#roleId').val(roleId);
        $.get('/admin/roles/permission/' + roleId , function (data) {
            var bt = baidu.template;
            var html = bt('permission_html' , data);
            $('.permission_content').html(html);
        });
    })
    
    $('.permission_submit').bind('click' , function () {
        var permissionId = '';
        $('.permission_checkbox').each(function () {
            if($(this).attr('checked')){
                permissionId = permissionId + $(this).val() + ',';
            }
        });

        console.log($('#roleId').val());
        console.log(permissionId);
        $.post('/admin/role/permission/update/' + $('#roleId').val() , {'permissions' : permissionId} , function (data) {
            if(data.code == '0000'){
                confirm('操作成功');
            }else{
                confirm('操作失败');
            }
        });
        console.log(permissionId);
    });
</script>


<script id='permission_html' type='text/html'>
    <% for (var i = 0; i < data.length ; i++) {%>
    <tr>
        <td style="text-align: center">
            <label>
                <div type="button" class="btn btn-primary">
                    {{--<input style="margin-right: 10px;" type="checkbox" />--}}
                    <%= data[i].name %>
                </div>
            </label>
        </td>
        <td>
            <% for (var j = 0; j < data[i].child.length ; j++) {%>
            <label>
                <div type="button" class="btn btn-primary">
                    <input class="permission_checkbox" name="permissions[]" value="<%= data[i].child[j].id %>" style="margin-right: 10px;" type="checkbox" <% if(data[i].child[j].have == 1){%> checked <%}%>/>
                    <%= data[i].child[j].name %>
                </div>
            </label>
            <% } %>
        </td>
    </tr>
    <% } %>
</script>
