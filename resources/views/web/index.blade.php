@include('web.common.header')
<header>
    <button id="nav-button"><i class="iconfont icon-category" aria-hidden="true"></i></button>
    <a href="/user/address" id='title'>
        配送至: 绿地中央广场2222
        <i class="iconfont icon-xiaosanjiaodown" ></i>
    </a>
</header>
<div id="nav">
    <ul>
        <li><a href='#'>特价水果</a></li>
        <li><a href='#'>当季水果</a></li>
        <li><a href='#'>进口水果</a></li>
        <li><a href='#'>美味坚果</a></li>
        <li><a href='#'>特色零食</a></li>
    </ul>
</div>
<div id="content">
    <ul class="list">

    </ul>
    <input type="hidden" value="1" id="page"/>
</div>

<script>

    require(['app/index'   , 'common/common'] , function (app , common) {
        app.dropload();
        app.storageGoods();
        common.addCart();
    });
</script>

<script id="goodsList" type="text/template">
    <% for (let i = 0 ; i < data.length ; i++){%>
    <li class="<% if( (len + 1 ) % 2 == 0){ %> ml2 <% } %>">
        <div class="fruit-list">
            <div <% if(data[i].buy_num == 0 ){%> style="display:none" <% } %> class="buy-num buy-num-<%= data[i].id %>"><%=data[i].buy_num%></div>
            <a href="/goods/info/<%= data[i].id %>"><img src="<%= data[i].img.imgUrl %>" alt="<%= data[i].show_title %>" title="<%= data[i].show_title %>"></a>
            <div class="price">￥<%= data[i].now_price %>/<%= data[i].unit %></div>
            <div class="fruit-info">
                <div class="fruit-title"><%= data[i].show_title %></div>
                <div gid=<%= data[i].id %> class="fruit-cart addCart"><i class="iconfont icon-gouwuchetianjia"></i></div>
            </div>
        </div>
    </li>
    <% len++ } %>
</script>

@include('web.common.footer-bottom')
@include('web.common.footer')
