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
<!-- Sweet Alert -->
<link href="__ADMIN_CSS__/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<script src="__ADMIN_JS__/plugins/sweetalert/sweetalert.min.js"></script>
<!-- Sweet Alert -->


<link rel="stylesheet" type="text/css" href="__CSS__/page.css" />

<script type="text/javascript">
$(document).ready(function(){
	$(".i-checks").iCheck({
		checkboxClass:"icheckbox_square-green",
		radioClass:"iradio_square-green",
	});
});
</script>
</head>

<body class="gray-bg">
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h3>当前位置： 拼团  &raquo; 当期订单<a class="pull-right" href="/dmooo.php/Ptuan/goods">返回上一页 <i class="fa fa-angle-double-right"></i></a></h3>
					</div>
					<div class="ibox-content">
						<div class="ibox">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>ID</th>
										<th>买家用户</th>
                                        <th>期数</th>
										<th>商品名称</th>
                                        <th>选中号码</th>
                                        <th>中奖状态</th>
                                        <th>发货地址</th>
                                        <th>运单号码</th>
                                        <th>运单公司</th>
                                        <th>运单时间</th>
                                        <th>物流编号</th>
                                        <th>订单状态</th>
                                        <th>时间</th>
									</tr>
								</thead>
								<tbody>
									<foreach name="data" item="value">
									<tr>
										<td>{$value.id}</td>
										<td>{$value.username}</td>
                                        <td>第{$value.qi}期</td>
                                        <td>{$value.goodsname}</td>
                                        <td>{$value.lucky}</td>
                                        <td>
                                            <?php
                                            if($value['isluckey'] == 0){
                                                echo '还没抽奖';
                                            } else if($value['isluckey'] == 1){
                                                echo '没中奖';
                                            } else if($value['isluckey'] == 2){
                                                echo '已中奖';
                                            } else {
                                              echo "未中奖";
                                            }
                                            ?>
                                        </td>
                                        <td>{$value.receiver} / {$value.phone} <br/> {$value.area}{$value.address} </td>
                                        <td>{$value.shipid} </td>
                                        <td>{$value.shipname} </td>
                                        <td>{$value.shiptime} </td>
                                        <td>{$value.express} </td>
                                        <td>
                                            <?php
                                            if($value['orderstatus'] == 1){
                                                echo '新订单';
                                            } else if($value['orderstatus'] == 2){
                                                echo '已付款';
                                            }else if($value['orderstatus'] == 3){
                                                echo '已中奖';
                                            }else if($value['orderstatus'] == 4){
                                                echo '未中奖';
                                            }else if($value['orderstatus'] == 5){
                                                echo '已付尾款';
                                            }else if($value['orderstatus'] == 6){
                                                echo '退款中';
                                            }else if($value['orderstatus'] == 7){
                                                echo '已发货';
                                            }else if($value['orderstatus'] == 7){
                                                echo '已完成';
                                            }else if($value['orderstatus'] == 7){
                                                echo '退款完成';
                                            }else {
                                                echo '无';
                                            } ?>
                                        </td>
                                        <td>{$value.addtime}</td>
                                	</tr>
                                	</foreach>
								</tbody>
							</table>
							<div class="pages">{$page}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>