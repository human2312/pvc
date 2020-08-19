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

<body class="gray-bg">
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h3>当前位置：系统设置 &raquo; 费用规则设置</h3>
					</div>
				</div>
			</div>
			<div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form action="__ACTION__"  class="form-horizontal" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="old_referrer_rate" value="{$msg['referrer_rate']}">
                        <input type="hidden" name="old_referrer_rate2" value="{$msg['referrer_rate2']}">
                        <input type="hidden" name="old_upgrade_fee_month" value="{$msg['upgrade_fee_month']}">
                        <input type="hidden" name="old_upgrade_fee_year" value="{$msg['upgrade_fee_year']}">
                        <input type="hidden" name="old_upgrade_fee_forever" value="{$msg['upgrade_fee_forever']}">
                        <input type="hidden" name="old_platform_wx" value="{$msg['platform_wx']}">
                        <input type="hidden" name="old_share_url" value="{$msg['share_url']}">
                        <input type="hidden" name="old_share_url_register" value="{$msg['share_url_register']}">
                        <input type="hidden" name="old_share_url_vip" value="{$msg['share_url_vip']}">
      
                            <div class="form-group">
                                <label class="col-sm-2 control-label">直接推荐返利比例</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="referrer_rate" value="{$msg['referrer_rate']}" placeholder="">
                                    <span class="help-block m-b-none text-danger">%，百分比</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">间接推荐返利比例</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="referrer_rate2" value="{$msg['referrer_rate2']}" placeholder="">
                                    <span class="help-block m-b-none text-danger">%，百分比</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">会员升级费用-1个月</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="upgrade_fee_month" value="{$msg['upgrade_fee_month']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">会员升级费用-1年</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="upgrade_fee_year" value="{$msg['upgrade_fee_year']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">会员升级费用-终生</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="upgrade_fee_forever" value="{$msg['upgrade_fee_forever']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">平台微信号</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="platform_wx" value="{$msg['platform_wx']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">分享淘宝商品网址</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="share_url" value="{$msg['share_url']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">分享注册下载网址</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="share_url_register" value="{$msg['share_url_register']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">VIP专用分享网址</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="share_url_vip" value="{$msg['share_url_vip']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>&nbsp;编辑</button>
                                    <button class="btn btn-white" type="reset"><i class="fa fa-refresh"></i>&nbsp;重置</button>
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