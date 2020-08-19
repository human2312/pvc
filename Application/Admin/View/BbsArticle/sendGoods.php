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
						<h3>当前位置：营销中心 &raquo; 爆款商品推送</h3>
					</div>
				</div>
			</div>
			<div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                    <h3><strong style="color:red;">1、请确保所填写的商品ID正确</strong></h3>
                        <form action="__ACTION__"  class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品类型</label>
                                <div>
                                    <div class="radio i-checks">
                                        <label>
                                        	<input type="radio" name="type" value="1" checked> <i></i>淘宝
                                        	<input type="radio" name="type" value="2" > <i></i>京东
                                        	<input type="radio" name="type" value="3" > <i></i>拼多多
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品ID</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="goods_id" placeholder="" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">自定义标题</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="title" placeholder="" >
                                    <span class="help-block m-b-none text-danger">如果不填写自定义标题，则用"爆款商品推荐！"</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">自定义内容</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="content" placeholder="" >
                                    <span class="help-block m-b-none text-danger">如果不填写自定义内容，则用商品原标题</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>&nbsp;确认推送</button>
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