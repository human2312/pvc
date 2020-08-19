<?php
namespace App\Common\Controller;
use Think\Controller;

//权限认证
class AuthController extends Controller 
{
	public $ERROR_CODE_COMMON =array();                      // 公共返回码
	public $ERROR_CODE_COMMON_ZH =array();                   // 公共返回码中文描述
	public $ERROR_CODE_SMS =array();                         // 手机短信返回码
	public $ERROR_CODE_SMS_ZH =array();                      // 手机短信返回码中文描述
	public $ERROR_CODE_EMAIL =array();                       // 邮件返回码
	public $ERROR_CODE_EMAIL_ZH =array();                    // 邮件返回码中文描述
	public $ERROR_CODE_USER =array();                        // 用户管理返回码
	public $ERROR_CODE_USER_ZH =array();                     // 用户管理返回码中文描述
	public $ERROR_CODE_GOODS =array();                       // 商品管理返回码
	public $ERROR_CODE_GOODS_ZH =array();                    // 商品管理返回码中文描述
    public $HOSTURL = "http://daishou.web.html48.com";
	
	protected function _initialize()
	{
		// 返回码配置
		$this->ERROR_CODE_COMMON = json_decode(error_code_common,true);
		$this->ERROR_CODE_COMMON_ZH = json_decode(error_code_common_zh,true);
		$this->ERROR_CODE_SMS = json_decode(error_code_sms,true);
		$this->ERROR_CODE_SMS_ZH = json_decode(error_code_sms_zh,true);
		$this->ERROR_CODE_EMAIL = json_decode(error_code_email,true);
		$this->ERROR_CODE_EMAIL_ZH = json_decode(error_code_email_zh,true);
		$this->ERROR_CODE_USER = json_decode(error_code_user,true);
		$this->ERROR_CODE_USER_ZH = json_decode(error_code_user_zh,true);
		$this->ERROR_CODE_GOODS = json_decode(error_code_goods,true);
		$this->ERROR_CODE_GOODS_ZH = json_decode(error_code_goods_zh,true);
	}

	public function echoJson($res)
    {
        header('content-type:application/json');
        echo json_encode($res);
        exit;
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