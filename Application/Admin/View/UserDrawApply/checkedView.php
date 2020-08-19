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
						<h3>当前位置：资金管理 &raquo; 查看用户提现申请<a class="pull-right" href="__CONTROLLER__/checked">返回已审核用户提现申请<i class="fa fa-angle-double-right"></i></a></h3>
					</div>
				</div>
			</div>
			<div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content" style="overflow:hidden">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">申请用户</label>
                                <div class="col-sm-10">
                                    <input class="form-control" placeholder="" value="{$msg.phone}" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">提现金额</label>
                                <div class="col-sm-10">
                                    <input class="form-control" placeholder="" value="￥{$msg.money}" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">银行</label>
                                <div class="col-sm-10">
                                    <input class="form-control" placeholder="" value="{$msg.account_type_zh}" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">卡号</label>
                                <div class="col-sm-10">
                                    <input class="form-control" placeholder="" value="{$msg.account}" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">收款方真实姓名</label>
                                <div class="col-sm-10">
                                    <input class="form-control" placeholder="" value="{$msg.truename}" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">审核结果</label>
                                <div class="col-sm-10">
                                <?php 
                                //审核结果
                                if($msg['check_result']=='Y') {
                                    $check_result='审核通过';
                                }else {
                                    $check_result='审核不通过';
                                }
                                ?>
                                    <input class="form-control" placeholder="" value="{$check_result}" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">审核时间</label>
                                <div class="col-sm-10">
                                    <input class="form-control" placeholder="" value="{$msg.check_time}" disabled>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
		</div>
	</div>
</body>
</html>