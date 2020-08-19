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
	
	//取消全选
	$('#unselect').click(function(){
		$("input:checkbox").removeAttr("checked");
		$(".i-checks").iCheck({
			checkboxClass:"icheckbox_square-green",
			radioClass:"iradio_square-green",
		});
	});
	//全选
	$('#selectall').click(function(){
		$("input:checkbox").prop("checked","checked");
		$(".i-checks").iCheck({
			checkboxClass:"icheckbox_square-green",
			radioClass:"iradio_square-green",
		});
	});
	
	//批量删除
	$('#batchdel').click(function(){
		var all_id='';
		$(":checkbox").each(function(){
			if($(this).prop("checked")) 
			{
				all_id+=$(this).val()+',';
			}
		});
		if(all_id!='') {
			swal({
				title:"确定删除这些热门搜索吗？",
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
					url:"/dmooo.php/HotSearch/batchdel",
					dataType:"html",
					data:"all_id="+all_id,
					success:function(msg)
					{
						if(msg=='1')
						{
							swal({
								title:"批量删除成功！",
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
		}else {
			swal({title:"",text:"请选择需要删除的热门搜索！"})
			return false;
		}
	});
	
});

function del(id)
{
	if(id!='') {
		swal({
			title:"确定要删除该热门搜索吗？",
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
				url:"/dmooo.php/HotSearch/del",
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
						<h3>当前位置： 营销中心 &raquo; 热门搜索设置</h3>
					</div>
					<div class="ibox-content">
						<a class="btn btn-primary pull-right" href="__CONTROLLER__/add">添加热门搜索</a>
						<div class="ibox">
							<form action="__CONTROLLER__/changesort" method="post">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th></th>
										<th>ID</th>
										<th>搜索关键词</th>
										<th>搜索次数</th>
										<th>类型</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody>
									<foreach name="list" item="l">
									<tr>
										<td style="text-align: center"><input class="checkbox i-checks" type="checkbox" id="allid[]" value="{$l['id']}"></td>
										<td>{$l.id}</td>
										<td>{$l.search}</td>
										<td>{$l.num}</td>
										<td>
										<?php 
										switch($l['type']){
										    case 1:
										        $type_zh='淘宝';
										        break;
										    case 2:
										        $type_zh='拼多多';
										        break;
										    case 3:
										        $type_zh='京东';
										        break;
										    case 4:
										        $type_zh='自营商城';
										        break;
										    default:
										        $type_zh='';
										        break;
										}
										echo $type_zh;
										?>
										</td>
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
									<tr>
										<td colspan="6">
	        								<input type="button" class="btn btn-primary" id="unselect" value="取消选择">
	        								<input type="button" class="btn btn-primary" id="selectall" value="全选">
	        								<input type="button" class="btn btn-primary" id="batchdel" value="批量删除">
		  								</td>
	   								</tr>
								</tbody>
							</table>
							</form>
							<div class="pages">{$page}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>