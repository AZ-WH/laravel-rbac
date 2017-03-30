@include('web.common.header')
    <header>
        <div id='title'>永州冰糖橙详情</div>
    </header>
    <div id="content">
         <div class="fruit-list">
          <a href="#" style="height: 100%"><img src="{{ URL::asset('/') }}web/imgs/chengzi.jpg" alt="" class=""></a>
          <div class="price">￥29.8/件(2.5KG)</div>
          <div class="fruit-info">
            <div class="fruit-title">永州冰糖橙</div>
            <button class="fruit-cart"><i class="fa fa-cart-plus" aria-hidden="true"></i></button>
          </div>
        </div>
    </div>
@include('web.common.footer-bottom')
@include('web.common.footer')