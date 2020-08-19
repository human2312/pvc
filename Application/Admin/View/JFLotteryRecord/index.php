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

</head>

<body class="gray-bg">
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
                                <h3>当前位置：营销中心 &raquo; 积分抽奖管理<a class="pull-right" href="/dmooo.php/JFLottery/index">返回上一页 <i class="fa fa-angle-double-right"></i></a></h3>
                    </div>
					<div class="ibox-content">
						<div class="ibox">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>ID</th>
										<th>抽奖商品</th>
										<th>用户</th>
										<th>操作时间</th>
										<th>选中号码</th>
										<th>中奖状态</th>
										<th>发货地址</th>
                                        <th>运单号码</th>
                                        <th>运单公司</th>
                                        <th>运单时间</th>
                                        <th>物流编号</th>
                                        <th>订单状态</th>
                                        <th>发货操作</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody>
									<foreach name="data" item="value">
									<tr>
										<td>{$value.id}</td>
                                        <td>{$ldata.name}</td>
										<td>{$value.username}</td>
                                        <td>{$value.addtime}</td>
										<td>{$value.dnum}</td>
										<td>
                                            <?php
                                            if($value['status'] == 1){
                                                echo '中奖';
                                            } else if($value['status'] == 0){
                                                echo '用户未开奖';
                                            }else {
                                                echo '没中';
                                            } ?>
                                        </td>
                                        <td>{$value.receiver} / {$value.phone} <br/> {$value.area}{$value.address} </td>
                                        <td>{$value.shipid} </td>
                                        <td>{$value.shipname} </td>
                                        <td>{$value.shiptime} </td>
                                        <td>{$value.express} </td>
                                        <td>
                                            <?php
                                            if($value['orderstatus'] == 1){
                                                echo '待发货';
                                            } else if($value['orderstatus'] == 2){
                                                echo '已发货';
                                            }else if($value['orderstatus'] == 3){
                                                echo '已完成';
                                            }else {
                                                echo '无';
                                            } ?>
                                        </td>
										<td><a href="/dmooo.php/JFLotteryRecord/edit?id={$value.id}">填写物流信息</a></td>
										<td>
											<a href="javascript:;" onclick="deladmin({$value.id});" title="删除">
                                				<i class="fa fa-trash-o text-danger" style="font-size:2.0rem"></i>&nbsp;
                                			</a>
                                		</td>
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