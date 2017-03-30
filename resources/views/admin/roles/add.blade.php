@include('admin.common.header')

<!--tab nav start-->
<section class="panel">
    <header class="panel-heading tab-bg-dark-navy-blue ">
        <ul class="nav nav-tabs">
            <li @if ($_active['_action'] == 'list')  class="active" @endif>
                <a href="/admin/roles">角色列表</a>
            </li>
            <li @if ($_active['_action'] == 'add')  class="active" @endif>
                <a href="/admin/role/add">添加角色</a>
            </li>
        </ul>
    </header>
    <div class="panel-body">
        <div class="tab-content">
            <div class="row cmxform form-horizontal tasi-form">
                <div class="col-lg-12">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="form-group ">
                                <label for="name" class="control-label col-lg-2">角色名称</label>
                                <div class="col-lg-10">
                                    <input class="form-control form-item" id="name" name="name" placeholder="" type="text" />
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="col-lg-12 text-center">
                <button class="btn btn-danger form-submit" type="button">添加</button>
            </div>
        </div>
    </div>
</section>
<!--tab nav start-->

<script>
    require(['app/auth'] , function (auth ) {
        auth.addRole();
    });
</script>

@include('admin.common.footer')