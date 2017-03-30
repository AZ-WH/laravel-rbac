@include('admin.common.header')
<!--tab nav start-->
<section class="panel">
    <header class="panel-heading tab-bg-dark-navy-blue ">
        <ul class="nav nav-tabs">
            <li @if ($_active['_action'] == 'list-on')  class="active" @endif>
                <a href="/admin/goods?type=1">在售商品</a>
            </li>
            <li @if ($_active['_action'] == 'list-off')  class="active" @endif>
                <a href="/admin/goods?type=0">下架商品</a>
            </li>
            <li @if ($_active['_action'] == 'add')  class="active" @endif>
                <a href="/admin/goods/add">添加商品</a>
            </li>
        </ul>
    </header>
    <div class="panel-body">
        <div class="tab-content">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        @if($goods['pageData']['count'] == 0)
                            <div class="no-data">暂无要查询的内容</div>
                        @else
                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>显示名称</th>
                                <th>商品名称</th>
                                <th>产地</th>
                                <th>规格</th>
                                <th>进价</th>
                                <th>售价</th>
                                <th>现价</th>
                                <th>库存</th>
                                <th>上架时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($goods['list'] as $g)
                            <tr>
                                <td>{{ $g->show_title }}</td>
                                <td>{{ $g->name }}</td>
                                <td>{{ $g->producing_area }}</td>
                                <td>{{ $g->unit }}</td>
                                <td>{{ $g->in_price }}</td>
                                <td>{{ $g->out_price }}</td>
                                <td><span class="label label-info label-mini">{{ $g->now_price }}</span></td>
                                <td>{{ $g->stock_num }}</td>
                                <td>{{ $g->on_off_time }}</td>
                                <td>
                                    <a href="/admin/goods/info/{{ $g->id }}" target="_blank" class="btn btn-primary btn-xs update" gid="{{ $g->id }}"><i class="icon-pencil"></i></a>
                                    <button href="/admin/goods/delete/{{ $g->id }}" class="delete btn btn-danger btn-xs"><i class="icon-trash "></i></button>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @endif
                    </section>
                </div>
            </div>
            @if($goods['pageData']['lastPage'] > 1)
            <div id="page" style="width:500px;margin: 0 auto;">
                {!!  $goods['pageData']['pageHtml'] !!}
            </div>
            @endif
        </div>
    </div>

</section>
<!--tab nav start-->


<script>

    require(['common/common'] , function (common) {
        common.deleteNotice();
    });

</script>
@include('admin.common.footer')