@include('admin.common.header')
<!--tab nav start-->
<section class="panel">
    <header class="panel-heading tab-bg-dark-navy-blue ">
        <ul class="nav nav-tabs">
            <li @if ($_active['_action'] == 'list')  class="active" @endif>
                <a href="/admin/adminuser">账号列表</a>
            </li>
            <li @if ($_active['_action'] == 'add')  class="active" @endif>
                <a href="/admin/adminuser/add">添加账号</a>
            </li>
        </ul>
    </header>
    <div class="panel-body">
        <div class="tab-content">
            <div class="row">
                <div class="col-lg-4">
                    <section class="panel">
                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th width="40%">名称</th>
                                <th>角色</th>
                                <th style="text-align: right">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($user as $u)
                                <tr class="user" user-id="{{ $u->id }}" user-name="{{ $u->name }}">
                                    <td>{{ $u->name }}</td>
                                    <td>
                                        @foreach($u->role as $ur)
                                            <div>{{ $ur->name }}</div>
                                        @endforeach
                                    </td>
                                    <td style="text-align: right">
                                        <div class="btn btn-primary btn-xs eye" user-id="{{ $u->id }}" user-name="{{ $u->name }}"><i class="icon-eye-open"></i></div>
                                        <a target="_blank" href="/admin/adminuser/info/{{ $u->id }}" class="btn btn-primary btn-xs update"><i class="icon-pencil"></i></a>
                                        <div href="/admin/adminuser/delete/{{ $u->id }}" class="btn btn-danger btn-xs delete"><i class="icon-trash "></i></div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </section>
                </div>
                <div class="col-lg-8">
                    <section class="panel">
                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th width="10%"><span style="color: #F77B6F" class="current_user"></span>权限</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($permissions as $p)
                                <tr>
                                    <td>
                                        <label>
                                            <input class="user permission father father-{{ $p->id }}" name="permission" type="checkbox" value="{{ $p->id }}">
                                            {{ $p->name }}
                                        </label>
                                    </td>
                                    <td style="text-align: left;border-left: 1px solid #ccc ">
                                        @foreach($p->child as $pc)
                                            <label style="margin-right: 10px;">
                                                <input class="user permission child child-{{ $p->id }}" pid="{{ $p->id }}" name="permission" type="checkbox" value="{{ $pc->id }}">
                                                {{ $pc->name }}
                                            </label>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
        </div>
    </div>
</section>
<!--tab nav start-->

<script>
    require(['app/auth' , 'common/common'] , function (auth , common) {
        common.deleteNotice();

        auth.initUserPermission();
        auth.changUser();
        auth.updateUserPermission();
    })
</script>

@include('admin.common.footer')