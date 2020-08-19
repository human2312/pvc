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
</head>

<script type="text/javascript">
    function changestatus(id,status)
    {
        if(id!='')
        {
            $.ajax({
                type:"POST",
                url:"/dmooo.php/Daishou/activitystatus",
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

<body class="gray-bg">
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h3>当前位置：活动管理 &raquo; 列表</h3>
					</div>
					<div class="ibox-content">
						<div class="ibox">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>ID</th>
                                        <th>活动</th>
										<th>状态</th>
									</tr>
								</thead>
								<tbody>
	                                <foreach name="list" item="l">
                            	      <tr>
                            	          <td>{$l['id']}</td>
                                          <td>{$l['remark']}</td>
                                          <td>
                                              <if condition='$l[status] eq 1'>
                                                  <button type="button" class="btn btn-primary btn-sm" onclick="changestatus({$l.id},'0');">生效中</button>
                                                  <else/>
                                                  <button type="button" class="btn btn-danger btn-sm" onclick="changestatus({$l.id},'1');">未生效</button>
                                              </if>
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