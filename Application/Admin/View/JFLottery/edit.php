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
    <script src="__ADMIN_JS__/plugins/layer/laydate/laydate.js"></script>
    <!-- Sweet Alert -->
    <link href="__ADMIN_CSS__/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <script src="__ADMIN_JS__/plugins/sweetalert/sweetalert.min.js"></script>
</head>

<script>
    function deloldimg(cat_id)
    {
        if(cat_id!=''){
            swal({
                title:"确定删除原分类图片吗？",
                text:"",
                type:"warning",
                showCancelButton:true,
                cancelButtonText:"取消",
                confirmButtonColor:"#DD6B55",
                confirmButtonText:"删除",
                closeOnConfirm:false
            },function(){
                $.ajax({
                    type:"POST",
                    url:'/dmooo.php/JFLottery/deloldimg',
                    dataType:"html",
                    data:"cat_id="+cat_id,
                    success:function(msg)
                    {
                        if(msg=='1') {
                            swal({
                                title:"删除原分类图片成功！",
                                text:"",
                                type:"success"
                            },function(){location.reload();})
                        }else {
                            swal({
                                title:"删除失败！",
                                text:"",
                                type:"success"
                            },function(){location.reload();})
                        }
                    }
                });
            })
        }
    }
</script>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3>当前位置：营销中心 &raquo; 积分抽奖管理<a class="pull-right" href="__CONTROLLER__/index">返回上一页 <i class="fa fa-angle-double-right"></i></a></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form action="__ACTION__/id/{$id}"  class="form-horizontal" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="oldimg" value="{$data.goodsimg}">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品名称</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="name" value="{$data.name}" placeholder="" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品图片</label>
                                <div class="col-sm-10">
                                    <?php
                                    if($data['goodsimg']){
                                        echo '<img src="'.$data['goodsimg'].'" height="100"/>
                                        <button class="btn btn-primary" type="button" onclick="deloldimg('.$data['id'].')">删除原图片</button>';
                                    }else {
                                        echo '暂无';
                                    } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">上传新图片</label>
                                <div class="col-sm-10">
                                    <input type="file" name="goodsimg" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">最大人数</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="maxnum"  value="{$data.maxnum}" placeholder="" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">消耗积分</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="needjf"  value="{$data.needjf}" placeholder="" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">中奖号码</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="num"  value="{$data.num}" placeholder="" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">补偿积分</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="backjf"  value="{$data.backjf}" placeholder="" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">投注时段</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control layer-date" name="start_time" placeholder=""  value="{$data.start_time}" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})"> -
                                    <input type="text" class="form-control layer-date" name="end_time" placeholder=""  value="{$data.end_time}" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">开奖时间</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control layer-date" name="open_time" placeholder=""  value="{$data.open_time}" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">活动规则</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="content" placeholder="" >{$data.content}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>&nbsp;添加</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>