@include('admin.common.header')
<!--tab nav start-->
<section class="panel">
    <header class="panel-heading tab-bg-dark-navy-blue ">
        <ul class="nav nav-tabs">
            <li @if ($_active['_action'] == 'list')  class="active" @endif>
                <a href="/admin/manufactor">供应商列表</a>
            </li>
            <li @if ($_active['_action'] == 'add')  class="active" @endif>
                <a href="/admin/manufactor/add">添加供应商</a>
            </li>
        </ul>
    </header>
    <div class="panel-body">
        <div class="tab-content">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">

                    </section>
                </div>
            </div>

        </div>
    </div>

</section>
<!--tab nav start-->



@include('admin.common.footer')