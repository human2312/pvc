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
<?php             $UserLevel = new \Common\Model\UserLevelModel();?>
<body class="gray-bg">
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h3>当前位置：财务管理 &raquo; 余额列表 <i class="fa fa-angle-double-right"></i></a></h3>
					</div>
					<div class="ibox-content">
						<form action="__ACTION__" method="get" role="form" class="form-inline pull-left">
                        	<input type="hidden" name="p" value="1"> 
                        	<input type="hidden" name="group_id" value="{$group_id}">
                        	手机号码：<input type="text" placeholder="" name="search" class="form-control" value="<?php echo $_REQUEST["search"];?>" style="width:100px">
                        	<button class="btn btn-primary" type="submit">查询</button>
                        </form>
						<div class="ibox">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>UID</th>
                                        <th>昵称</th>
                                        <th>手机</th>
                                        <th>余额</th>
                                        <th>积分</th>
                                        <th>后台操作</th>
									</tr>
								</thead>
								<tbody>

	                                <foreach name="list" item="l">
                            	      <tr>
                            	          <td>{$l['uid']}</td>
                                          <td>{$l['nickname']}</td>
                            			  <td>
                            			  <?php 
                            			  //隐藏手机号码
                            			  $phone=hide_phone($l['phone'], 4, 4);
                            			  if($l['is_buy']=='Y')
                            			  {
                            			      echo '<font color="red">'.$phone.'</font>';
                            			  }else {
                            			      echo $phone;
                            			  }
                            			  ?>
                            			  </td>
                                          <td>
                                              {$l['daishouyue']}
                                          </td>
                                          <td>
                                              {$l['daishoujifen']}
                                          </td>
                                          <td>
                                              <a href="__CONTROLLER__/useraccountedit/uid/{$l.uid}">手工充值</a> |
                                              <a href="__CONTROLLER__/useraccountlog?uid={$l.uid}">日志</a>
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