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

function deladmin(id)
{
	if(id!='') {
		swal({
			title:"确定要删除？",
			text:"",
			type:"warning",
			showCancelButton:true,
			cancelButtonText:"取消",
			confirmButtonColor:"#DD6B55",
			confirmButtonText:"删除",
			closeOnConfirm:false
		},function(){
			$.ajax({
				type:"POST",
				url: "/dmooo.php/JFLottery/del",
				dataType:"html",
				data:"id="+id,
				success:function(msg)
				{
				    if(msg=='1')
					{
						swal({
							title:"删除成功！",
							text:"",
							type:"success"
						},function(){location.reload();})
					}else {
						swal({
							title:"操作失败！",
							text:"",
							type:"error"
						},function(){location.reload();})
					}
				}
			});
		})
	}
}
</script>
</head>

<body class="gray-bg">
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h3>当前位置： 营销中心  &raquo; 积分抽奖管理</h3>
					</div>
					<div class="ibox-content">
						<a class="btn btn-primary pull-right" href="__CONTROLLER__/add">添加抽奖活动</a>
						<div class="ibox">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>ID</th>
										<th>抽奖商品</th>
										<th>商品图片</th>
                                        <th>最大人数</th>
										<th>消耗积分</th>
										<th>中奖号码</th>
										<th>补偿积分</th>
										<th>投注时间</th>
                                        <th>开奖时间</th>
                                        <th>记录</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody>
									<foreach name="data" item="value">
									<tr>
										<td>{$value.id}</td>
                                        <td>{$value.name}</td>
										<td>
                                            <?php
                                            if($value['goodsimg']) {
                                                echo '<img src="'.$value['goodsimg'].'" height="50px">';
                                            }
                                            ?>
                                        </td>
                                        <td>{$value.maxnum}</td>
                                        <td>{$value.needjf}</td>
										<td>{$value.num}</td>
                                        <td>{$value.backjf}</td>
										<td>{$value.start_time} 至 {$value.end_time}</td>
										<td>{$value.open_time} </td>
										<td><a href="/dmooo.php/JFLotteryRecord/index?id={$value.id}">中奖记录</a></td>
										<td>
											<a href="__CONTROLLER__/edit?id={$value.id}" title="修改">
												<i class="fa fa-file-text-o text-danger" style="font-size:2.0rem"></i>&nbsp;
											</a>
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