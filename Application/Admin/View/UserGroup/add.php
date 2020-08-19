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
						<h3>当前位置：会员管理 &raquo; 会员组管理 &raquo; 新增会员组<a class="pull-right" href="__CONTROLLER__/index">返回上一页 <i class="fa fa-angle-double-right"></i></a></h3>
					</div>
				</div>
			</div>
			<div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form action="__ACTION__"  class="form-horizontal" method="post" enctype="multipart/form-data">
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label">会员组名</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="title" placeholder="" >
                                    <span class="help-block m-b-none text-danger">{$error1}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">等级必要经验</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="exp" placeholder="" >
                                    <span class="help-block m-b-none text-danger">从下一级会员组升级为本级会员组所需的最低经验，请填写正整数</span>
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label class="col-sm-2 control-label">享受的折扣率</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="discount" placeholder="" >
                                    <span class="help-block m-b-none text-danger">商品原价基础上打折，如：0.95代表95折</span>
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">是否冻结</label>
                                <div>
                                    <div class="radio i-checks">
                                        <label>
                                        	<input type="radio" name="is_freeze" value="N" checked> <i></i>正常使用
                                        	<input type="radio" name="is_freeze" value="Y" > <i></i>冻结
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">组别描述</label>
                                <div class="col-sm-10">
                                    <textarea name="introduce" placeholder="" class="form-control" style="height:100px;"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">收益比例-用户</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="fee_user" value="60" placeholder="" >
                                    <span class="help-block m-b-none text-danger">请填写整数，60代表60%</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">收益比例-扣税</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="fee_service" value="10" placeholder="" >
                                    <span class="help-block m-b-none text-danger">请填写整数，10代表10%</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">收益比例-平台</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="fee_plantform" value="30" placeholder="" >
                                    <span class="help-block m-b-none text-danger">请填写整数，30代表30%</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>&nbsp;添加会员组</button>
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