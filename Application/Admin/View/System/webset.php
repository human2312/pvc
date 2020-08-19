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
<script src="__ADMIN_JS__/bootstrap.min.js?v=3.3.6"></script>
</head>

<body class="gray-bg">
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h3>当前位置：系统设置 &raquo; 站点设置</h3>
					</div>
				</div>
			</div>
			<div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                    <ul class="nav nav-tabs">
                        <li class="active">
                        	<a data-toggle="tab" href="#tab-1" aria-expanded="true">APP配置</a>
                        </li>
                        <li class="">
                        	<a data-toggle="tab" href="#tab-2" aria-expanded="false">网站配置</a>
                        </li>
                    </ul>
                    <form action="__ACTION__"  class="form-horizontal" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="old_app_name" value="{$msg['app_name']}">
                        <input type="hidden" name="old_version_ios" value="{$msg['version_ios']}">
                        <input type="hidden" name="old_version_android" value="{$msg['version_android']}">
                        <input type="hidden" name="old_down_ios" value="{$msg['down_ios']}">
                        <input type="hidden" name="old_down_android" value="{$msg['down_android']}">
                        <input type="hidden" name="old_update_content_ios" value="{$msg['update_content_ios']}">
                        <input type="hidden" name="old_update_content_android" value="{$msg['update_content_android']}">
                        
                        <input type="hidden" name="old_web_url" value="{$msg['web_url']}">
                        <input type="hidden" name="old_web_title" value="{$msg['web_title']}">
                        <input type="hidden" name="old_keywords" value="{$msg['keywords']}">
      					<input type="hidden" name="old_description" value="{$msg['description']}">
      					<input type="hidden" name="old_copyright" value="{$msg['copyright']}">
      					<input type="hidden" name="old_web_title_en" value="{$msg['web_title_en']}">
      					<input type="hidden" name="old_keywords_en" value="{$msg['keywords_en']}">
      					<input type="hidden" name="old_description_en" value="{$msg['description_en']}">
      					<input type="hidden" name="old_copyright_en" value="{$msg['copyright_en']}">
      				<div class="tab-content">
      					<!-- APP配置  -->
      					<div id="tab-1" class="tab-pane active" style="padding-top: 10px">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">App名称</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="app_name" value="{$msg['app_name']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">苹果版本号</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="version_ios" value="{$msg['version_ios']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">安卓版本号</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="version_android" value="{$msg['version_android']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">苹果下载地址</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="down_ios" value="{$msg['down_ios']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">安卓下载地址</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="down_android" value="{$msg['down_android']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">苹果新版本更新内容</label>
                                <div class="col-sm-10">
                                    <textarea name="update_content_ios" placeholder="" class="form-control" style="height:100px;">{$msg['update_content_ios']}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">安卓新版本更新内容</label>
                                <div class="col-sm-10">
                                    <textarea name="update_content_android" placeholder="" class="form-control" style="height:100px;">{$msg['update_content_android']}</textarea>
                                </div>
                            </div>
                        </div>
                        <!-- APP配置  -->
                        
                        <!-- 网站配置  -->
                        <div id="tab-2" class="tab-pane" style="padding-top: 10px">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">网站标题</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="web_title" value="{$msg['web_title']}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">网站logo</label>
                                <div class="col-sm-10">
                                    <img src="__ADMIN_IMG__/logo.png" width="72">
                                    <span class="help-block m-b-none text-danger">格式要求PNG，文件大小72x72px</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">上传新logo</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="logo" value=""> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">英文网站标题</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="web_title_en" value="{$msg['web_title_en']}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">官网网址/IP地址</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="web_url" value="{$msg['web_url']}"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">SEO关键字(keyword)</label>
                                <div class="col-sm-10">
                                    <textarea name="keywords" placeholder="" class="form-control" style="height:100px;">{$msg['keywords']}</textarea> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">SEO描述(description)</label>
                                <div class="col-sm-10">
                                    <textarea name="description" placeholder="" class="form-control" style="height:100px;">{$msg['description']}</textarea> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">SEO版权(copyright)</label>
                                <div class="col-sm-10">
                                    <textarea name="copyright" placeholder="" class="form-control" style="height:100px;">{$msg['copyright']}</textarea> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">英文SEO关键字(keyword)</label>
                                <div class="col-sm-10">
                                    <textarea name="keywords_en" placeholder="" class="form-control" style="height:100px;">{$msg['keywords_en']}</textarea> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">英文SEO描述(description)</label>
                                <div class="col-sm-10">
                                    <textarea name="description_en" placeholder="" class="form-control" style="height:100px;">{$msg['description_en']}</textarea> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">英文SEO版权(copyright)</label>
                                <div class="col-sm-10">
                                    <textarea name="copyright_en" placeholder="" class="form-control" style="height:100px;">{$msg['copyright_en']}</textarea> 
                                </div>
                            </div>
                        </div>
                        <!-- 网站配置  -->
                        <div class="form-group">
                             <div class="col-sm-4 col-sm-offset-2">
                                 <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>&nbsp;编辑</button>
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