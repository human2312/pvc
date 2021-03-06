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
	$('.topCat').click(function(){
		var status=$(this).html();
		if(status=='+')
		{
			//改变符号
			$(this).html('-');
			//显示子分类
			$(this).parents('tr').nextUntil(".tr_top").show();
		}else {
			//改变符号
			$(this).html('+');
			//显示子分类
			$(this).parents('tr').nextUntil(".tr_top").hide();
		}
	});
	
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
			url:"/dmooo.php/TaobaoCat/changestatus",
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
			title:"确定要删除该分类吗？",
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
				url:"/dmooo.php/TaobaoCat/del",
				dataType:"html",
				data:"id="+id,
				success:function(msg)
				{
					if(msg=='2') {
						swal({
							title:"该分类下还有子级类型，需要先删除子级分类！",
							text:"",
							type:"error"
						},function(){location.reload();})
					}
				    if(msg=='1') {
						swal({
							title:"删除成功！",
							text:"",
							type:"success"
						},function(){location.reload();})
					}
				    if(msg=='0') {
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
						<h3>当前位置： 淘宝管理系统 &raquo; 淘宝商品分类管理</h3>
					</div>
					<div class="ibox-content">
						<div class="row">
							<a class="btn btn-primary pull-right" href="__CONTROLLER__/add">添加淘宝商品分类</a>
       					</div>
						<div class="">
							<form action="__CONTROLLER__/changesort" method="post">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>ID</th>
										<th>淘宝商品分类名称</th>
										<th>商品分类图标</th>
										<th>淘宝官方分类ID</th>
										<th>状态</th>
										<th>排序</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach($list as $l) {
									    //偏移值
									    if($l['leftpin']!='0') {
									        $leftpin=$l['leftpin'];
									    }else {
									        $leftpin=10;
									    }
									    //图标
									    if($l['icon']) {
									        $icon='<img src="'.$l['icon'].'" height="30px">';
									    }else {
									        $icon='';
									    }
									    //菜单状态
									    if($l['is_show']=='Y') {
									        $show_str='显示';
									        $change_show='N';
									        $show_css='btn btn-primary btn-sm';
									    }else {
									        $show_str='隐藏';
									        $change_show='Y';
									        $show_css='btn btn-danger btn-sm';
									    }
									    //顶级分类
									    if($l['pid']==0) {
									        $topCat='<span class="topCat">+</span> ';
									        $tr_class='tr_top';
									    }else {
									        $topCat='';
									        $tr_class='tr_sub';
									    }
									    echo '<tr class="'.$tr_class.'">
                                                <td>'.$l['taobao_cat_id'].'</td>
                                                <td style="text-align:left;padding-left:'.$leftpin.'px">'.$topCat.''.$l['lefthtml'].''.$l['name'].'</td>
       		                                    <td>'.$icon.'</td>
			                                    <td>'.$l['tb_cat_id'].'</td>
                                                <td><button type="button" class="'.$show_css.'" onclick="changestatus('.$l['taobao_cat_id'].',\''.$change_show.'\');">'.$show_str.'</button></td>
                                                <td class="has-warning"><input name="sort['.$l['taobao_cat_id'].']" value="'.$l['sort'].'" class="form-control" style="width:50px;text-align:center"/></td>
       		                                    <td>
		                                            <a href="__CONTROLLER__/edit/taobao_cat_id/'.$l['taobao_cat_id'].'" title="修改">
			                                             <i class="fa fa-file-text-o text-danger" style="font-size:2.0rem"></i>&nbsp;
      		                                        </a>
		                                            <a href="javascript:;" onclick="del('.$l['taobao_cat_id'].');" title="删除">
			                                             <i class="fa fa-trash-o text-danger" style="font-size:2.0rem"></i>&nbsp;
		                                            </a>
		                                         </td>
       		                                   </tr>';
									}
									?>
									<tr>
										<td colspan="7">
	        								<input type="submit" class="btn btn-primary pull-right" value="统一排序">
		  								</td>
	   								</tr>
								</tbody>
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