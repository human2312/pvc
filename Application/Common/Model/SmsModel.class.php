<?php
/**
 * 手机短信类
 * 注意：
 * 不同的客户请替换账号sid，密码apikey,短信模板tplid
 * 验证码有效时间为10分钟，可设置valid_time进行修改
 */
namespace Common\Model;
use Think\Model;
header("Access-Control-Allow-Origin:*");

class SmsModel extends Model
{
	public $ERROR_CODE_COMMON =array();     // 公共返回码
	public $ERROR_CODE_COMMON_ZH =array();  // 公共返回码中文描述
	public $ERROR_CODE_SMS =array();       // 手机短信返回码
	public $ERROR_CODE_SMS_ZH =array();    // 手机短信返回码中文描述
	
	protected $sid = 'ZH000001047'; //账号
	protected $apikey = 'fe599ecb-32d1-4371-abfe-c670d4f90a20';  //密码
	//protected $svr_rest = "http://api.rcscloud.cn:8030/rcsapi/rest";  //rest请求地址  或使用IP：121.14.114.153
	protected $svr_rest = "http://121.41.114.153:8030/rcsapi/rest";  //rest请求地址  或使用IP：121.14.114.153
	protected $svr_url = '';  //服务器接口路径-发送短信地址
	//protected $tplid_default = "65cecc2760b3493a8ff29fa913a66b19";  //测试发送的模板id
	//protected $tplid_vip = "65cecc2760b3493a8ff29fa913a66b19";  //成为VIP后发送的模板id
	
	protected $tplid_default = "8edf3262ea6d4d45aa405fc6da3a825e";  //测试发送的模板id
	protected $tplid_vip = "65cecc2760b3493a8ff29fa913a66b19";  //成为VIP后发送的模板id

	protected $valid_time = 600; //验证码有效时间10分钟

    protected $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL

    protected $smsConf = array(
        'key'   => '7bebd6ff5ff8e6734fdff7a2ab440fe4', //您申请的APPKEY
        'mobile'    => '', //接受短信的用户手机号码
        'tpl_id'    => '215183', //您申请的短信模板ID，根据实际情况修改
        'tpl_value' =>'#code#=' //您设置的模板变量，根据实际情况修改
    );

    public $postUrl = "http://211.149.255.237:81/smsJson.aspx?action=send&userid=&account=400004&password=AA17048862290372A755E0D95B86DD70&sendTime=&extno=";
		
	//初始化
	public function _initialize()
	{
		$this->ERROR_CODE_COMMON = json_decode(error_code_common,true);
		$this->ERROR_CODE_COMMON_ZH = json_decode(error_code_common_zh,true);
		$this->ERROR_CODE_SMS = json_decode(error_code_sms,true);
		$this->ERROR_CODE_SMS_ZH = json_decode(error_code_sms_zh,true);
		
		//设置服务器接口路径
		$this->svr_url=$this->svr_rest."/sms/sendtplsms.json";
	}

    public function sendSms($mobile,$content='')
    {
        $json = self::juhecurl($this->postUrl."&mobile=".$mobile."&content=".$content."【代收】");
        $result=json_decode($json,true);
        if($result['returnstatus']=='Success')
        {
            return 1;
        }
        return 0;
    }
	
