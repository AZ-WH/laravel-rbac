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
            <div class="row cmxform form-horizontal tasi-form">
                <div class="col-lg-6">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">显示标题</label>
                                <div class="col-lg-10">
                                    <input class=" form-control" id="show_title" name="show_title" placeholder="显示在前端的名称;如泰国进口芒果" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="lastname" class="control-label col-lg-2">商品名称</label>
                                <div class="col-lg-10">
                                    <input class=" form-control" id="name" name="name" placeholder="商品本来的名称;如苹果,香蕉" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="lastname" class="control-label col-lg-2">分类</label>
                                <div class="col-lg-10">
                                    <select class=" form-control" name="c_id">
                                        <option value="0">请选择分类</option>
                                        <option value="1">水果</option>
                                        <option value="2">零食</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="username" class="control-label col-lg-2">产地</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="producing_area" name="producing_area" placeholder="如:湖南" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="password" class="control-label col-lg-2">规格</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="unit" name="unit" placeholder="如:一箱(六个装,每个约250g)" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="confirm_password" class="control-label col-lg-2">现价/元</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="now_price" name="now_price" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="email" class="control-label col-lg-2">售价/元</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="out_price" name="out_price" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="agree" class="control-label col-lg-2 col-sm-3">进价/元</label>
                                <div class="col-lg-10 col-sm-9">
                                    <input class="form-control " id="in_price" name="in_price" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="newsletter" class="control-label col-lg-2 col-sm-3">库存/件</label>
                                <div class="col-lg-10 col-sm-9">
                                    <input class="form-control " id="stock_num" name="stock_num" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="newsletter" class="control-label col-lg-2 col-sm-3">是否上架</label>
                                <div class="col-lg-10 col-sm-9 radios has-js">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label class="label_radio r_on" for="radio-on">
                                                <input class="form-control " name="status" id="radio-on" value="1" type="radio" checked="">上架
                                            </label>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="label_radio r_off" for="radio-off">
                                                <input class="form-control " name="status" id="radio-off" value="1" type="radio" >下架
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-lg-6">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="form">
                                <div class="form-group ">
                                    <div class="col-lg-12">
                                        <!-- D&D Zone-->
                                        <div id="drag-and-drop-zone" class="uploader">
                                            <div>上传商品图片</div>
                                            <div>将图片拖拽到此处</div>
                                            <div class="or">-或者-</div>
                                            <div class="browser">
                                                <label>
                                                    <span>点击上传图片</span>
                                                    <input type="file" name="imgs[]" multiple="multiple" title='Click to add Files'>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Uploads</h3>
                                            </div>
                                            <div class="panel-body demo-panel-files" id='demo-files'>
                                                <span class="demo-note">No Files have been selected/droped yet...</span>
                                            </div>
                                        </div>
                                    </div>
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
    require(['app/goods' , 'common/common'] , function (app , common) {
        app.upImg();
        app.ajaxAddGoods();
        app.sortImg();
        common.radioToggle();
    });
</script>

@include('admin.common.footer')