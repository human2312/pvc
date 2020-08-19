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


        function sms(ordersn) {
            if(ordersn!='') {
                swal({
                    title:"确定要发送短信通知吗",
                    text:"",
                    type:"warning",
                    showCancelButton:true,
                    cancelButtonText:"取消",
                    confirmButtonColor:"#DD6B55",
                    confirmButtonText:"确认",
                    closeOnConfirm:false
                },function(){
                    $.ajax({
                        type:"POST",
                        url: "/dmooo.php/Daishou/sms",
                        dataType:"html",
                        data:"ordersn="+ordersn,
                        success:function(msg)
                        {
                            if(msg=='1')
                            {
                                swal({
                                    title:"通知成功！",
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

        function gethuowu(ordersn) {
            if(ordersn!='') {
                swal({
                    title:"确定送达货物",
                    text:"",
                    type:"warning",
                    showCancelButton:true,
                    cancelButtonText:"取消",
                    confirmButtonColor:"#DD6B55",
                    confirmButtonText:"确认",
                    closeOnConfirm:false
                },function(){
                    $.ajax({
                        type:"POST",
                        url: "/dmooo.php/Daishou/gethuowu",
                        dataType:"html",
                        data:"ordersn="+ordersn,
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

        function getmoney(ordersn) {
            if(ordersn!='') {
                swal({
                    title:"确定收到订单金额",
                    text:"",
                    type:"warning",
                    showCancelButton:true,
                    cancelButtonText:"取消",
                    confirmButtonColor:"#DD6B55",
                    confirmButtonText:"确认",
                    closeOnConfirm:false
                },function(){
                    $.ajax({
                        type:"POST",
                        url: "/dmooo.php/Daishou/getmoney",
                        dataType:"html",
                        data:"ordersn="+ordersn,
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

        function finishorder(ordersn) {
            if(ordersn!='') {
                swal({
                    title:"确定完成",
                    text:"",
                    type:"warning",
                    showCancelButton:true,
                    cancelButtonText:"取消",
                    confirmButtonColor:"#DD6B55",
                    confirmButtonText:"确认",
                    closeOnConfirm:false
                },function(){
                    $.ajax({
                        type:"POST",
                        url: "/dmooo.php/Daishou/finishorder",
                        dataType:"html",
                        data:"ordersn="+ordersn,
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
                    <h3>当前位置：代寄管理 &raquo; 列表 <i class="fa fa-angle-double-right"></i></a></h3>
                </div>
                <div class="ibox-content">
                    <form action="__ACTION__" method="get" role="form" class="form-inline pull-left">
                        <input type="hidden" name="p" value="1">
                        手机号码：<input type="text" value="<?php echo $_REQUEST["phone"];?>" placeholder="" name="phone" class="form-control" style="width:100px">
                        包裹单号：<input type="text" value="<?php echo $_REQUEST["fromsn"];?>" placeholder="" name="fromsn" class="form-control" style="width:100px">
                        <button class="btn btn-primary" type="submit">查询</button>
                    </form>
                    <div class="ibox">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>单号</th>
                                <th>包裹单号</th>
                                <th>货品名称</th>
                                <th>UID</th>
                                <th>归属客户</th>
                                <th>规格大小</th>
                                <th>门店</th>
                                <th>订单金额</th>
                                <th>配送金额</th>
                                <th>短信通知</th>
                                <th>状态</th>
                                <th>后台调整</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <foreach name="list" item="l">
                                <tr>
                                    <td>{$l['id']}</td>
                                    <td>{$l['ordersn']}</td>
                                    <td>{$l['fromsn']}</td>
                                    <td>{$l['name']}</td>
                                    <td>{$l['uid']}</td>
                                    <td>{$l['username']}</td>
                                    <td>
                                        <?php
                                            if($l["size"] == 0) {
                                                echo "特细";
                                            }
                                        if($l["size"] == 1) {
                                            echo "细型";
                                        }
                                        if($l["size"] == 2) {
                                            echo "中小";
                                        }
                                        if($l["size"] == 3) {
                                            echo "中型";
                                        }
                                        if($l["size"] == 4) {
                                            echo "中大";
                                        }
                                        if($l["size"] == 5) {
                                            echo "大型";
                                        }
                                        if($l["size"] == 6) {
                                            echo "特大";
                                        }
                                        if($l["size"] == 7) {
                                            echo "巨大";
                                        }

                                        ?>
                                    </td>
                                    <td>{$l['shopname']}</td>
                                    <td>{$l['amount']}</td>
                                    <td>{$l['fee']}</td>
                                    <td>
                                        <?php
                                        if($l["sms"] == 0) {
                                            echo "未通知";
                                        }
                                        if($l["sms"] > 0) {
                                            echo "已通知".$l["sms"]."次";
                                        }
                                        ?>

                                    </td>
                                    <td>
                                        <?php
                                        if($l["type"] == 1) {
                                            if($l["status1"] == 0) {
                                                echo "包裹到店";
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
                                        <button onclick="sms('{$l['ordersn']}');">短信通知</button>
                                        <button onclick="gethuowu('{$l['ordersn']}');">已付货物</button>
                                        <br/>
                                        <button onclick="getmoney('{$l['ordersn']}');">已收货款</button>
                                        <button onclick="finishorder('{$l['ordersn']}');">订单完成</button>
                                    </td>
                                    <td>

                                        <a href="__MODULE__/Daishou/orderedit">编辑</a>|
                                        <a href="__MODULE__/Daishou/orderlog?ordersn={$l['ordersn']}">足迹</a>
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