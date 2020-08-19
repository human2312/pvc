<?php
/**
 * 拉新活动接口
 */
namespace App\Controller;
use App\Common\Controller\AuthController;

class DmoneyController extends AuthController
{

    public function getToken()
    {
        $User = new \Common\Model\UserModel();
        $token = $_REQUEST["token"];
        if (!isset($token)) {
            $res = [
                'code' => 500,
                'msg' => "未查询到用户"
            ];
            self::echoJson($res);
        }
        $res_token = $User->checkToken($token);

        if ($res_token['code'] != 0) {
            // 用户身份不合法
            self::echoJson($res_token);
        } else {
            // 获取用户ID
            $uid = $res_token['uid'];
        }
        return $uid;
    }


    public function DMoneyList()
    {
        // 实例化模型
        $Rookie = new \Common\Model\DmoneyConfigModel();
        $where = array();
        $data = $Rookie->where($where)->select();
        if ($data === null) {
            // 未查询到数据
            $res = [
                'code'=> 200,
                'msg'=>"未查询到数据"
            ];
        } else {
            // 查询成功
            $res = [
                'code'=>200,
                'msg'=>'成功',
                'data'=>$data,
            ];
        }
        self::echoJson($res);
    }

    public function Account()
    {
        $JFLottery = new \Common\Model\DmoneyUserModel();
        $uid = self::getToken();
        $where = array("user_id" => $uid);
        $data = $JFLottery->where($where)->select();
        if ($data === null) {
            // 未查询到数据
            $res = [
                'code'=> 200,
                'msg'=>"未查询到数据"
            ];
        } else {
            // 查询成功
            $res = [
                'code'=>200,
                'msg'=>'成功',
                'data'=>$data,
            ];
        }
        self::echoJson($res);
    }

    public function Jifen()
    {
        $User = new \Common\Model\UserModel();
        $uid = self::getToken();
        $pointRecord = $User->where(array("uid" => $uid))->find();
        if ($pointRecord === null) {
            // 未查询到数据
            $res = [
                'code'=> 200,
                'msg'=>"未查询到数据" ,
                'result'=>0
            ];
        } else {
            // 查询成功
            $res = [
                'code'=>200,
                'msg'=>'成功',
                'result'=>$pointRecord["jifen"],
            ];
        }
        self::echoJson($res);
    }

    public function getLog()
    {
        $JFLottery = new \Common\Model\DmoneyUserLogModel();
        $type = $_REQUEST["type"];

        $uid = self::getToken();
        $where["user_id"] = $uid;

        if(intval($type) > 0) {
            $where["u_type"] = $type;
        }

        $data = $JFLottery->where($where)->select();
        if ($data === null) {
            // 未查询到数据
            $res = [
                'code'=> 200,
                'msg'=>"未查询到数据"
            ];
        } else {
            // 查询成功
            $res = [
                'code'=>200,
                'msg'=>'成功',
                'data'=>$data,
            ];
        }
        self::echoJson($res);
    }

    public function recharge()
    {
        $JFLottery = new \Common\Model\DmoneyUserLogModel();
        $name = $_REQUEST["name"];
        $url = $_REQUEST["url"];
        $money = $_REQUEST["money"];

        $uid = self::getToken();

        // 组装数据
        $data = [
            'user_id'          => $uid,
            'name'          => $name,
            'url'          => $url,
            'money'          => $money,
            'u_type' => 1,
            'addtime'      => date("Y-m-d H:i:s"),
        ];

        // 入库
        $res = $JFLottery->add($data);

        if ($res) {
            self::echoJson(array( 'code'=> 200, 'msg'=>"success"));
        } else {
            self::echoJson(array( 'code'=> 500, 'msg'=>"系统出错"));
        }

    }

    public function cash()
    {
        $JFLottery = new \Common\Model\DmoneyUserLogModel();
        $name = $_REQUEST["name"];
        $url = $_REQUEST["url"];
        $money = $_REQUEST["money"];
        $fee = $_REQUEST["fee"];
        $pre_money = $_REQUEST["preMoney"];
        
        $uid = self::getToken();

        // 组装数据
        $data = [
            'user_id'          => $uid,
            'name'          => $name,
            'url'          => $url,
            'money'          => $money,
            'fee'          => $fee,
            'pre_money'          => $pre_money,
            'u_type' => 2,
            'addtime'      => date("Y-m-d H:i:s"),
        ];

        // 入库
        $res = $JFLottery->add($data);

        if ($res) {
            self::echoJson(array( 'code'=> 200, 'msg'=>"success"));
        } else {
            self::echoJson(array( 'code'=> 500, 'msg'=>"系统出错"));
        }

    }


    private static function echoJson($res) {
        echo json_encode($res, JSON_UNESCAPED_UNICODE); exit;
    }

}
