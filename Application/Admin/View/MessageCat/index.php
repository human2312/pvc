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
<script type="text/javascript">
function del(id)
{
	if(id!='') {
		swal({
			title:"分类下的留言会一起删除，确定要删除该分类吗？",
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
				url:'/dmooo.php/MessageCat/del',
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
						<h3>当前位置： 内容管理 &raquo; 留言分类管理</h3>
					</div>
					<div class="ibox-content">
                        <form action="__CONTROLLER__/add" method="post" role="form" class="form-inline">
                        	留言分类名称：<input type="text" placeholder="" name="title" class="form-control">
                            <button class="btn btn-primary" type="submit">添加留言分类</button>
                        </form>
						<div class="">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>ID</th>
										<th>分类名称</th>
										<th>创建时间</th>
										<th>查看链接列表</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody>
									<foreach name="list" item="l">
									<tr>
										<td>{$l['id']}</td>
										<td>{$l['title']}</td>
										<td>{$l['createtime']}</td>
										<td><a href="__MODULE__/Message/index/cat_id/{$l.id}">点击查看留言列表</a></td>
										<td>
											<a href="__CONTROLLER__/edit/id/{$l.id}" title="修改">
												<i class="fa fa-file-text-o text-danger" style="font-size:2.0rem"></i>&nbsp;
											</a>
											<a href="javascript:;" onclick="del({$l.id});" title="删除">
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