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

    </script>
</head>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3>当前位置：订单管理 &raquo; 订单动态 <a class="pull-right" href="<?php echo $_SERVER['HTTP_REFERER'];?>">返回上一页 <i class="fa fa-angle-double-right"></i></a></h3>
                </div>
                <div class="ibox-content">
                    <div class="ibox">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>订单号</th>
                                <th>标签</th>
                                <th>评分</th>
                                <th>内容</th>
                                <th>评价时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            <foreach name="list" item="l">
                                <tr>
                                    <td>{$l['id']}</td>
                                    <td>{$l['order']}</td>
                                    <td>{$l['label']}</td>
                                    <td>{$l['score']}</td>
                                    <td>{$l['content']}</td>
                                    <td>{$l['ctime']}</td>
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