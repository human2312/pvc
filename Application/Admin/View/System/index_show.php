<link rel="stylesheet" type="text/css" href="__ADMIN_CSS__/index.css">
<link href="__ADMIN_CSS__/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="__ADMIN_JS__/html5shiv.min.js"></script>
    <script src="__ADMIN_JS__/respond.min.js"></script>
    <![endif]-->

<section class="rt_wrap content">

	<div class="container-fluid">
		<!--主体内容开始-->
		<div class="c_totalmember">
			<div class="c_lan1">
				<h3>会员数据统计</h3>
			</div>
			<div class="c_totalmemberbox">
				<a class="c_totalmember_item c_xianright">
					<dl>
						<dt>
							<img src="__ADMIN_IMG__/c_icon1.png">
						</dt>
						<dd>
							<p>会员数量</p>
							<span>{$user_allnum}<small>人</small></span>
						</dd>
					</dl>
				</a> <a class="c_totalmember_item c_xianright">
					<dl>
						<dt>
							<img src="__ADMIN_IMG__/c_icon2.png">
						</dt>
						<dd>
							<p>普通会员</p>
							<span>{$user_num1}<small>人</small></span>
						</dd>
					</dl>
				</a> <a class="c_totalmember_item c_xianright">
					<dl>
						<dt>
							<img src="__ADMIN_IMG__/c_icon3.png">
						</dt>
						<dd>
							<p>VIP会员</p>
							<span>{$user_vipnum}<small>人</small></span>
						</dd>
					</dl>
				</a> <a class="c_totalmember_item c_xianright">
					<dl>
						<dt>
							<img src="__ADMIN_IMG__/c_icon4.png">
						</dt>
						<dd>
							<p>今日新增</p>
							<span>{$user_today_num}<small>人</small></span>
						</dd>
					</dl>
				</a> <a class="c_totalmember_item c_xianright">
					<dl>
						<dt>
							<img src="__ADMIN_IMG__/c_icon5.png">
						</dt>
						<dd>
							<p>本月新增</p>
							<span>{$user_month_num}<small>人</small></span>
						</dd>
					</dl>
				</a>
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>

		<div class="clear"></div>
		<!--主体内容结束-->
	</div>

</section>
