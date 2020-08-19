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
    <script type="text/javascript" src="__JS__/area.js"></script>
</head>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3>当前位置： 门店管理  &raquo; 编辑 <a class="pull-right" href="__CONTROLLER__/index">返回上一页 <i class="fa fa-angle-double-right"></i></a></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form action="__ACTION__"  class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">门店名称</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="name" placeholder="" value="{$data.name}" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">代收名</label>
                                <div class="col-sm-10">
                                    <input name="dsname" class="form-control" value="{$data.dsname}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">联系方式</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="tel" placeholder="" value="{$data.tel}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">地区</label>
                                <div class="col-sm-10">
                                    <select name="province" id="province" class="form-control m-b pull-left" style="width:100px"></select>
                                    <select name="city" id="city" class="form-control m-b pull-left" style="width:100px"></select>
                                    <select name="county" id="county" class="form-control m-b" style="width:100px"></select>
                                    <script type="text/javascript">var opt0 = ["{$data['province']}","{$data['city']}","{$data['county']}"];</script>
                                    <script type="text/javascript">setup()</script>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">门店地址(自动识别经纬度)</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="address" placeholder="" value="{$data.address}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <input type="hidden" name="id" value="{$id}">
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