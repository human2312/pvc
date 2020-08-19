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
<!-- Sweet Alert -->
<link href="__ADMIN_CSS__/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<script src="__ADMIN_JS__/plugins/sweetalert/sweetalert.min.js"></script>
<!-- Sweet Alert -->

<script type="text/javascript">
function changestatus(id,status)
{
	if(id!='')
	{
		$.ajax({
			type:"POST",
			url:"/dmooo.php/UserGroup/changestatus",
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

function del(id)
{
	if(id!='') {
		swal({
			title:"确定要删除该分组吗？",
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
				url:"/dmooo.php/UserGroup/del",
				dataType:"html",
				data:"id="+id,
				success:function(msg)
				{
					if(msg=='2')
					{
						swal({
							title:"该会员组下存在会员，不准直接删除会员组！",
							text:"",
							type:"error"
						},function(){location.reload();})
					}
				    if(msg=='1')
					{
						swal({
							title:"删除成功！",
							text:"",
							type:"success"
						},function(){location.reload();})
					}
				    if(msg=='0'){
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
						<h3>当前位置： 会员管理  &raquo; 会员组管理</h3>
					</div>
					<div class="ibox-content">
						<a class="btn btn-primary pull-right" href="__CONTROLLER__/add">添加会员组</a>
						<div class="ibox">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>ID</th>
										<th>会员组名</th>
										<th>收益比例-用户</th>
										<th>收益比例-扣税</th>
										<th>收益比例-平台</th>
										<th>状态</th>
										<th>添加时间</th>
										<th>升级所需经验值</th>
										<th>会员数量</th>
										<th>查看会员列表</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$user=new \Common\Model\UserModel();
									?>
									<foreach name="glist" item="g">
									<tr>
										<td>{$g['id']}</td>
										<td>{$g['title']}</td>
										<td>{$g['fee_user']}%</td>
										<td>{$g['fee_service']}%</td>
										<td>{$g['fee_plantform']}%</td>
										<td>
											<if condition='$g[is_freeze] eq N'>
		            							<button type="button" class="btn btn-primary btn-sm" onclick="changestatus({$g.id},'Y');">正常使用</button>
											<else/>
												<button type="button" class="btn btn-danger btn-sm" onclick="changestatus({$g.id},'N');">已被冻结</button>
											</if>
										</td>
										<td>{$g['createtime']}</td>
										<td>{$g['exp']}</td>
										<td>
										<?php
										$group_id=$g['id'];
										$unum=$user->where("group_id=$group_id")->count();
										echo $unum;
										?>
										</td>
										<td><a href="__MODULE__/User/index/group_id/{$g.id}">点击查看会员列表</a></td>
										<td>
											<a href="__CONTROLLER__/edit/group_id/{$g.id}" title="修改">
					  							<i class="fa fa-file-text-o text-danger" style="font-size:2.0rem"></i>&nbsp;
			    							</a>
			    							<a href="javascript:;" onclick="del({$g.id});" title="删除">
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