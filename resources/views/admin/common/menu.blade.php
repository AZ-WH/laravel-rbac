<div class="horizontal-menu navbar-collapse collapse ">
    <ul class="nav navbar-nav">
        <li @if ($_active['_model'] == 'index') class="active" @endif><a href="/admin/index">首页</a></li>

        <li class="dropdown" style="@if ($_active['_model'] == 'auth') background-color:#F77B6F;color: #fff; @endif">
            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#" style="@if ($_active['_model'] == 'auth') color: #fff; @endif">权限管理</a>
            <ul class="dropdown-menu">
                <li ><a href="/admin/adminuser">账号管理</a></li>
                <li ><a href="/admin/roles">角色管理</a></li>
                <li ><a href="/admin/permission">权限节点</a></li>
            </ul>
        </li>
    </ul>
</div>
