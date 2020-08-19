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

function addadmin(id)
{
    if(id!='') {
        swal({
            title:"确定要到账？",
            text:"",
            type:"warning",
            showCancelButton:true,
            cancelButtonText:"取消",
            confirmButtonColor:"#DD6B55",
            confirmButtonText:"确认",
            closeOnConfirm:false
        },function(){
            $.ajax({
                type:"POST",
                url: "/dmooo.php/Dmoney/rechargeAdd",
                dataType:"html",
                data:"id="+id,
                success:function(msg)
                {
                    if(msg=='1')
                    {
                        swal({
                            title:"到账成功！",
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
function deladmin(id)
{
    if(id!='') {
        swal({
            title:"确定要拒绝？",
            text:"",
            type:"warning",
            showCancelButton:true,
            cancelButtonText:"取消",
            confirmButtonColor:"#DD6B55",
            confirmButtonText:"确认",
            closeOnConfirm:false
        },function(){
            $.ajax({
                type:"POST",
                url: "/dmooo.php/Dmoney/rechargeDel",
                dataType:"html",
                data:"id="+id,
                success:function(msg)
                {
                    if(msg=='1')
                    {
                        swal({
                            title:"拒绝成功！",
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
						<h3>当前位置： 虚拟币管理  &raquo; 充值记录</h3>
					</div>
					<div class="ibox-content">
						<div class="ibox">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>ID</th>
										<th>用户</th>
										<th>币种</th>
										<th>客户钱包地址</th>
										<th>充值金额</th>
										<th>审核</th>
									</tr>
								</thead>
								<tbody>
									<foreach name="data" item="value">
									<tr>
										<td>{$value.id}</td>
										<td>{$value.username}</td>
										<td>{$value.name}</td>
										<td>{$value.url}</td>
                                        <td>{$value.money}</td>
										<td>
                                        <?php
                                        if($value['status'] == 0){
                                            echo '
                                                <a href="javascript:;" onclick="addadmin('.$value["id"].');">
												到账
											</a>
                                            |
											<a href="javascript:;" onclick="deladmin('.$value["id"].');">
                                				拒绝
                                			</a>
                                            ';
                                        } else if ($value['status'] == 1) {
                                            echo '已到账';
                                        } else {
                                            echo "已拒绝";
                                        }

                                        ;?>
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