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
						<h3>当前位置：营销中心 &raquo; 编辑淘宝商品<a class="pull-right" href="__CONTROLLER__/index">返回上一页 <i class="fa fa-angle-double-right"></i></a></h3>
					</div>
				</div>
			</div>
			<div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form action="__ACTION__/id/{$msg['id']}"  class="form-horizontal" method="post" enctype="multipart/form-data">
                            <!-- <div class="form-group">
                                <label class="col-sm-2 control-label">展示类型</label>
                                <div>
                                    <div class="radio i-checks">
                                        <label>
                                        	<input type="radio" name="type" value="1" checked> <i></i>推荐
                                        	<input type="radio" name="type" value="2" > <i></i>排行榜
                                        	<input type="radio" name="type" value="3" > <i></i>限时抢购
                                        </label>
                                    </div>
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品ID</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="goods_id" value="{$msg.goods_id}" placeholder="" >
                                    <span class="help-block m-b-none text-danger">请确保填写的商品为淘宝客活动商品，并且有优惠券</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品名称</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="goods_name" value="{$msg.goods_name}" placeholder="" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">排序</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="sort" value="{$msg.sort}" placeholder="" >
                                    <span class="help-block m-b-none text-danger">数字越大越排在前</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">佣金比率</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="" value="{$msg.commission_rate}%" placeholder="" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">优惠券金额</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="" value="{$msg.coupon_amount}元" placeholder="" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">销量</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="" value="{$msg.volume}" placeholder="" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">卖点信息</label>
                                <div class="col-sm-10">
                                    <textarea name="description" placeholder="" class="form-control" style="height:100px;">{$msg['description']}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>&nbsp;编辑</button>
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