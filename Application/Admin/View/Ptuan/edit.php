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


<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3>当前位置： 拼团  &raquo; 商品管理<a class="pull-right" href="__CONTROLLER__/goods">返回上一页 <i class="fa fa-angle-double-right"></i></a></h3>
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
                                <label class="col-sm-2 control-label">起拍价</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="qipai" value="{$data.qipai}" placeholder="" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">返利</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="back_l" value="{$data.back_l}" placeholder="" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">状态</label>
                                <div>
                                    <div class="radio i-checks">
                                        <label>
                                            <input type="radio" name="status" value="1" <?php if($data['status']=='1') echo 'checked'; ?> > <i></i>上架
                                             &nbsp;          &nbsp;          &nbsp;          &nbsp;
                                            <input type="radio" name="status" value="2" <?php if($data['status']=='2') echo 'checked'; ?> > <i></i>下架
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>&nbsp;更新</button>
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