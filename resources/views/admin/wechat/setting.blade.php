@include('admin.common.header')
<style>
    #sidebar-nav{margin-top:-1px;border-right:1px solid #e7e7eb;height:100%}#sidebar-nav>ul>li{border-top:1px solid #e7e7eb;padding:10px 0}#sidebar-nav ul{padding:0;margin:0;list-style:none}#sidebar-nav ul li.separator{text-transform:none;display:block;padding:7px 16px;font-size:11px;border-bottom:0;color:#aaa}#sidebar-nav ul li a{color:#222;text-transform:uppercase;display:block;padding:5px 20px 5px 18px;position:relative}#sidebar-nav ul li a:hover{background:#f4f5f9}#sidebar-nav ul li a.active{color:#fff;background:#00B9FF}#sidebar-nav ul li a i{padding:0 20px;font-size:18px}#sidebar-nav ul li ul li a{padding:10px 20px 10px 75px}
</style>

<!--tab nav start-->
<section class="panel">
    <header class="panel-heading tab-bg-dark-navy-blue ">
        <ul class="nav nav-tabs">
            <li class="active" >
                <a data-toggle="tab" href="/admin/wechat">公众号功能管理</a>
            </li>
        </ul>
    </header>
    <div class="panel-body">
        <div class="tab-content">
            <div class="row">
                <div class="col-lg-2">
                    <aside class="console-sidebar-wrapper table-cell">
                        <nav id="sidebar-nav">
                            <ul class="list-nav nav-group-func" style="">
                                <li class="active">
                                    <a href="javascript:;"> <i class="ion-ios-chatboxes"></i>消息 <span class="pull-right"><i class="ion-arrow-down"></i></span></a>
                                    <ul class="nav-sub">
                                        <li><a href="http://local.viease.com/admin/message/timeline"><span>实时消息</span></a></li>
                                        <li><a href="http://local.viease.com/admin/message/resource"><span>消息资源库</span></a></li>
                                    </ul>
                                </li>
                                <li class="active">
                                    <a href="javascript:;"> <i class="ion-ios-keypad"></i>功能 <span class="pull-right"><i class="ion-arrow-down"></i></span></a>
                                    <ul class="nav-sub">
                                        <li><a href="http://local.viease.com/admin/fan"><span>粉丝管理</span></a></li>
                                        <li><a href="http://local.viease.com/admin/material"><span>素材管理</span></a></li>
                                        <li><a href="http://local.viease.com/admin/menu" class="active"><span>自定义菜单</span></a></li>
                                        <li><a href="http://local.viease.com/admin/reply"><span>自动回复</span></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </aside>
                </div>
                <div class="col-lg-10">
                    <section class="console-content-wrapper table-cell">
                        <div class="console-content">
                            <div class="page-header">
                                <h2 id="nav">菜单管理 <div class="pull-right"><button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="启用或停用菜单">停用</button></div></h2>
                            </div>
                            <div class="well row">
                                <div class="col-md-4">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">自定义菜单 <a href="javascript:;" data-toggle="tooltip" data-placement="top" title="" data-original-title="创建一个菜单" class="add-menu-item pull-right"><i class="ion-android-add icon-md"></i></a></div>
                                        <div class="list-group">
                                            <div class="menus resizeable"><div class="list-group-item menu-item" id="1487486677621" data-parent-id="0">
                                                    <div class="menu-item-heading">
                                                        <span class="menu-item-name">商城</span>
                                                        <div class="actions pull-right">
                                                            <a href="javascript:;" class="edit" title=""><i class="ion-ios-compose-outline"></i></a>
                                                            <a href="javascript:;" class="add-sub"><i class="ion-ios-plus-empty"></i></a>
                                                            <a href="javascript:;" class="trash"><i class="ion-ios-trash-outline"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="list-group sub-buttons no-menus"></div>
                                                </div><div class="list-group-item menu-item" id="" data-parent-id="">
                                                    <div class="menu-item-heading">
                                                        <span class="menu-item-name"></span>
                                                        <div class="actions pull-right">
                                                            <a href="javascript:;" class="edit" title=""><i class="ion-ios-compose-outline"></i></a>
                                                            <a href="javascript:;" class="add-sub"><i class="ion-ios-plus-empty"></i></a>
                                                            <a href="javascript:;" class="trash"><i class="ion-ios-trash-outline"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="list-group sub-buttons no-menus"></div>
                                                </div></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">自定义菜单</div>
                                        <div class="panel-body response-content">
                                            <div class="blankslate spacious">你可以从左边创建一个菜单并设置响应内容。</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="buttons col-md-12 text-center">
                                    <hr>
                                    <button class="btn btn-success submit-menu">提交</button>
                                    <button class="btn btn-default">重置</button>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</section>
<!--tab nav start-->

@include('admin.common.footer')