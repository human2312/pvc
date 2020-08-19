<?php
/*
 * @thinkphp3.2.2  auth认证   php5.3以上
 * @如果需要公共控制器，就不要继承AuthController，直接继承Controller
 */
namespace Admin\Common\Controller;
use Think\Controller;
use Think\Auth;

//权限认证
class AuthController extends Controller {
    public $gaodeapi = "https://restapi.amap.com/v3/geocode/geo?output=JSON&key=8dbe868eaaeec8eb6869a8bd9f00d0f2";

	protected function _initialize(){
		//session不存在时，不允许直接访问
		if(!$_SESSION['admin_id'])
		{
			layout(false);
			$this->error('还没有登录，正在跳转到登录页',U('Index/index'));
		}
		
		//session存在时，不需要验证的权限
		$not_check = array(
		    'Admin/changepwd','System/index','System/index_show','System/cleancache','System/clearrubbish',//修改密码、系统首页、清理缓存、清理垃圾文件
			'ArticleCat/deloldimg','Article/deloldimg','Article/deloldbigimg','Article/deloldfile',//删除文章分类原图片、删除文章原图片、删除文章原大图片、删除文章原文件
			'GoodsCat/deloldimg',//删除商品分类原图片
		);
		
		//当前操作的请求                 模块名/方法名
		if(in_array(CONTROLLER_NAME.'/'.ACTION_NAME, $not_check))
		{
			return true;
		}
		
		$auth = new Auth();
		if(!$auth->check(CONTROLLER_NAME.'/'.ACTION_NAME,$_SESSION['admin_id']) and $_SESSION['a_group_id']!='1')
		{
			layout(false);
			echo '没有权限!';die();
			$this->error('没有权限');
		}
	}

    public function postUrl($url, $postData = false, $header = false) {
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //返回数据不直接输出
        curl_setopt($ch, CURLOPT_ENCODING, "gzip"); //指定gzip压缩
        if(!empty($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        if(substr($url, 0, 5) == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    //SSL 报错时使用
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    //SSL 报错时使用
        }
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch,CURLOPT_COOKIEFILE, $this->lastCookieFile); //使用提交后得到的cookie数据
        if(!empty($postData)) {
            curl_setopt($ch,CURLOPT_POST, 1);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $postData);
        }
        try {
            $content = curl_exec($ch); //执行并存储结果
        } catch (\Exception $e) {
            $this->_log($e->getMessage());
        }
        curl_close($ch);
        return json_decode($content,true);
    }

}