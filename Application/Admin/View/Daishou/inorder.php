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
        function inShelf(ordersn) {
            swal({
                    title:'货物入柜',
                    text:'请填写已绑定此包裹的货柜号',
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
                        url:'/dmooo.php/Daishou/inShelf',
                        dataType:"html",
                        data:"shelf="+inputValue+"&ordersn="+ordersn,
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
                    <h3>当前位置：代收管理 &raquo; 列表 <i class="fa fa-angle-double-right"></i></a></h3>
                </div>
                <div class="ibox-content">
                    <form action="__ACTION__" method="get" role="form" class="form-inline pull-left">
                        <input type="hidden" name="p" value="1">
                        手机号码：<input type="text" value="<?php echo $_REQUEST["phone"];?>" placeholder="" name="phone" class="form-control" style="width:100px">
                        包裹单号：<input type="text" value="<?php echo $_REQUEST["fromsn"];?>" placeholder="" name="fromsn" class="form-control" style="width:100px">
                        货架号：<input type="text" value="<?php echo $_REQUEST["Shelf"];?>"  placeholder="" name="code" class="form-control" style="width:100px">
                        <button class="btn btn-primary" type="submit">查询</button>
                    </form>
                    <div class="ibox">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>单号</th>
                                <th>包裹单号</th>
                                <th>UID</th>
                                <th>归属客户</th>
                                <th>货柜号</th>
                                <th>提货码</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <foreach name="list" item="l">
                                <tr>
                                    <td>{$l['id']}</td>
                                    <td>{$l['ordersn']}</td>
                                    <td>{$l['fromsn']}</td>
                                    <td>{$l['uid']}</td>
                                    <td>{$l['username']}</td>
                                    <td>{$l['shelf']}</td>
                                    <td>
                                        {$l['code']}
                                    </td>
                                    <td>
                                        <?php
                                        if($l["type"] == 1) {
                                            if($l["status1"] == 0) {
                                                echo "已入库";
                                            }
                                            if($l["status1"] == 1) {
                                                echo "已缴费";
                                            }
                                            if($l["status1"] == 2) {
                                                echo "已到达门店";
                                            }
                                            if($l["status1"] == 3) {
                                                echo "派送中";
                                            }
                                            if($l["status1"] == 4) {
                                                echo "已送达";
                                            }
                                            if($l["status1"] == 5) {
                                                echo "已完成";
                                            }
                                            if($l["status1"] == 6) {
                                                echo "已完成且评价";
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <button onclick="inShelf('{$l['ordersn']}');">填写货柜号</button>
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