@include('admin.common.header')

<!--tab nav start-->
<section class="panel">
    <header class="panel-heading tab-bg-dark-navy-blue ">
        <ul class="nav nav-tabs">
            <li @if ($_active['_action'] == 'list')  class="active" @endif>
                <a href="/admin/wechat">公众号列表</a>
            </li>
            <li @if ($_active['_action'] == 'add')  class="active" @endif>
                <a href="/admin/wechat/add">添加公众号</a>
            </li>
        </ul>
    </header>
    <div class="panel-body">
        <div class="tab-content">
            <div class="row cmxform form-horizontal tasi-form">
                <div class="col-lg-6">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">公众号名称</label>
                                <div class="col-lg-10">
                                    <input class="form-control" id="name" name="name" placeholder="例如:农进城" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="lastname" class="control-label col-lg-2">公众号原始Id</label>
                                <div class="col-lg-10">
                                    <input class=" form-control" id="original_id" name="original_id" placeholder="请认真填写,错了不能修改.例如gh_gks84hksi90o" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="username" class="control-label col-lg-2">微信号</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="wechat_account" name="wechat_account" placeholder="例如:农进城" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="password" class="control-label col-lg-2">AppID(公众号)</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="app_id" name="app_id" placeholder="用户自定义菜单等高级功能" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="confirm_password" class="control-label col-lg-2">AppSecret</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="app_secret" name="app_secret" placeholder="用户自定义菜单等高级功能" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="lastname" class="control-label col-lg-2">微信号类型</label>
                                <div class="col-lg-10">
                                    <select class=" form-control" name="account_type">
                                        <option value="1">订阅号</option>
                                        <option value="2">服务号</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="col-lg-offset-2 col-lg-10">
                <button class="btn btn-danger form-submit" type="button">添加</button>
            </div>
        </div>
    </div>
</section>
<!--tab nav start-->

<script>
    require(['app/wechat'] , function (app) {
        app.post();
    });
</script>

@include('admin.common.footer')