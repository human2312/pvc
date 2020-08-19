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
						<h3>当前位置：系统设置 &raquo; 应用账号配置</h3>
					</div>
				</div>
			</div>
			<div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                    <h3><strong style="color:red;">友情提示：该页面账号配置参数由专业技术人员配置，请勿随意修改！请妥善保管，请勿泄露！</strong></h3>
                    <ul class="nav nav-tabs">
                        <li class="active">
                        	<a data-toggle="tab" href="#tab-1" aria-expanded="true">淘宝客账号</a>
                        </li>
                        <li class="">
                        	<a data-toggle="tab" href="#tab-2" aria-expanded="false">拼多多账号</a>
                        </li>
                        <li class="">
                        	<a data-toggle="tab" href="#tab-3" aria-expanded="false">极光推送账号</a>
                        </li>
                        <li class="">
                        	<a data-toggle="tab" href="#tab-4" aria-expanded="false">支付宝账号</a>
                        </li>
                    </ul>
                    <form action="__ACTION__"  class="form-horizontal" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="old_tbk_appid" value="{$msg['tbk_appid']}">
      					<input type="hidden" name="old_tbk_appkey" value="{$msg['tbk_appkey']}">
      					<input type="hidden" name="old_tbk_appsecret" value="{$msg['tbk_appsecret']}">
      					<input type="hidden" name="old_tbk_pid" value="{$msg['tbk_pid']}">
      					<input type="hidden" name="old_tbk_adzone_id" value="{$msg['tbk_adzone_id']}">
      					<input type="hidden" name="old_tbk_relation_pid" value="{$msg['tbk_relation_pid']}">
      					<input type="hidden" name="old_wy_appkey" value="{$msg['wy_appkey']}">
      
      					<input type="hidden" name="old_pdd_client_id" value="{$msg['pdd_client_id']}">
      					<input type="hidden" name="old_pdd_client_secret" value="{$msg['pdd_client_secret']}">
      					<input type="hidden" name="old_pdd_pid" value="{$msg['pdd_pid']}">
      
      					<input type="hidden" name="old_jpush_key" value="{$msg['jpush_key']}">
      					<input type="hidden" name="old_jpush_secret" value="{$msg['jpush_secret']}">
      
      					<input type="hidden" name="old_alipay_appid" value="{$msg['alipay_appid']}">
      					<input type="hidden" name="old_alipay_private_key" value="{$msg['alipay_private_key']}">
      					<input type="hidden" name="old_alipay_public_key" value="{$msg['alipay_public_key']}">
      				<div class="tab-content">
      					<!-- 淘宝客账号   -->
      					<div id="tab-1" class="tab-pane active" style="padding-top: 10px">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">淘宝客AppID</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="tbk_appid" value="{$msg['tbk_appid']}" placeholder="">
                                    <span class="help-block m-b-none text-danger">请填写淘宝客AppID</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">淘宝客App key</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="tbk_appkey" value="{$msg['tbk_appkey']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">淘宝客App secret</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="tbk_appsecret" value="{$msg['tbk_appsecret']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">淘宝客PID</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="tbk_pid" value="{$msg['tbk_pid']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">淘宝客广告位ID</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="tbk_adzone_id" value="{$msg['tbk_adzone_id']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">淘宝客渠道专用PID</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="tbk_relation_pid" value="{$msg['tbk_relation_pid']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">维易淘宝客key</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="wy_appkey" value="{$msg['wy_appkey']}" placeholder="">
                                </div>
                            </div>
                        </div>
                        <!-- 淘宝客账号   -->
                        
                        <!-- 拼多多账号  -->
                        <div id="tab-2" class="tab-pane" style="padding-top: 10px">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">拼多多client_id</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="pdd_client_id" value="{$msg['pdd_client_id']}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">拼多多client_secret</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="pdd_client_secret" value="{$msg['pdd_client_secret']}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">拼多多推广位pid</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="pdd_pid" value="{$msg['pdd_pid']}"> 
                                </div>
                            </div>
                        </div>
                        <!-- 拼多多账号  -->
                        
                        <!-- 极光推送账号  -->
                        <div id="tab-3" class="tab-pane" style="padding-top: 10px">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">极光推送key</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="jpush_key" value="{$msg['jpush_key']}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">极光推送secret</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="jpush_secret" value="{$msg['jpush_secret']}"> 
                                </div>
                            </div>
                        </div>
                        <!-- 极光推送账号  -->
                        
                        <!-- 支付宝账号  -->
                        <div id="tab-4" class="tab-pane" style="padding-top: 10px">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">支付宝appid</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="alipay_appid" value="{$msg['alipay_appid']}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">支付宝私钥</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="alipay_private_key" value="{$msg['alipay_private_key']}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">支付宝公钥</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="alipay_public_key" value="{$msg['alipay_public_key']}"> 
                                </div>
                            </div>
                        </div>
                        <!-- 支付宝账号  -->
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