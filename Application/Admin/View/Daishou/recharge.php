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
                url:"/dmooo.php/Daishou/rechargestatus",
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
						<h3>当前位置：财务管理 &raquo; 充值审核<i class="fa fa-angle-double-right"></i></a></h3>
					</div>
					<div class="ibox-content">
						<div class="ibox">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>ID</th>
                                        <th>昵称</th>
                                        <th>用户UID</th>
                                        <th>金额</th>
                                        <th>转账凭证</th>
                                        <th>状态</th>
										<th>上架时间</th>
                                        <th>处理</th>
									</tr>
								</thead>
								<tbody>
	                                <foreach name="list" item="l">
                            	      <tr>
                            	          <td>{$l['id']}</td>
                                          <td>{$l['username']}</td>
                                          <td>{$l['uid']}</td>
                                          <td>{$l['money']}</td>
                                          <td>
                                              <?php
                                              if($l['img']) {
                                                  echo '<img src="'.@$l['img'].'" height="50px" onclick="lookimg(this.src)">';
                                              }
                                              ?>
                                          </td>

                                          <td>
                                              <?php
                                              if($l['status'] == 0) {
                                                  echo "待审核";
                                              }
                                              if($l['status'] == 1) {
                                                  echo "已通过";
                                              }
                                              if($l['status'] == 2) {
                                                  echo "已拒绝";
                                              }
                                              ?>

                                          </td>
                                          <td>{$l['addtime']}</td>
                                          <td>
                                              <?php
                                              if($l['status'] == 0) {
                                                  echo ' <a onclick="changestatus('.$l['id'].',1)">审核通过</a> |  <a onclick="changestatus('.$l['id'].',2)">拒绝</a>';
                                              }
                                              ?>
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
    <script>
        function lookimg(str)
        {
            var newwin=window.open()
            newwin.document.write("<img src="+str+" />")
        }
    </script>
</body>
</html>