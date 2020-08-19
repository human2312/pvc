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
<script src="__ADMIN_JS__/plugins/iCheck/icheck.min.js"></script>

<!-- Sweet Alert -->
<link href="__ADMIN_CSS__/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<script src="__ADMIN_JS__/plugins/sweetalert/sweetalert.min.js"></script>
<!-- Sweet Alert -->

<script>
$(document).ready(function(){
	
	$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})
});
</script>
</head>

<body class="gray-bg">
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h3>当前位置：订单管理 &raquo; 查看已评价/已结束订单<a class="pull-right" href="__CONTROLLER__/comment">返回已评价/已结束订单 <i class="fa fa-angle-double-right"></i></a></h3>
					</div>
				</div>
			</div>
			<div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                    <ul class="nav nav-tabs">
                        <li class="active">
                        	<a data-toggle="tab" href="#tab-1" aria-expanded="true">订单基本信息</a>
                        </li>
                        <li class="">
                        	<a data-toggle="tab" href="#tab-2" aria-expanded="false">订单明细</a>
                        </li>
                    </ul>
                    <form action="__ACTION__/id/{$msg.id}"  class="form-horizontal" method="post" enctype="multipart/form-data">
      				<div class="tab-content">
      					<!-- 订单基本信息  -->
      					<div id="tab-1" class="tab-pane active" style="padding-top: 10px">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">订单名称</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" value="{$msg['title']}" placeholder="">
                                    <span class="help-block m-b-none text-danger">必填</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">总价</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="allprice" value="{$msg['allprice']}">
                                    <span class="help-block m-b-none text-danger">必填</span> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">收件人</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="consignee" value="{$msg['consignee']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">联系电话</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="contact_number" value="{$msg['contact_number']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">收货地址</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="address" value="{$msg['address']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">邮政编码</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="postcode" value="{$msg['postcode']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">单位名称</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="company" value="{$msg['company']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">快递公司</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="logistics">
                                    	<option value="" >-请选择快递公司-</option>
                                           <?php 
                                           $logistics_arr=json_decode(logistics,true);
                                           foreach ($logistics_arr as $k=>$v) {
                                               if($k==$msg['logistics']) {
                                                   $select='selected';
                                               }else {
                                                   $select='';
                                               }
                                               echo '<option value="'.$k.'" '.$select.'>'.$v.'</option>';
                                           }
                                           ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">快递单号</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="express_number" value="{$msg['express_number']}" placeholder="">
                                    <span class="help-block m-b-none text-danger">请填写快递单号便于会员查看物流</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">订单状态</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="" value="已评价、已完成" placeholder="" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">支付方式</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="pay_method">
                                    	   <option value="">-请选择支付方式-</option>
                                           <option value="alipay" <?php if($msg['pay_method']=='alipay'){echo 'selected';}?> >支付宝支付</option>
                                           <option value="wxpay" <?php if($msg['pay_method']=='wxpay'){echo 'selected';}?> >微信支付</option>
                                           <option value="balance" <?php if($msg['pay_method']=='balance'){echo 'selected';}?> >余额支付</option>
                                           <option value="offline" <?php if($msg['pay_method']=='offline'){echo 'selected';}?> >线下支付</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">下单时间</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="" value="{$msg.create_time}" disabled> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">支付时间</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="" value="{$msg.pay_time}" disabled> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">发货时间</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="" value="{$msg.deliver_time}" disabled> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">确认收货时间</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="" value="{$msg.finish_time}" disabled> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">评价时间</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="" value="{$msg.comment_time}" disabled> 
                                </div>
                            </div>
                        </div>
                        <!-- 订单基本信息  -->
                        
                        <!-- 订单明细  -->
                        <div id="tab-2" class="tab-pane" style="padding-top: 10px">
                            <?php 
                               foreach ($msg['detail'] as $l)
                               {
                               	 //单价
                               	 $price=$l['price'];
                               	 //总价
                               	 $allprice=$l['allprice'];
                               	 $goods_str=$l['goods_name'].'，单价：￥'.$price.'，数量：'.$l['num'].'，总价：￥'.$allprice.'，备注：'.$l['sku'];
                               	 echo '<div class="form-group">
                                <label class="col-sm-2 control-label">商品名称：</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" name="keywords" value="'.$goods_str.'" disabled>  
                               </div>
                                </div>';
                               }
                               ?>
                        </div>
                        <!-- 订单明细  -->
                        
                        <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>&nbsp;编辑订单</button>
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