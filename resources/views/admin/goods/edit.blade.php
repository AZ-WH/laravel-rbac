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
                            <input class=" form-control" value="{{ $info->id }}" name="id"  type="hidden" />
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">显示标题</label>
                                <div class="col-lg-10">
                                    <input class=" form-control" value="{{ $info->show_title }}" id="edit_show_title" name="show_title" placeholder="显示在前端的名称;如泰国进口芒果" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="lastname" class="control-label col-lg-2">商品名称</label>
                                <div class="col-lg-10">
                                    <input class=" form-control" value="{{ $info->name }}" id="edit_name" name="name" placeholder="商品本来的名称;如苹果,香蕉" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="lastname" class="control-label col-lg-2">分类</label>
                                <div class="col-lg-10">
                                    <select class=" form-control" name="c_id">
                                        <option value="0">请选择分类</option>
                                        <option value="1" @if($info->c_id == 1) selected @endif>水果</option>
                                        <option value="2" @if($info->c_id == 2) selected @endif>零食</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="username" class="control-label col-lg-2">产地</label>
                                <div class="col-lg-10">
                                    <input class="form-control " value="{{ $info->producing_area }}" id="edit_producing_area" name="producing_area" placeholder="如:湖南" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="password" class="control-label col-lg-2">规格</label>
                                <div class="col-lg-10">
                                    <input class="form-control " value="{{ $info->unit }}" id="edit_unit" name="unit" placeholder="如:一箱(六个装,每个约250g)" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="confirm_password" class="control-label col-lg-2">现价/元</label>
                                <div class="col-lg-10">
                                    <input class="form-control " value="{{ $info->now_price }}" id="edit_now_price" name="now_price" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="email" class="control-label col-lg-2">售价/元</label>
                                <div class="col-lg-10">
                                    <input class="form-control " value="{{ $info->out_price }}" id="edit_out_price" name="out_price" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="agree" class="control-label col-lg-2 col-sm-3">进价/元</label>
                                <div class="col-lg-10 col-sm-9">
                                    <input class="form-control " value="{{ $info->in_price }}" id="edit_in_price" name="in_price" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="newsletter" class="control-label col-lg-2 col-sm-3">库存/件</label>
                                <div class="col-lg-10 col-sm-9">
                                    <input class="form-control " value="{{ $info->stock_num }}" id="edit_stock_num" name="stock_num" type="text" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="newsletter" class="control-label col-lg-2 col-sm-3">是否上架</label>
                                <div class="col-lg-10 col-sm-9 radios has-js">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label class="label_radio @if($info->status == 1) r_on @else r_off @endif" for="radio-on">
                                                <input class="form-control " name="status" id="radio-on" value="1" type="radio" @if($info->status == 1) checked="checked" @endif>上架
                                            </label>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="label_radio @if($info->status == 0) r_on @else r_off @endif" for="radio-off">
                                                <input class="form-control " name="status" id="radio-off" value="0" type="radio" @if($info->status == 0) checked="checked" @endif>下架
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
                                            <div class="panel-body demo-panel-files" id='demo-files' file-counter="{{ count($info->imgs) }}">
                                                @if(count($info->imgs) == 0)
                                                <span class="demo-note">No Files have been selected/droped yet...</span>
                                                @else
                                                    @for($i=0 ; $i< count($info->imgs); $i++ )
                                                        <div style="padding:0;overflow: hidden;float: left;height: 186px;margin: 15px 15px 15px 0;" class="col-lg-3" id="demo-file">
                                                            {{--<div class="zhezhao">--}}
                                                                {{----}}
                                                            {{--</div>--}}
                                                            <div class="remove"><i class="icon-remove"></i></div>
                                                            <img class="goods-imgs" img-id="{{ $info->imgs[$i]['imgId'] }}" id="" style="width: 100%; height:100%;" src="{{ $info->imgs[$i]['imgUrl'] }} ">
                                                        </div>
                                                    @endfor
                                                @endif
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
                <button class="btn btn-danger form-submit" type="button">修改此商品</button>
            </div>
        </div>
    </div>
</section>
<!--tab nav start-->



<script>
    require(['app/goods' , 'common/common'] , function (app , common) {
        app.upImg();
        app.sortImg();
        app.ajaxUpdateGoods();
        app.removeImg();
        common.radioToggle();
    });
</script>

@include('admin.common.footer')