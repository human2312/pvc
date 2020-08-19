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

    function zengsong(id) {
        swal({
                title:'赠送激活码 ',
                text:'指定用户UID：',
                type:'input',
                showCancelButton:true,
                closeOnConfirm:false,
                confirmButtonText:'确定',
                cancelButtonText:'取消',
                animation:'slide-from-top',
                inputPlaceholder:''
            },
            function(inputValue){
                if(inputValue==''){
                    swal.showInputError('你必须写入一些东西');
                    return false;
                }
                $.ajax({
                    type:"POST",
                    url:'/dmooo.php/Muchang/jihuomaedit',
                    dataType:"html",
                    data:"id="+id+"&uid="+inputValue,
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
            }
        );
    }

</script>
</head>

<body class="gray-bg">
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h3>当前位置：牧场管理 &raquo; 激活码<i class="fa fa-angle-double-right"></i></a></h3>
					</div>
					<div class="ibox-content">
						<div class="ibox">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>ID</th>
                                        <th>激活码编号</th>
                                        <th>商品名字</th>
										<th>持有人</th>
										<th>状态</th>
										<th>上架时间</th>
                                        <th>后台调整</th>
									</tr>
								</thead>
								<tbody>
	                                <foreach name="list" item="l">
                            	      <tr>
                            	          <td>{$l['id']}</td>
                                          <td>{$l['no']}</td>
                                          <td>
                                          <?php
                                            if($l["goods_type"] == 1) {
                                                echo "鸵鸟 * ".$l['num'];
                                            }
                                          if($l["goods_type"] == 2) {
                                              echo "口粮 * ".$l['num'];
                                          }
                                          if($l["goods_type"] == 3) {
                                              echo "哈士奇 * ".$l['num'];
                                          }
                                          if($l["goods_type"] == 4) {
                                              echo "延寿丹 * ".$l['num'];
                                          }
                                          if($l["goods_type"] == 5) {
                                              echo "延年丹 * ".$l['num'];
                                          }
                                          ?>
                                          </td>
                            			  <td>{$l['username']}</td>
                            			  <td>
                                                <?php
                                                if($l["status"] == 1) {
                                                    echo "未使用";
                                                }
                                                if($l["status"] == 2) {
                                                    echo "已赠送";
                                                }
                                                if($l["status"] == 3) {
                                                    echo "已使用";
                                                }
                                                ?>

                                          </td>
                                          <td>{$l['addtime']}</td>
                                          <td>
                                              <button onclick="zengsong({$l['id']});">赠送激活码</button>
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