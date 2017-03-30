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
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <table class="table table-striped table-advance table-hover">
                            <thead>
                                <tr>
                                    <th width="40%">名称</th>
                                    <th width="40%">包含链接</th>
                                    <th style="text-align: right">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($permission as $p)
                                <tr>
                                    <td>{{ $p->name }}</td>
                                    <td>
                                        @foreach($p->url as $pu)
                                            <div>{{ $pu->url }} {{ $pu->method }}</div>
                                        @endforeach
                                    </td>
                                    <td style="text-align: right">
                                        <a target="_blank" href="/admin/permission/info/{{ $p->id }}" class="btn btn-primary btn-xs update"><i class="icon-pencil"></i></a>
                                        <div href="/admin/permission/delete/{{ $p->id }}" class="btn btn-danger btn-xs delete"><i class="icon-trash "></i></div>
                                    </td>
                                </tr>
                                @foreach($p->child as $pc)
                                <tr>
                                    <td>------------{{ $pc->name }}</td>
                                    <td>
                                        @foreach($pc->url as $pcu)
                                            <div>{{ $pcu->url }} {{ $pcu->method }}</div>
                                        @endforeach
                                    </td>
                                    <td style="text-align: right">
                                        <a target="_blank" href="/admin/permission/info/{{ $pc->id }}" class="btn btn-primary btn-xs update"><i class="icon-pencil"></i></a>
                                        <a ref="/admin/permission/delete/{{ $pc->id }}" class="btn btn-danger btn-xs delete"><i class="icon-trash "></i></a>
                                    </td>
                                </tr>
                                @endforeach
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
    require(['common/common'] , function (common) {
        common.deleteNotice();
    })
</script>

@include('admin.common.footer')