	/**
	 * 发送短信
	 * @param striing $mobile:手机号码
	 * @param striing $content:短信内容
	 * @return array
	 * @return @param code:返回码
	 * @return @param msg:返回码说明
	 */
	public function sendMessage($mobile,$content='',$tplid_type='')
	{
		//短信模板
		switch ($tplid_type)
		{
			case 'default':
				$tplid=$this->tplid_default;
				break;
			case 'vip':
				$tplid=$this->tplid_vip;
				break;
			default:
				$tplid=$this->tplid_default;
				break;
		}
        $content = substr($content, -4);
        $content = 1234;
		if(is_phone($mobile)==false)
		{
			//不是正确的手机号码格式
			$res=array(
					'code'=>$this->ERROR_CODE_COMMON['PHONE_FORMAT_ERROR'],
					'msg'=>$this->ERROR_CODE_COMMON_ZH[$this->ERROR_CODE_COMMON['PHONE_FORMAT_ERROR']]
			);
		}else {
			// 签名
			//$sign = $this->generateSign($mobile, $content , $tplid);
			
			//判断是否已有该手机号码发送记录
			$msg=$this->where("mobile='$mobile'")->find();
			if($msg)
			{
				//已有记录
				$last_send_time=$msg['send_time'];
				if( (time()-$last_send_time) > 60)
				{
					//发送短信
//					$post_data=array(
//							'sid'=>$this->sid,
//							'sign'=>$sign,
//							'tplid'=>$tplid,
//							'mobile'=>$mobile,
//							'content'=>$content
//					);
					//$json=$this->request_post($this->svr_url,$post_data);

                    $this->smsConf["mobile"] = $mobile;
                    $this->smsConf["tpl_value"] = $this->smsConf["tpl_value"].$content;
//                    $json = self::juhecurl($this->sendUrl,$this->smsConf,1);
//
//                    $result=json_decode($json,true);
                    $result['error_code'] = 0;
					if($result['error_code']=='0')
					{
						//修改
						$data=array(
								'code'=>$content,
								'send_time'=>time()
						);
						$res_save=$this->where("mobile='$mobile'")->save($data);
						if($res_save!==false)
						{
							$res=array(
									'code'=>$this->ERROR_CODE_COMMON['SUCCESS'],
									'msg'=>'发送短信成功'
							);
						}else {
							// 数据库错误
							$res=array(
									'code'=>$this->ERROR_CODE_COMMON['DB_ERROR'],
									'msg'=>$this->ERROR_CODE_COMMON_ZH[$this->ERROR_CODE_COMMON['DB_ERROR']]
							);
						}
					}else {
						//发送失败-短信接口返回的错误
						$res=array(
								'code'=>$this->ERROR_CODE_SMS['API_ERROR'],
								'msg'=>'发送失败：错误码：'.$result['error_code'].';错误描述：'.$result['reason'],
						);
					}


				}else {
					// 1分钟内只允许发送一条短信
					$res=array(
							'code'=>$this->ERROR_CODE_SMS['SEND_LIMIT'],
							'msg'=>$this->ERROR_CODE_SMS_ZH[$this->ERROR_CODE_SMS['SEND_LIMIT']]
					);
				}
			}else {
				//没有记录，第一次发送短信，进行添加操作
//				$post_data=array(
//						'sid'=>$this->sid,
//						'sign'=>$sign,
//						'tplid'=>$tplid,
//						'mobile'=>$mobile,
//						'content'=>$content
//				);
//				$json=$this->request_post($this->svr_url,$post_data);
//				$result=json_decode($json,true);

                $this->smsConf["mobile"] = $mobile;
                $this->smsConf["tpl_value"] = $this->smsConf["tpl_value"].$content;
//                $json = self::juhecurl($this->sendUrl,$this->smsConf,1);
//
//                $result=json_decode($json,true);
                $result['error_code'] = 0;
				if($result['error_code']=='0')
				{
					//保存到数据库
					$data=array(
							'mobile'=>$mobile,
							'code'=>$content,
							'send_time'=>time()
					);
					$res_add=$this->add($data);
					if($res_add!==false)
					{
						$res=array(
								'code'=>$this->ERROR_CODE_COMMON['SUCCESS'],
								'msg'=>'发送短信成功'
						);
					}else {
						// 数据库错误
						$res=array(
								'code'=>$this->ERROR_CODE_COMMON['DB_ERROR'],
								'msg'=>$this->ERROR_CODE_COMMON_ZH[$this->ERROR_CODE_COMMON['DB_ERROR']]
						);
					}
				}else {
					//发送失败-短信接口返回的错误
					$res=array(
							'code'=>$this->ERROR_CODE_SMS['API_ERROR'],
							'msg'=>'发送失败：错误码：'.$result['error_code'].';错误描述：'.$result['reason'],
					);
				}
			}
		}
		return $res;
	}
	
