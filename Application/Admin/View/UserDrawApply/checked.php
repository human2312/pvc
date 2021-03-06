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

<link rel="stylesheet" type="text/css" href="__CSS__/page.css" />

<!-- 日期时间 -->
<script src="__ADMIN_JS__/plugins/layer/laydate/laydate.js"></script>
<!-- 日期时间 -->

</head>

<body class="gray-bg">
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h3>当前位置： 资金管理 &raquo; 用户已审核提现申请</h3>
					</div>
					<div class="ibox-content">
                        <form action="__ACTION__" method="get" role="form" class="form-inline pull-left">
                        	<input type="hidden" name="p" value="1">
                        	 用户手机号码：<input type="text" placeholder="" name="phone" class="form-control">
                        	 开始时间：<input type="text" placeholder="" name="begin_time" class="form-control layer-date" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">
                        	 结束时间：<input type="text" placeholder="" name="end_time" class="form-control layer-date" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">
                        	 审核结果：<select class="form-control" name="check_result">
                        	 <option value="">请选择</option>
                        	 <option value="Y">审核通过</option>
                        	 <option value="N">审核不通过</option>
                        	 </select>
                            <button class="btn btn-primary" type="submit">查询</button>
                        </form>
						<div class="">
							<div class="ibox-content">
								<h3><strong style="color:red;">总笔数：{$allnum}，总金额：￥{$allmoney}</strong></h3>
							</div>
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>ID</th>
										<th>提现用户</th>
										<th>提现金额</th>
										<th>银行</th>
										<th>卡号</th>
										<th>收款方真实姓名</th>
										<th>申请时间</th>
										<th>审核结果</th>
										<th>审核时间</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<?php
										$User=new \Common\Model\UserModel();
										foreach($list as $l) {
										    //提现用户
										    $user_id=$l['user_id'];
										    $UserMsg=$User->getUserMsg($user_id);
										    $user_phone=$UserMsg['phone'];
										    //银行
										    $account_type_d=json_decode(account_type_d,true);
										    $account_type=$account_type_d[$l['account_type']];
										    //审核结果
										    if($l['check_result']=='Y') {
										        $check_result='审核通过';
										    }else {
										        $check_result='审核不通过';
										    }
										    echo '<tr>
                                                     <td>'.$l['user_draw_apply_id'].'</td>
       		                                         <td>'.$user_phone.'</td>
       		                                         <td>￥'.$l['money'].'</td>
          	                                         <td>'.$account_type.'</td>
       		                                         <td>'.$l['account'].'</td>
        	                                         <td>'.$l['truename'].'</td>
          	                                         <td>'.$l['apply_time'].'</td>
          	                                         <td>'.$check_result.'</td>
          	                                         <td>'.$l['check_time'].'</td>
          	                                         <td>
        		                                          <a href="__CONTROLLER__/checkedView/user_draw_apply_id/'.$l['user_draw_apply_id'].'" title="查看">
			                                                 <i class="fa fa-file-text-o text-danger" style="font-size:2.0rem"></i>&nbsp;
		                                                  </a>
        	                                          </td>
       		                                         </tr>';
										}
										?>
									</tr>
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