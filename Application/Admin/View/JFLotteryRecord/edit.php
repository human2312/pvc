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
                    <h3>当前位置：营销中心 &raquo; 中奖记录管理<a class="pull-right" href="__CONTROLLER__/index?id={$data.l_id}">返回上一页 <i class="fa fa-angle-double-right"></i></a></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form action="__ACTION__/id/{$id}"  class="form-horizontal" method="post" enctype="multipart/form-data">
                            <input hidden="hidden" name="l_id" value="{$data.l_id}"  >
                            <div class="form-group">
                                <label class="col-sm-2 control-label">收货人</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="receiver" value="{$data.receiver}" placeholder="" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">手机号码</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="phone" value="{$data.phone}" placeholder="" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">收货地区</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="area" value="{$data.area}" placeholder="" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">收货地址</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="address" value="{$data.address}" placeholder="" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">运单号码</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="shipid" value="{$data.shipid}" placeholder="" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">运单公司</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="shipname" value="{$data.shipname}" placeholder="" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">物流编号</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="express" value="{$data.express}" placeholder="" >
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