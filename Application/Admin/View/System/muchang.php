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
<script src="__ADMIN_JS__/bootstrap.min.js?v=3.3.6"></script>
</head>

<body class="gray-bg">
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h3>当前位置：系统设置 &raquo;  牧场设置</h3>
					</div>
				</div>
			</div>
			<div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                    <ul class="nav nav-tabs">
                        <li class="active">
                        	<a data-toggle="tab" href="#tab-1" aria-expanded="true">配置</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#tab-2" aria-expanded="false">转转配置</a>
                        </li>
                    </ul>
                    <form action="__ACTION__"  class="form-horizontal" method="post" enctype="multipart/form-data">
      				<div class="tab-content">
      					<!-- APP配置  -->
      					<div id="tab-1" class="tab-pane active" style="padding-top: 10px">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">牧场公告</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="gonggao" value="{$msg['gonggao']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">首次注册登录系统赠送</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="shousong" value="{$msg['shousong']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">偷蛋比例(10分之几)</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="toudan" value="{$msg['toudan']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">鸵鸟产蛋周期</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="zhouqi" value="{$msg['zhouqi']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">直推一个牧主赠送口粮</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="zhitui" value="{$msg['zhitui']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">团队推广一个牧主赠送口粮</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="tuandui" value="{$msg['tuandui']}" placeholder="">
                                </div>
                            </div>
                        </div>
                        <!-- APP配置  -->
                        <div id="tab-2" class="tab-pane" style="padding-top: 10px">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">一星达人赠送口粮数</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="kouliang1" value="{$msg['kouliang1']}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">二星达人赠送口粮数</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="kouliang2" value="{$msg['kouliang2']}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">三星达人赠送口粮数</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="kouliang3" value="{$msg['kouliang3']}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">牧场金主赠送口粮数</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="kouliang4" value="{$msg['kouliang4']}">
                                </div>
                            </div>

                        </div>


                        <div class="form-group">
                             <div class="col-sm-4 col-sm-offset-2">
                                 <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>&nbsp;编辑</button>
                                 <button class="btn btn-white" type="reset"><i class="fa fa-refresh"></i>&nbsp;重置</button>
                             </div>
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