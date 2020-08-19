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

<link rel="stylesheet" type="text/css" href="__CSS__/page.css" />

<script type="text/javascript">
function changestatus(uid,status)
{
	if(uid!='')
	{
		$.ajax({
			type:"POST",
			url:"/dmooo.php/User/changestatus",
			dataType:"html",
			data:"uid="+uid+"&status="+status,
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

function del(uid)
{
	if(uid!='') {
		swal({
			title:"确定要删除该用户吗？删除后将无法恢复！！！",
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
				url:'/dmooo.php/User/del',
				dataType:"html",
				data:"uid="+uid,
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
						<h3>当前位置：牧场管理 &raquo; 交易中心<a class="pull-right" href="<?php echo $_SERVER['HTTP_REFERER'];?>">返回上一页 <i class="fa fa-angle-double-right"></i></a></h3>
					</div>
					<div class="ibox-content">
						<div class="ibox">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>ID</th>
                                        <th>用户昵称</th>
                                        <th>商品名字</th>
                                        <th>电话</th>
                                        <th>微信</th>
										<th>数量</th>
										<th>价格</th>
                                        <th>交易方式</th>
                                        <th>状态</th>
										<th>上架时间</th>
									</tr>
								</thead>
								<tbody>
	                                <foreach name="list" item="l">
                            	      <tr>
                            	          <td>{$l['id']}</td>
                                          <td>{$l['username']}</td>
                                          <td>
                                              鸵鸟蛋
                                          </td>
                                          <td>{$l['phone']}</td>
                                          <td>{$l['wx']}</td>
                            			  <td>{$l['num']}</td>
                            			  <td>{$l['price']}</td>
                                          <td>
                                              <?php
                                              if($l['img']) {
                                                  echo '<img src="'.@$l['img'].'" height="50px" onclick="lookimg(this.src)">';
                                              }
                                              ?>
                                          </td>
                                          <td>上架</td>
                                          <td>{$l['addtime']}</td>
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
    <script>
        function lookimg(str)
        {
            var newwin=window.open()
            newwin.document.write("<img src="+str+" />")
        }
    </script>
</body>
</html>