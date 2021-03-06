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

<script type="text/javascript">
$(document).ready(function(){
	$(".i-checks").iCheck({
		checkboxClass:"icheckbox_square-green",
		radioClass:"iradio_square-green",
	});
});

function changestatus(id,status)
{
	if(id!='') {
		$.ajax({
			type:"POST",
			url:"changestatus",
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

function delgroup(id)
{
	if(id!='') {
		swal({
			title:"分组下的所有管理员会被一起删除，确定要删除该分组吗？",
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
				url:"delgroup",
				dataType:"html",
				data:"id="+id,
				success:function(msg)
				{
				    if(msg=='1') {
						swal({
							title:"删除成功！",
							text:"",
							type:"success"
						},function(){location.reload();})
					}else {
						swal({
							title:"删除失败！",
							text:"",
							type:"success"
						},function(){location.reload();})
					}
				}
			});
		})
	}
}
</script>
<style>
.topCat{
color:red;font-size:24px;font-weight: bold;
}
.tr_sub{
display:none;
}
</style>
</head>

<body class="gray-bg">
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h3>当前位置： 管理员管理 &raquo; 组别管理</h3>
					</div>
					<div class="ibox-content">
						<div class="row">
							<a class="btn btn-primary pull-right" href="__CONTROLLER__/addgroup">添加管理员组</a>
       					</div>
						<div class="">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>ID</th>
										<th>管理员组名</th>
										<th>组别描述</th>
										<th>状态</th>
										<th>添加时间</th>
										<th>用户数量</th>
										<th>查看用户列表</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$admin=new \Admin\Model\AdminModel();
									?>
									<foreach name="glist" item="g">
									<tr>
										<td>{$g['id']}</td>
										<td>{$g['title']}</td>
										<td>{$g['introduce']}</td>
										<td>
											<if condition='$g[status] eq 1'>
												<button type="button" class="btn btn-primary btn-sm" onclick="changestatus({$g.id},0);">开启</button>
											<else/>
												<button type="button" class="btn btn-danger btn-sm" onclick="changestatus({$g.id},1);">关闭</button>
											</if>
										</td>
										<td>{$g['create_time']}</td>
										<td>
										<?php
										$group_id=$g['id'];
										$unum=$admin->where("group_id=$group_id")->count();
										echo $unum;
										?>
										</td>
										<td><a href="__MODULE__/Admin/index/group_id/{$g.id}">点击查看用户列表</a></td>
										<td>
											<a href="__CONTROLLER__/editgroup/group_id/{$g.id}" title="修改">
												<i class="fa fa-file-text-o text-danger" style="font-size:2.0rem"></i>&nbsp;
			   								</a>
			   								<a href="javascript:;" onclick="delgroup({$g.id});" title="删除">
												<i class="fa fa-trash-o text-danger" style="font-size:2.0rem"></i>&nbsp;
			   								</a>
		   								</td>
									</tr>
									</foreach>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>