<section class="rt_wrap content">
 <div class="rt_content">
     <section>
      <h2><strong style="color:grey;">当前位置：内容管理 &raquo; 编辑友情链接分类</strong><a class="back" href="__CONTROLLER__/index">返回友情链接管理 &raquo;</a></h2>
      <form action="__ACTION__/id/{$msg['id']}" method="post">
      <ul class="ulColumn2">
       <li>
        <span class="item_name" style="width:120px;">分类名称：</span>
        <input type="text" class="textbox textbox_295" name="title" value="{$msg['title']}" placeholder=""/>
       </li>
       <li>
        <span class="item_name" style="width:120px;">排序：</span>
        <input type="text" class="textbox textbox_295" name="sort" value="{$msg['sort']}" placeholder="" style="width:92px;"/>
        <span class="errorTips">数字越大越排在前</span>
       </li>
       <li>
        <span class="item_name" style="width:120px;"></span>
        <input type="submit" class="link_btn" value="编辑分类"/>
        <input type="reset" class="link_btn" value="重置"/>
       </li>
      </ul>
      </form>
     </section>
     <!--tabStyle-->
 </div>
</section>
