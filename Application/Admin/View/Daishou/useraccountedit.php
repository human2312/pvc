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
    <style>

        ul,
        li {
            list-style: none;
        }



        .btn-numbox {
            overflow: hidden;
            margin-top: -20px;
            margin-left: -100px;
        }

        .btn-numbox li {
            float: left;
        }

        .btn-numbox li .number,
        .kucun {
            display: inline-block;
            font-size: 12px;
            color: #808080;
            vertical-align: sub;
        }

        .btn-numbox .count {
            overflow: hidden;
            margin: 0 16px 0 -20px;
        }

        .btn-numbox .count .num-jian,
        .input-num,
        .num-jia {
            display: inline-block;
            width: 28px;
            height: 28px;
            line-height: 28px;
            text-align: center;
            font-size: 18px;
            color: #999;
            cursor: pointer;
            border: 1px solid #e6e6e6;
        }
        .btn-numbox .count .input-num {
            width: 58px;
            height: 28px;
            color: #333;
            border-left: 0;
            border-right: 0;
        }
    </style>
<script>
$(document).ready(function(){$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})});
</script>

</head>

<body class="gray-bg">
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h3>当前位置：财务管理 &raquo; 列表 &raquo; 编辑<a class="pull-right" href="__CONTROLLER__/index/group_id/{$msg.group_id}">返回上一页 <i class="fa fa-angle-double-right"></i></a></h3>
					</div>
				</div>
			</div>
			<div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                    <form action="__ACTION__/useraccountedit/{$msg['uid']}"  class="form-horizontal" method="post" enctype="multipart/form-data">

                        <input class="form-control" type="hidden" name="uid" value="{$msg['uid']}" placeholder="">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">余额</label>
                                <div class="col-sm-10">
                                    <ul class="count">

                                        　<ul class="btn-numbox">
                                            <li>
                                                <ul class="count">
                                                    <li><span id="num-jian" class="num-jian">-</span></li>
                                                    <li><input type="text" name="daishouyue" class="input-num" id="input-num" value="{$msg['daishouyue']}" /></li>
                                                    <li><span id="num-jia" class="num-jia">+</span></li>
                                                </ul>
                                            </li>
                                           </ul>

                                    </ul>
                                    <!---<input class="form-control" name="daishouyue" value="{$msg['daishouyue']}" placeholder=""> --->
                                </div>

                            </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">积分</label>
                            <div class="col-sm-10">

                                <ul class="count">

                                    　<ul class="btn-numbox">
                                        <li>
                                            <ul class="count">
                                                <li><span id="num-jian" class="num-jian">-</span></li>
                                                <li><input type="text" name="daishoujifen" class="input-num" id="input-num" value="{$msg['daishoujifen']}" /></li>
                                                <li><span id="num-jia" class="num-jia">+</span></li>
                                            </ul>
                                        </li>
                                    </ul>

                                </ul>

                               <!--- <input class="form-control" name="daishoujifen" value="{$msg['daishoujifen']}" placeholder="">  -->
                            </div>
                        </div>

                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="submit" id="sub"><i class="fa fa-check"></i>&nbsp;手工调整</button>
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
<script>

    var num_jia = document.getElementById("num-jia");
    var num_jian = document.getElementById("num-jian");
    var input_num = document.getElementById("input-num");

    num_jia.onclick = function() {

        input_num.value = parseInt(input_num.value) + 1;
    }

    num_jian.onclick = function() {

        if(input_num.value <= 0) {
            input_num.value = 0;
        } else {

            input_num.value = parseInt(input_num.value) - 1;
        }

    }

</script>
</html>