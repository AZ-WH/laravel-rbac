@include('admin.common.header')

<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <a class="btn btn-primary add" data-toggle="modal"  href="#add">添加菜单</a>
                    </header>
                    <div class="panel-body">
                        <section id="unseen">
                            <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                <tr>
                                    <th>名称</th>
                                    <th>链接</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody class="dragsort">
                                @foreach ($list as $m)
                                    <tr>
                                        <td><i class=""></i> {{ $m->name }}</td>
                                        <td>{{ $m->rule }}</td>
                                        <td>
                                            {{--<a p_id="{{ $m->id }}" display_name="{{ $m->name }}" level="1" class="btn btn-primary btn-xs addChild" data-toggle="modal" href="#addChild"><i class="icon-plus"></i></a>--}}
                                            <div  mid="{{ $m->id }}" data-toggle="modal" href="#update" class="btn btn-primary btn-xs update" ><i class="icon-pencil "></i></div>
                                            <a url="/admin/menu/del-menu?id={{ $m->id }}" data-toggle="modal" href="#warning" class="btn btn-danger btn-xs warning"><i class="icon-trash "></i></a>
                                        </td>
                                    </tr>
                                    @foreach ($m->child as $mc)
                                        <tr>
                                            <td style='padding-left:30px;'>|----- {{ $mc->name }}</td>
                                            <td>{{   $mc->rule }}</td>
                                            <td>
                                                {{--<a p_id="{{ $mc->id }}" display_name="{{ $mc->name }}" level="2" class="btn btn-primary btn-xs addChild" data-toggle="modal" href="#addChild"><i class="icon-plus"></i></a>--}}
                                                <div mid="{{ $mc->id }}" level="0" data-toggle="modal" href="#update" class="btn btn-primary btn-xs update"><i class="icon-pencil"></i></div>
                                                <a url="/admin/menu/del-menu?id={{ $mc->id }}" data-toggle="modal" href="#warning" class="btn btn-danger btn-xs warning"><i class="icon-trash "></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </section>
                    </div>
                </section>
            </div>
        </div>
    </section>
</section>
<!--main content end-->
@include('admin.menu.add')
@include('admin.menu.edit')
@include('admin.moduls.warning')

@include('admin.common.footer')
