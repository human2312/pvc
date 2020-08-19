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


function jinbi(uid,jinbi) {
    swal({
            title:'赠送金币',
            text:'金币数量('+jinbi+')+：',
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
                url:'/dmooo.php/Muchang/showedit',
                dataType:"html",
                data:"uid="+uid+"&zengsong="+inputValue,
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

function kouliang(uid,kouliang) {
    swal({
            title:'赠送口粮 ',
            text:'口粮数('+kouliang+')+：',
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
                url:'/dmooo.php/Muchang/showedit',
                dataType:"html",
                data:"uid="+uid+"&kouliang="+inputValue,
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

function daren(uid) {
    swal({
            title:'星级达人调整',
            text:'0=无星级;1=一星达人;2=二星达人;3=三星达人;4=牧场金主',
            type:'input',
            showCancelButton:true,
            closeOnConfirm:false,
            confirmButtonText:'确定',
            cancelButtonText:'取消',
            animation:'slide-from-top',
            inputPlaceholder:'0 - 4'
        },
        function(inputValue){
            if(inputValue==false) return false;
            if(inputValue==''){
                swal.showInputError('你必须写入一些东西');
                return false;
            }
            $.ajax({
                type:"POST",
                url:'/dmooo.php/Muchang/showedit',
                dataType:"html",
                data:"uid="+uid+"&star="+inputValue,
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

function jihuoma(uid) {
    swal({
            title:'使用激活码',
            text:'请填写已绑定此用户或者未绑定任何用户的激活码',
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
                url:'/dmooo.php/Muchang/usejihuoma',
                dataType:"html",
                data:"uid="+uid+"&no="+inputValue,
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
						<h3>当前位置：牧场管理 &raquo; 列表 <i class="fa fa-angle-double-right"></i></a></h3>
					</div>
					<div class="ibox-content">
						<div class="ibox">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>UID</th>
                                        <th>昵称</th>
                                        <th>达人等级</th>
                                        <th>金币</th>
										<th>鸵鸟数量</th>
                                        <th>口粮数</th>
										<th>已有蛋数</th>
										<th>待收蛋数</th>
										<th>是否有狗</th>
                                        <th>是否延寿丹</th>
                                        <th>是否延年丹</th>
                                        <th>后台调整</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody>
	                                <foreach name="list" item="l">
                            	      <tr>
                            	          <td>{$l['uid']}</td>
                                          <td>{$l['username']}</td>
                                          <td>
                                              <?php
                                              if($l['star'] == 0) {
                                                  echo "无";
                                              }
                                              if($l['star'] == 1) {
                                                  echo "一星达人";
                                              }
                                              if($l['star'] == 2) {
                                                  echo "二星达人";
                                              }
                                              if($l['star'] == 3) {
                                                  echo "三星达人";
                                              }
                                              if($l['star'] == 4) {
                                                  echo "牧场金主";
                                              }
                                              ?>
                                          </td>
                                          <td>{$l['jinbi'] + $l['zengsong']}</td>
                            			  <td>{$l['ji']}</td>
                                          <td>{$l['kouliang']}</td>
                            			  <td>{$l['dan']}</td>
                                          <td>{$l['undan']}</td>
                                          <td>
                                              <?php
                                              if($l['dog'] == 1) {
                                                  echo "有";
                                              } else {
                                                  echo "无";
                                              }
                                              ?>
                                          </td>
                                          <td>
                                              <?php
                                              if(strtotime($l['ysddate']) > time()) {
                                                  echo "有";
                                              } else {
                                                  echo "无";
                                              }
                                              ?>
                                          </td>
                                          <td>
                                              <?php
                                              if(strtotime($l['ynddate']) > time()) {
                                                  echo "有";
                                              }else {
                                                  echo "无";
                                              }
                                              ?>
                                          </td>
                                          <td>
                                              <button onclick="jinbi({$l['uid']},{$l['jinbi']+ $l['zengsong']});">充值金币</button>
                                              <button onclick="kouliang({$l['uid']},{$l['kouliang']});">赠送口粮</button>
                                              <button onclick="daren({$l['uid']});">达人调整</button>
                                              <button onclick="jihuoma({$l['uid']});">使用激活码</button>
                                          </td>
                            			  <td>
                                             <a href="__MODULE__/Muchang/log/uid/{$l['uid']}">日志</a>
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

</body>
</html>