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
</head>

<body class="gray-bg">
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h3>当前位置：淘宝管理系统 &raquo; 淘宝订单管理 &raquo; 处理维权订单<a class="pull-right" href="__CONTROLLER__/index">返回订单列表 <i class="fa fa-angle-double-right"></i></a></h3>
					</div>
				</div>
			</div>
			<div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                    <h3><strong style="color:red;">1、请确保订单是已结算，并且用户在淘宝中进行了维权退款操作</strong></h3>
                    <h3><strong style="color:red;">2、维权退款可能只退还了部分金额，相应的佣金是根据退款金额成比例扣除的</strong></h3>
                        <form action="__ACTION__/id/{$msg.id}"  class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品名称</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" disabled value="{$msg.item_title}" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">实付金额</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" disabled value="{$msg.pay_price}" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">佣金比率</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" disabled value="<?php echo $msg['total_commission_rate']*100;?>%" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">淘宝总佣金</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" disabled value="<?php echo $msg['pay_price']*$msg['total_commission_rate'];?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">订单退款金额</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="refund_money" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>&nbsp;处理</button>
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