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

<!-- Sweet Alert -->
<link href="__ADMIN_CSS__/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<!-- Sweet Alert -->
<script src="__ADMIN_JS__/jquery.min.js?v=2.1.4"></script>
<script src="__ADMIN_JS__/bootstrap.min.js?v=3.3.6"></script>
<script src="__ADMIN_JS__/content.min.js?v=1.0.0"></script>
<script src="__ADMIN_JS__/plugins/sweetalert/sweetalert.min.js"></script>
<script>
function changeIndexShow(id,status)
{
	if(id!='')
	{
		$.ajax({
			type:"POST",
			url:'/dmooo.php/DiyModule/changeIndexShow',
			dataType:"html",
			data:"id="+id+"&status="+status,
			success:function(msg)
			{
				if(msg=='1')
				{
					swal({
						title:"修改状态成功！",
						text:"",
						type:"success"
					},function(){location.reload();})
				}else {
					swal({
						title:"修改状态失败！",
						text:"",
						type:"error"
					},function(){location.reload();})
				}
			}
		});
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
						<h3>当前位置：样式DIY设置 &raquo; 功能模块管理</h3>
					</div>
					<div class="ibox-content">
						<div class="row">
							<a class="btn btn-primary pull-right" href="__CONTROLLER__/add" style="margin-left: 10px">添加功能模块</a>
       						<a class="btn btn-primary pull-right" href="__CONTROLLER__/set"><i class="fa fa-check"></i>&nbsp;更新设置功能模块</a>
       					</div>
						<div class="table-responsive">
							<form action="__CONTROLLER__/changesort" method="post">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>ID</th>
										<th>功能模块类型</th>
										<th>功能模块名称</th>
										<th>功能模块图标</th>
										<th>首页是否显示</th>
										<th>排序</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody>
									<foreach name="list" item="l">
									<tr>
										<td>{$l['id']}</td>
										<td>{$l['type']}</td>
										<td>{$l['name']}</td>
										<td><img src="{$l.icon}" height="30px"></td>
										<td>
											<if condition='$l[is_index_show] eq Y'> 
												<button type="button" class="btn btn-primary btn-sm" onclick="changeIndexShow({$l.id},'N');">正常显示</button>
											<else /> 
												<button type="button" class="btn btn-danger btn-sm" onclick="changeIndexShow({$l.id},'Y');">&nbsp;不显示&nbsp;&nbsp;</button>
											</if>
										</td>
										<td class="has-warning"><input name="sort[{$l.id}]" value="{$l.sort}" class="form-control" style="width:50px;text-align:center"/></td>
										<td>
											<a href="__CONTROLLER__/edit/id/{$l.id}" title="修改"> 
												<i class="fa fa-file-text-o text-danger" style="font-size:2.0rem"></i>&nbsp;
											</a>
										</td>
									</tr>
									</foreach>
								</tbody>
								<tr>
									<td colspan="7" align="left" style="text-align:left">
	        							<input type="submit" class="btn btn-primary pull-right" value="统一排序">
		  							</td>
	   							</tr>
							</table>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
