@include('admin.common.header')

<!--tab nav start-->
<section class="panel">
    <header class="panel-heading tab-bg-dark-navy-blue ">
        <ul class="nav nav-tabs">
            <li @if ($_active['_action'] == 'list')  class="active" @endif>
                <a data-toggle="tab" href="/admin/wechat">公众号列表</a>
            </li>
            <li @if ($_active['_action'] == 'add')  class="active" @endif>
                <a data-toggle="tab" href="/admin/wechat/add">添加公众号</a>
            </li>
        </ul>
    </header>
    <div class="panel-body">
        <div class="tab-content">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        @if(empty($data))
                        <div class="no-data" style="display: none;">暂无要查询的内容</div>
                        @else
                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>名称</th>
                                <th>微信号</th>
                                <th>类型</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $w)
                            <tr>
                                <td>{{ $w->name }}</td>
                                <td>{{ $w->wechat_account }}</td>
                                <td>@if($w->account_type == 1) 订阅号 @elseif($w->account_type == 2) 服务号 @endif</td>
                                <td>
                                    <a href="/admin/wechat/setting" target="_blank" class="btn btn-success btn-xs"><i class="icon-wrench"></i></a>
                                    <button class="btn btn-primary btn-xs"><i class="icon-pencil"></i></button>
                                    <button class="btn btn-danger btn-xs"><i class="icon-trash "></i></button>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @endif
                    </section>
                </div>
            </div>
        </div>
    </div>
</section>
<!--tab nav start-->

@include('admin.common.footer')