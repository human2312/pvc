<nav class="navbar-default navbar-static-side" role="navigation">
	<div class="nav-close">
		<i class="fa fa-times-circle"></i>
	</div>
	<div class="sidebar-collapse">
		<ul class="nav" id="side-menu">
			<li class="nav-header" style="text-align: center">
				<div class="dropdown profile-element">
					<span><img alt="image" class="img-circle" src="__ADMIN_IMG__/logo.png" width="72"/></span> 
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"> 
					<span class="clear"> 
					<span class="block m-t-xs"><strong class="font-bold"><?php echo WEB_TITLE;?></strong></span>
					</span>
					</a>
				</div>
				<div class="logo-element">后台</div>
			</li>
			<li>
				<a href="__MODULE__/System/index"> 
					<i class="fa fa-home"></i> <span class="nav-label">主页</span>
				</a>
			</li>

            <li>
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span class="nav-label">会员管理</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li><a class="J_menuItem" href="__MODULE__/User/index">会员列表</a></li>
                    <li><a class="J_menuItem" href="__MODULE__/ConsigneeAddress/index">收货地址管理</a></li>
                    <li><a class="J_menuItem" href="__MODULE__/User/everyday">每日注册会员统计</a></li>
                </ul>
            </li>

            <li>
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span class="nav-label">订单管理</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li><a class="J_menuItem" href="__MODULE__/Daishou/doneorder">订单列表</a></li>
                </ul>
            </li>


            <li>
                <a href="#">
                    <i class="fa fa-file-text"></i>
                    <span class="nav-label">内容管理</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li><a class="J_menuItem" href="__MODULE__/BannerCat/index">Banner/公告管理</a></li>
                </ul>
            </li>


            <li>
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span class="nav-label">财务管理</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li><a class="J_menuItem" href="__MODULE__/Daishou/useraccount">用户账户</a></li>
                    <li><a class="J_menuItem" href="__MODULE__/Daishou/recharge">充值审核</a></li>
                    <li><a class="J_menuItem" href="__MODULE__/Daishou/useraccountlog">用户流水</a></li>
                </ul>
            </li>

            <li>
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span class="nav-label">活动管理</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li><a class="J_menuItem" href="__MODULE__/Daishou/activity">活动列表</a></li>
                </ul>
            </li>


			<li>
				<a href="#"> 
					<i class="fa fa-gear"></i> 
					<span class="nav-label">系统设置</span> 
					<span class="fa arrow"></span>
				</a>
				<ul class="nav nav-second-level">
             <!---       <li><a class="J_menuItem" href="__MODULE__/System/daishou">代收设置</a></li> --->
					<li><a class="J_menuItem" href="__MODULE__/System/webset">站点设置</a></li>
					<li><a class="J_menuItem" href="__MODULE__/System/sensitive">敏感词过滤</a></li>
				</ul>
			</li>
			<li>
				<a href="#"> 
					<i class="fa fa-user-plus"></i> 
					<span class="nav-label">管理员管理</span> 
					<span class="fa arrow"></span>
				</a>
				<ul class="nav nav-second-level">
					<li><a class="J_menuItem" href="__MODULE__/Admin/index">管理员列表</a></li>
					<li><a class="J_menuItem" href="__MODULE__/AdminGroup/index">组别管理</a></li>
					<li><a class="J_menuItem" href="__MODULE__/AuthRule/index">权限管理</a></li>
					<li><a class="J_menuItem" href="__MODULE__/Admin/changepwd">修改密码</a></li>
				</ul>
			</li>
		</ul>
	</div>
</nav>