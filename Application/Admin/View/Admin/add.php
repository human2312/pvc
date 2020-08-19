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
$(document).ready(function(){
	$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})
});
</script>
<script src="__ADMIN_JS__/adminRegister.js"></script>
<script type="text/javascript" src="__JS__/area.js"></script>
</head>

<body class="gray-bg">
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h3>当前位置：管理员管理 &raquo; 管理员列表 &raquo; 添加管理员<a class="pull-right" href="__CONTROLLER__/index">返回上一页 <i class="fa fa-angle-double-right"></i></a></h3>
					</div>
				</div>
			</div>
			<div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                    <form action=""  class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">登录用户名</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="adminname" id="adminname" placeholder="">
                                    <span class="help-block m-b-none text-danger" id="nameAjax"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">密码</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password" name="password" name="color"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">重复密码</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password2" name="password2"> 
                                    <span class="help-block m-b-none text-danger"  id="pwdAjax">不少于6位</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">EMAIL</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="">
                                    <span class="help-block m-b-none text-danger" id="emailAjax"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">手机号码</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="">
                                    <span class="help-block m-b-none text-danger" id="phoneAjax"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">所属分组</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="group_id" id="group_id">
                                    <option value="">--请选择所属分组--</option>
                                    <?php
                                    foreach($glist as $g) {
                                        echo '<option value="'.$g['id'].'">--'.$g['title'].'--</option>';
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">地区</label>
                                <div class="col-sm-10">
                                    <select name="province" id="province" class="form-control m-b pull-left" style="width:105px"></select>
                                    <select name="city" id="city" class="form-control m-b" style="width:100px"></select>
                                    <script type="text/javascript">var opt0 = ["",""];</script>
                                    <script type="text/javascript">setup()</script>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">是否禁用</label>
                                <div>
                                    <div class="radio i-checks">
                                        <label>
                                        	<input type="radio" name="status" value="1" checked> <i></i>正常
                                        	<input type="radio" name="status" value="0"> <i></i>禁用
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="button" id="sub"><i class="fa fa-check"></i>&nbsp;注册</button>
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