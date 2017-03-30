<!-- Modal -->
<div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <form id="form-add-menu" class="form-horizontal tasi-form" method="post" action='/admin/menu/update-menu'>
                <input type="hidden" class="form-control" name='belong' id="edit_belong" value="1" />
                <input type="hidden" class="form-control" name='id' id="edit_id" value="" />
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">修改菜单</h4>
                </div>
                <div class="modal-body">
                    <section class="panel" style="margin-bottom:0px">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">菜单名称</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="edit_name" name='name' />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">该菜单父级</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name='pid' id='edit_pid'>
                                        <option value="0">选择</option>
                                    </select>
                                </div>
                            </div>
<!--                             <div class="form-group"> -->
<!--                                 <label class="col-sm-2 col-sm-2 control-label">菜单图标</label> -->
<!--                                 <div class="col-sm-10"> -->
<!--                                     <input type="text" class="form-control" id="edit_icon" name='icon' /> -->
<!--                                 </div> -->
<!--                             </div> -->
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">跳转连接</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="edit_url" name='url' />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">排序</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="edit_sort" name='sort' />
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
                <div class="modal-footer"  style="margin-top:0px">
                    <button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
                    <button class="btn btn-success" id="submit-update-menu" type="button">提交</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal -->

<script>
    $('.update').bind('click' , function(){
        var id = $(this).attr('mid');
        $.get('/admin/menu/menu-info?id=' + id , function(data){
            console.log(data);
            if(data.code == '0000'){
                $('#edit_name').val(data.data.name);
                $('#edit_url').val(data.data.rule);
                $('#edit_sort').val(data.data.sort);
                $('#edit_id').val(data.data.id);

                $.get('/admin/menu/menu-list-by-father' , function(fdata){
                    if(fdata.code == '0000'){
                        fdata.select = data.data.pid;
                        console.log(fdata);
                        var bt = baidu.template;
                        var html = '<option value="0">选择</option>' + bt('edit_menu' , fdata);
                        $('#edit_pid').html(html);
                    }
                });
            }
        });
    });
    $('#submit-update-menu').bind('click' , function () {
        var param = {
            name    : $('#edit_name').val(),
            pid     : $('#edit_pid').val(),
            rule     : $('#edit_url').val(),
            sort    : $('#edit_sort').val(),
            id      : $('#edit_id').val()
        };

		$.ajax({
			url  : '/admin/menu/update-menu',
			type : 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : param,
            dataType : 'json',
            success : function (data) {
                if(data.code != '0000'){
                    alert(data.msg);
                }else{
                    window.location.reload();
                }
            },
            error : function (error) {
                console.log('error');
            }
		});
    });
</script>

<script id='edit_menu' type='text/html'>
    <% for(var i = 0; i<data.length ; i++){%>
        <option value="<%= data[i].id %>" select="<%= select %>" <% if(select == data[i].id){ %> selected <% } %> ><%= data[i].name %></option>
	<%}%>
</script>