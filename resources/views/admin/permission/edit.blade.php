@include('admin.common.header')

<!--tab nav start-->
<section class="panel">
    <header class="panel-heading tab-bg-dark-navy-blue ">
        <ul class="nav nav-tabs">
            <li @if ($_active['_action'] == 'list')  class="active" @endif>
                <a href="/admin/permission">节点列表</a>
            </li>
            <li @if ($_active['_action'] == 'add')  class="active" @endif>
                <a href="/admin/permission/add">添加节点</a>
            </li>
        </ul>
    </header>
    <div class="panel-body">
        <div class="tab-content">
            <div class="row cmxform form-horizontal tasi-form">
                <div class="col-lg-12">
                    <section class="panel">
                        <div class="panel-body">
                            <input class="form-control form-item" name="id" type="hidden" value="{{ $info->id }}"/>
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">属于</label>
                                <div class="col-lg-10">
                                    <select class="form-control form-item" name="pid">
                                        <option value="0">请选择</option>
                                        @foreach($permission as $p)
                                            <option @if($info->pid == $p->id) selected="selected" @endif value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="name" class="control-label col-lg-2">节点名称</label>
                                <div class="col-lg-10">
                                    <input class="form-control form-item" id="name" name="name" placeholder="" type="text" value="{{ $info->name }}"/>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="lastname" class="control-label col-lg-2">包含的URL</label>
                                <div class="col-lg-10">
                                    @foreach($url as $u)
                                        <div class="col-lg-6">
                                            <label>
                                                <input @if(in_array($u->id , $info->url)) checked="checked" @endif name="rule[]" class="rule" type="checkbox" value="{{ $u->id }}" />
                                                <span style="font-size: 18px">{{ $u->url }} {{ $u->method }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="col-lg-12 text-center">
                <button class="btn btn-danger form-submit" type="button">修改</button>
            </div>
        </div>
    </div>
</section>
<!--tab nav start-->

<script>
    require(['app/auth' , 'common/common'] , function (auth , common) {
        auth.updatePermission();
        common.checkboxSwitch();
    });
</script>

@include('admin.common.footer')