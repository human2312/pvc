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

<link href="__ADMIN_CSS__/img.css" rel="stylesheet">

<script src="__ADMIN_JS__/jquery.min.js?v=2.1.4"></script>
<script src="__ADMIN_JS__/bootstrap.min.js?v=3.3.6"></script>
<script src="__ADMIN_JS__/plugins/iCheck/icheck.min.js"></script>
<!-- Sweet Alert -->
<link href="__ADMIN_CSS__/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<script src="__ADMIN_JS__/plugins/sweetalert/sweetalert.min.js"></script>
<!-- Sweet Alert -->

<!-- ueditor -->
<link rel="stylesheet" type="text/css" href="__PUBLIC__/ueditor/themes/default/css/ueditor.css" />
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/ueditor/lang/zh-cn/zh-cn.js"></script>
<!-- ueditor -->

<script>
//实例化编辑器
var ue = UE.getEditor('editor');

$(document).ready(function(){$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})});

function deloldimg(id)
{
	if(id!=''){
		swal({
			title:"确定删除原图片吗？",
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
				url:'/dmooo.php/BbsArticle/deloldimg',
				dataType:"html",
				data:"id="+id,
				success:function(msg)
				{
				    if(msg=='1') {
						swal({
							title:"删除原图片成功！",
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

function delmobimg(img,id)
{
	if(img){
		swal({
			title:"确定删除该图片吗？",
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
				url:"/dmooo.php/BbsArticle/delmobimg",
				dataType:"html",
				data:"img="+img+'&id='+id,
				success:function(msg)
				{
				    if(msg=='1') {
						swal({
							title:"删除原图片成功！",
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
</head>

<body class="gray-bg">
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h3>当前位置：论坛系统 &raquo; 编辑帖子<a class="pull-right" href="__CONTROLLER__/checkPass">返回上一页 <i class="fa fa-angle-double-right"></i></a></h3>
					</div>
				</div>
			</div>
			<div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                    <ul class="nav nav-tabs">
                        <li class="active">
                        	<a data-toggle="tab" href="#tab-1" aria-expanded="true">帖子基本信息</a>
                        </li>
                        <li class="">
                        	<a data-toggle="tab" href="#tab-2" aria-expanded="false">PC端帖子详情</a>
                        </li>
                        <li class="">
                        	<a data-toggle="tab" href="#tab-3" aria-expanded="false">移动端帖子详情</a>
                        </li>
                    </ul>
                    <form action="__ACTION__/id/{$msg['id']}"  class="form-horizontal" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="oldimg" value="{$msg['img']}">
                        <input type="hidden" name="oldcontent" value='{$msg.content}'>
                       
      				<div class="tab-content">
      					<!-- 帖子基本信息  -->
      					<div id="tab-1" class="tab-pane active" style="padding-top: 10px">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">发布用户</label>
                                <div class="col-sm-10">
                                    <?php
                                    $uid=$msg['uid'];
                                    $User=new \Common\Model\UserModel();
                                    $UserMsg=$User->getUserMsg($uid);
                                    ?>
                                    <input type="text" class="form-control" name="" value="{$UserMsg['phone']}" disabled placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">标题</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" value="{$msg['title']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">标题图片</label>
                                <div class="col-sm-10">
                                    <?php 
                                    if($msg['img']){
                                        echo '<img src="'.$msg['img'].'" height="100"/>
                                        <button class="btn btn-primary" type="button" onclick="deloldimg('.$msg['id'].')">删除原图片</button>';
                                    }else {
                                        echo '暂无';
                                    } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">上传新图片</label>
                                <div class="col-sm-10">
                                    <input type="file" name="img" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">淘宝商品ID</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="tb_gid" value="{$msg['tb_gid']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">联系人</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="linkman" value="{$msg['linkman']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">联系电话</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="contact" value="{$msg['contact']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">地址</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="address" value="{$msg['address']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">点击量</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="clicknum" value="{$msg['clicknum']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">分享次数</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="share_num" value="{$msg['share_num']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">所属版块</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="board_id">
                                    <option value="">-请选择所属版块-</option>
                                    <?php
                                    foreach ($boardlist as $l) {
                                        if($l['board_id']==$board_id) {
                                            $select='selected';
                                        }else {
                                            $select='';
                                        }
                                        echo '<option value="'.$l['board_id'].'" style="margin-left:55px;" '.$select.'>'.$l['lefthtml'].''.$l['board_name'].'</option>';
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">是否显示</label>
                                <div>
                                    <div class="radio i-checks">
                                        <label>
                                        	<input type="radio" name="is_show" value="Y" <?php if($msg['is_show']=='Y') echo 'checked'; ?> > <i></i>是
                                        	<input type="radio" name="is_show" value="N" <?php if($msg['is_show']=='N') echo 'checked'; ?> > <i></i>否
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">是否置顶</label>
                                <div>
                                    <div class="radio i-checks">
                                        <label>
                                        	<input type="radio" name="is_top" value="Y" <?php if($msg['is_top']=='Y') echo 'checked'; ?> > <i></i>是
                                        	<input type="radio" name="is_top" value="N" <?php if($msg['is_top']=='N') echo 'checked'; ?> > <i></i>否
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">置顶时间</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="top_day" value="{$msg['top_day']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">审核结果</label>
                                <div>
                                    <div class="radio i-checks">
                                        <label>
                                        	<input type="radio" name="check_result" value="Y" <?php if($msg['check_result']=='Y') echo 'checked'; ?> > <i></i>是
                                        	<input type="radio" name="check_result" value="N" <?php if($msg['check_result']=='N') echo 'checked'; ?> > <i></i>否
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">审核不通过原因</label>
                                <div class="col-sm-10">
                                    <textarea name="check_reason" placeholder="" class="form-control" style="height:100px;">{$msg['check_reason']}</textarea> 
                                </div>
                            </div>
                        </div>
                        <!-- 帖子基本信息  -->
                        
                        <!-- PC端帖子详情  -->
                        <div id="tab-2" class="tab-pane" style="padding-top: 10px">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">关键词</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="keyword" value="{$msg['keyword']}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">简要说明</label>
                                <div class="col-sm-10">
                                    <textarea name="description" placeholder="" class="form-control" style="height:100px;">{$msg['description']}</textarea> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">内容</label>
                                <div class="col-sm-10">
                                	<script name="content" id="editor" type="text/plain" style="height:300px;">
                                	<?php 
                                    $content=htmlspecialchars_decode(html_entity_decode($msg['content']));
		                            $content=str_replace("&#39;", '"', $content);
		                            echo $content;
		                            ?></script>
                                </div>
                            </div>
                        </div>
                        <!-- PC端帖子详情  -->
                        
                        <!-- 移动端帖子详情  -->
                        <div id="tab-3" class="tab-pane" style="padding-top: 10px">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">移动端内容</label>
                                <div class="col-sm-10">
                                    <textarea name="mob_text" placeholder="" class="form-control" style="height:100px;">{$msg.mob_text}</textarea> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">已上传图片</label>
                                <div class="col-sm-10">
                                    <!--imgContainer-->
                                    <div class="imgContainer">
                                    <ul class="clearfix">
                                    <?php
                                    if($msg['mob_img']) {
                                        $img_arr=$msg['mob_img_arr'];
                                        $img_num=count($img_arr);
                                        for ($i=0;$i<$img_num;$i++) {
                                            echo '<li>
                                                    <span class="imgbox"><img src="'.$img_arr[$i].'"/></span>
					                               <span class="del" onclick="delmobimg(\''.$img_arr[$i].'\','.$msg['id'].')"><em>×</em>删除</span>
                                                </li>';
                                        }
                                    }
                                    ?>
                                    </ul>
                                    </div>
                                    <!--imgContainer-->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">继续上传图片</label>
                                <div class="col-sm-10">
                                    <input type="file" multiple="multiple" name="imglist[]" class="form-control">
                                </div>
                            </div>
                        </div>
                        <!-- 移动端帖子详情  -->
                        
                        <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>&nbsp;发布帖子</button>
                                    <button class="btn btn-white" type="reset"><i class="fa fa-refresh"></i>&nbsp;重置</button>
                                </div>
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