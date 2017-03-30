<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <form id="form-add-menu" class="form-horizontal tasi-form" method="post" action='/admin/menu/add'>
                <input type="hidden" class="form-control" name='belong' id="belong" value="1" />
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">添加菜单</h4>
                </div>
                <div class="modal-body">
                    <section class="panel" style="margin-bottom:0px">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">菜单名称</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name='name' />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">该菜单父级</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name='pid' id='pid'>
                                        <option value="0">选择</option>
                                    </select>
                                </div>
                            </div>
<!--                             <div class="form-group"> -->
<!--                                 <label class="col-sm-2 col-sm-2 control-label">菜单图标</label> -->
<!--                                 <div class="col-sm-10"> -->
<!--                                     <input type="text" class="form-control" id="icon" name='icon' /> -->
<!--                                 </div> -->
<!--                             </div> -->
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">跳转连接</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="url" name='url' />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">排序</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="sort" name='sort' />
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
                <div class="modal-footer"  style="margin-top:0px">
                    <button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
                    <button class="btn btn-success" id="submit-add-menu" type="button">添加</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal -->

<script>
    $('.add').bind('click' , function(){
        $.get('/admin/menu/menu-list-by-father' , function(data){
            if(data.code == '0000'){
                var bt = baidu.template;
                var html = '<option value="0">选择</option>' + bt('menu' , data);
                console.log(html);
                $('#pid').html(html);
            }
        });
    });
    $('#submit-add-menu').bind('click' , function () {
        var param = {
            name    : $('#name').val(),
            pid     : $('#pid').val(),
            rule    : $('#url').val(),
            sort    : $('#sort').val()
        };
        
		$.ajax({
			url  : '/admin/menu/add-menu',
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

<script id='menu' type='text/html'>
    <% for(var i = 0; i<data.length ; i++){%>
        <option value="<%= data[i].id %>"><%= data[i].name %></option>
	<%}%>
</script>