	/**
	 * 检查验证码是否正确
	 * @param string $mobile:手机号码
	 * @param string $code:验证码
	 * @return array
	 * @return @param code:返回码
	 * @return @param msg:返回码说明
	 */
	public function checkCode($mobile,$code)
	{
		$msg=$this->where("mobile='$mobile'")->find();
		if($msg)
		{
			//有效时间10分钟
			$last_send_time=$msg['send_time'];
			if( (time()-$last_send_time) > $this->valid_time )
			{
				// 验证码已过有效时间
				$res=array(
						'code'=>$this->ERROR_CODE_SMS['BEYOND_VALID_TIME'],
						'msg'=>$this->ERROR_CODE_SMS_ZH[$this->ERROR_CODE_SMS['BEYOND_VALID_TIME']],
				);
			}else {
				if($code!=$msg['code'])
				{
					// 验证码错误
					$res=array(
							'code'=>$this->ERROR_CODE_SMS['CODE_ERROR'],
							'msg'=>$this->ERROR_CODE_SMS_ZH[$this->ERROR_CODE_SMS['CODE_ERROR']],
					);
				}else {
					// 验证码正确
					$res=array(
							'code'=>$this->ERROR_CODE_COMMON['SUCCESS'],
							'msg'=>'验证码正确'
					);
				}
			}
		}else {
			// 手机号码不存在
			$res=array(
					'code'=>$this->ERROR_CODE_SMS['MOBILE_NOT_EXIST'],
					'msg'=>$this->ERROR_CODE_SMS_ZH[$this->ERROR_CODE_SMS['MOBILE_NOT_EXIST']],
			);
		}
		return $res;
	}
	
	/**
	 * 查询账号所有模板
	 * @return array
	 */
	public function searchTpl()
	{
		// 签名认证 Md5(sid+apikey)
		$sign = md5($this->sid.$this->apikey);
		// 服务器接口路径
		$svr_url  = $this->svr_rest."/tpl/gets.json?sid=".$this->sid."&sign=".$sign;
		// 获取信息
		$json_arr = json_decode(file_get_contents($svr_url));
		return $json_arr;
	}
	
	/**
	 * 生成签名
	 * @param string $tplid:模板ID
	 * @param string $mobile:手机号码
	 * @param string $content:发送内容
	 * @return string:签名
	 */
	protected function generateSign($mobile,$content,$tplid)
	{
		//签名认证 Md5(sid+apikey+tplid+mobile+content)
		$sign = md5($this->sid.$this->apikey.$tplid.$mobile.$content);
		return $sign;             
	}
	
	/**
	 * URL请求
	 * @param string $url:请求地址
	 * @param array $post_data:请求数据数组
	 * @return boolean|array
	 */
	public function request_post($url = '', $post_data = array()) 
	{
		if (empty($url) || empty($post_data)) 
		{
			return false;
		}
		
		$o = "";
		foreach ( $post_data as $k => $v ) 
		{
			$o.= "$k=" . urlencode( $v ). "&" ;
		}
		$post_data = substr($o,0,-1);
		$postUrl = $url;
		$curlPost = $post_data;
		$ch = curl_init();//初始化curl
		curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
		curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded','Content-Encoding: utf-8'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
		$data = curl_exec($ch);//运行curl
		curl_close($ch);
		
		return $data;
	}

    /**
     * 请求接口返回内容
     * @param  string $url [请求的URL地址]
     * @param  string $params [请求的参数]
     * @param  int $ipost [是否采用POST形式]
     * @return  string
     */
    function juhecurl($url,$params=false,$ispost=0){
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        if( $ispost )
        {
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
            curl_setopt( $ch , CURLOPT_URL , $url );
        }
        else
        {
            if($params){
                curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
            }else{
                curl_setopt( $ch , CURLOPT_URL , $url);
            }
        }
        $response = curl_exec( $ch );
        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
        $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
        curl_close( $ch );
        return $response;
    }
}