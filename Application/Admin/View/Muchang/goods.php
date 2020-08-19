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

    function price(id,price) {
        swal({
                title:'调整价格 ',
                text:'原价格('+price+')：',
                type:'input',
                showCancelButton:true,
                closeOnConfirm:false,
                confirmButtonText:'确定',
                cancelButtonText:'取消',
                animation:'slide-from-top',
                inputPlaceholder:''
            },
            function(inputValue){
                if(inputValue==false) return false;
                if(inputValue==''){
                    swal.showInputError('你必须写入一些东西');
                    return false;
                }
                $.ajax({
                    type:"POST",
                    url:'/dmooo.php/Muchang/goodsedit',
                    dataType:"html",
                    data:"id="+id+"&price="+inputValue,
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

    function goodsnum(id,num) {
        swal({
                title:'调整数量 ',
                text:'原数量('+num+')：',
                type:'input',
                showCancelButton:true,
                closeOnConfirm:false,
                confirmButtonText:'确定',
                cancelButtonText:'取消',
                animation:'slide-from-top',
                inputPlaceholder:''
            },
            function(inputValue){
                if(inputValue==false) return false;
                if(inputValue==''){
                    swal.showInputError('你必须写入一些东西');
                    return false;
                }
                $.ajax({
                    type:"POST",
                    url:'/dmooo.php/Muchang/goodsedit',
                    dataType:"html",
                    data:"id="+id+"&num="+inputValue,
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

    function jihuoma(id)
    {
        if(id!='') {
            swal({
                title:"确定要生成激活码？",
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
                    url: "/dmooo.php/Muchang/buildjihuoma",
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
                            },function(){
                                location.reload();
                            })
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
						<h3>当前位置：牧场管理 &raquo; 商城<i class="fa fa-angle-double-right"></i></a></h3>
					</div>
					<div class="ibox-content">
						<div class="ibox">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>ID</th>
                                        <th>商品名字</th>
										<th>数量</th>
										<th>价格</th>
										<th>上架时间</th>
                                        <th>后台调整</th>
									</tr>
								</thead>
								<tbody>
	                                <foreach name="list" item="l">
                            	      <tr>
                            	          <td>{$l['id']}</td>
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
                            			  <td>{$l['num']}</td>
                            			  <td>
                                                <?php
                                            if($l["price"] > 0) {
                                                echo $l["price"];
                                            } else {
                                                echo "无法购买";
                                            }
                                                ?>

                                          </td>
                                          <td>{$l['addtime']}</td>
                                          <td>
                                              <button onclick="price({$l['id']},{$l['price']});">调整价格</button>
                                              <button onclick="goodsnum({$l['id']},{$l['num']});">调整数量</button>
                                              <button onclick="jihuoma({$l['id']});">生成激活码</button>
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