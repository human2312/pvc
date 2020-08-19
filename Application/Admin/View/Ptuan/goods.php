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

function deladmin(id)
{
    if(id!='') {
        swal({
            title:"确定要提前开奖？",
            text:"",
            type:"warning",
            showCancelButton:true,
            cancelButtonText:"取消",
            confirmButtonColor:"#DD6B55",
            confirmButtonText:"确定",
            closeOnConfirm:false
        },function(){
            $.ajax({
                type:"POST",
                url: "/dmooo.php/Ptuan/goodsOpen",
                dataType:"html",
                data:"id="+id,
                success:function(msg)
                {
                    if(msg=='1')
                    {
                        swal({
                            title:"操作成功！",
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
						<h3>当前位置： 拼团  &raquo; 商品管理</h3>
					</div>

					<div class="ibox-content">
						<div class="ibox">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
                                        <th>店铺名称</th>
                                        <th>商品名称</th>
										<th>当前期</th>
                                        <th>商品图片</th>
                                        <th>状态</th>
                                        <th>中奖号码</th>
                                        <th>价格 / 原价 </th>
                                        <th>时间</th>
                                        <th>当期订单数 / 总数</th>
                                        <th>订单记录</th>
                                        <th>操作</th>
									</tr>
								</thead>
								<tbody>
									<foreach name="data" item="value">
									<tr>
                                        <td>{$value.shopname}</td>
                                        <td>{$value.name}</td>
                                        <td>第{$value.qi}期</td>
                                        <td>

                                            <?php
                                            if($value['imgs']) {

                                                $imgs = json_decode($value['imgs'],true);
                                                echo '<img src="'.@$imgs[0].'" height="50px">';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if(intval($value['status']) != 1){
                                                echo '下架';
                                            } else if(intval($value['qipai']) <= 0){
                                                echo '未生效';
                                            }else if(intval($value['back_l']) <= 0){
                                                echo '未生效';
                                            } else if($value['isopen'] == 1){
                                                echo '活动中';
                                            } else if($value['isopen'] == 2){
                                                echo '已开奖';
                                            }else if($value['isopen'] == 3){
                                                echo '已结束';
                                            }else {
                                                echo '-';
                                            } ?>
                                        </td>
                                        <td>{$value.lucky}</td>
                                        <td>{$value.price} / {$value.sale}</td>
                                        <td>{$value.addtime}</td>
                                        <td>{$value.orderNowNum} / {$value.orderNum}</td>
                                        <th><a href="/dmooo.php/Ptuan/order?goods_id={$value.id}">当期列表</a> | <a href="/dmooo.php/Ptuan/oldorder?goods_id={$value.pid}">往期列表</a></th>
                                        <td>
                                            <?php
                                            if($value['isopen'] == 1){
                                                echo '
                                            <a href="javascript:;" onclick="deladmin('.$value['id'].');" title="提前开奖">提前开奖</a> | 
                                                ';
                                            } else {
                                                echo "";
                                            }
                                            ?>
                                            <a href="/dmooo.php/Ptuan/edit?id={$value.id}">修改活动</a>
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