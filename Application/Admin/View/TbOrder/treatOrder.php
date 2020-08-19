<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="__ADMIN_CSS__/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
<link href="__ADMIN_CSS__/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
<link href="__ADMIN_CSS__/plugins/iCheck/custom.css" rel="stylesheet">
<link href="__ADMIN_CSS__/animate.min.css" rel="stylesheet">
<link href="__ADMIN_CSS__/style.min862f.css?v=4.1.0" rel="stylesheet">
<script src="__ADMIN_JS__/jquery.min.js?v=2.1.4"></script>
<script src="__ADMIN_JS__/plugins/iCheck/icheck.min.js"></script>
<script src="__ADMIN_JS__/plugins/layer/laydate/laydate.js"></script>
<script>
$(document).ready(function(){$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})});
</script>
</head>

<body class="gray-bg">
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h3>当前位置：淘宝管理系统 &raquo; 淘宝订单管理 &raquo; 处理遗漏淘宝订单</h3>
					</div>
				</div>
			</div>
			<div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                    <h3><strong style="color:red;">1、订单时间格式：年-月-日 时:分:秒，如2018-10-28 14:20:00</strong></h3>
                    <h3><strong style="color:red;">2、查询的订单是当前时间往后推20分钟，查询20分钟内的所有订单，比如下单时间为2018-10-28 14:24:20，则“订单开始时间”填写2018-10-28 14:20:00</strong></h3>
                    <h3><strong style="color:red;">3、常规订单代表用户自身购买订单，渠道订单代表用户分享让他人购买订单</strong></h3>
                        <form action="__ACTION__"  class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">淘宝订单状态</label>
                                <div>
                                    <div class="radio i-checks">
                                        <label>
                                        	<input type="radio" name="tk_status" value="" checked> <i></i>全部
                                        	<input type="radio" name="tk_status" value="12" > <i></i>付款
                                        	<input type="radio" name="tk_status" value="13" > <i></i>关闭
                                        	<input type="radio" name="tk_status" value="14" > <i></i>确认收货
                                        	<input type="radio" name="tk_status" value="3" > <i></i>结算成功
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">订单类型</label>
                                <div>
                                    <div class="radio i-checks">
                                        <label>
                                        	<input type="radio" name="order_scene" value="1" checked> <i></i>常规订单
                                        	<input type="radio" name="order_scene" value="2" > <i></i>渠道订单
                                        	<input type="radio" name="order_scene" value="3" > <i></i>会员订单（目前不用）
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">查询时间类型</label>
                                <div>
                                    <div class="radio i-checks">
                                        <label>
                                        	<input type="radio" name="query_type" value="1" > <i></i>创建时间
                                        	<input type="radio" name="query_type" value="2" checked> <i></i>付款时间
                                        	<input type="radio" name="query_type" value="3" > <i></i>结算时间
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">订单查询开始时间</label>
                                <div class="col-sm-10">
                                    <input class="form-control layer-date" name="time" placeholder="" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">推广者角色类型</label>
                                <div>
                                    <div class="radio i-checks">
                                        <label>
                                        	<input type="radio" name="member_type" value="" checked> <i></i>所有角色
                                        	<input type="radio" name="member_type" value="2"> <i></i>二方
                                        	<input type="radio" name="member_type" value="3" > <i></i>三方
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>&nbsp;批量处理</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
		</div>
	</div>
</body>
</html>