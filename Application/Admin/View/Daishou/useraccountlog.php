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

<body class="gray-bg">
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h3>当前位置：财务管理 &raquo; 日志<a class="pull-right" href="<?php echo $_SERVER['HTTP_REFERER'];?>">返回上一页 <i class="fa fa-angle-double-right"></i></a></h3>
					</div>
					<div class="ibox-content">
						<div class="ibox">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>ID</th>
                                        <th>类型</th>
										<th>用户</th>
                                        <th>用户UID</th>
                                        <th>变动余额</th>
										<th>备注</th>
                                        <th>时间</th>
                                        <th>操作员</th>
									</tr>
								</thead>
								<tbody>
	                                <foreach name="list" item="l">
                            	      <tr>
                            	          <td>{$l['id']}</td>
                                          <td>
                                              <?php
                                              if($l['action'] == "recharge") {
                                                  echo "充值";
                                              }
                                              if($l['action'] == "recharge_check") {
                                                  echo "充值审核";
                                              }
                                              ?>
                                          </td>
                            			  <td>{$l['username']}</td>
                                          <td>{$l['uid']}</td>
                            			  <td>{$l['money']}</td>
                                          <td>{$l['remark']}</td>
                                          <td>{$l['addtime']}</td>
                                          <td>
                                              <?php
                                              if($l['byadmin'] > 0) {
                                                  echo "admin";
                                              } else {
                                                  echo "user";
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
</body>
</html>