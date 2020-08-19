<?php
/**
 * 拉新活动接口
 */
namespace App\Controller;
use App\Common\Controller\AuthController;

class JFLotteryController extends AuthController
{

    public function getOne()
    {
        // 实例化模型
        $Rookie = new \Common\Model\JFLotteryModel();
        $JFLotteryRecord = new \Common\Model\JFLotteryRecordModel();
        // 如果id变量存在
        if (trim(I("POST.id"))) {
            // 如果存在活动ID
            $id = I('POST.id');
            $data = $Rookie->where("id = $id")->find();
        } else {
            // 如果id为空，则查询最近未开奖
            $where["open_time"] = array('between',date("Y-m-d H:i:s").','.date("Y-m-d 00:00:00",strtotime("+100 day")));
            $data = $Rookie->where($where)->order('open_time asc')->find();
        }
        unset($data["num"]);

        if ($data == null) {
            // 未查询到数据
            $res = [
                'code'=> 200,
                'msg'=>"未查询到数据"
            ];
        } else {
            $rdata = $JFLotteryRecord->where(array("l_id" => $data["id"] ))->select();
            $data["hasNum"] = array();
            if (count($rdata) > 0) {
                $i = 0;
                foreach($rdata as $rk => $rv) {
                    $data["hasNum"][$i] = $rv["dnum"];
                    $i++;
                }
            }

            // 查询成功
            $res = [
                'code'=> 200,
                'msg'=>'成功',
                'data'=>$data,
            ];
        }
        self::echoJson($res);
    }

    public function getList()
    {
        // 实例化模型
        $Rookie = new \Common\Model\JFLotteryModel();

        $where = array();
        $desc = $_REQUEST["desc"];

        if($desc ==  "today") {
            $where["open_time"] = array('between',date("Y-m-d 00:00:00").','.date("Y-m-d H:i:s"));
        } else {
            $where["open_time"] = array('between',date("Y-m-d 00:00:00",strtotime("-1 day")).','.date("Y-m-d 23:59:59",strtotime("-1 day")));
        }

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

    public function add() {
        // 实例化Model类
        $JFLotteryRecord = new \Common\Model\JFLotteryRecordModel();
        $Rookie = new \Common\Model\JFLotteryModel();
        $User = new \Common\Model\UserModel();
        $UserPointRecord =new \Common\Model\UserPointRecordModel();

        $token = $_REQUEST["token"];
        $id = $_REQUEST["id"];
        $dnum =  $_REQUEST["dnum"] > 0 ? $_REQUEST["dnum"] : 0;

        if(isset($token)) {
            $res_token = $User->checkToken($token);
            if ($res_token['code'] != 0) {
                // 用户身份不合法
                self::echoJson($res_token);
            } else {
                // 获取用户ID
                $uid = $res_token['uid'];
            }
            //$uid = 1;

            if ($id) {
                $data = $Rookie->where("id = $id")->find();
                if ($data === null) {
                    self::echoJson(array( 'code'=> 404, 'msg'=>"未查询到抽奖活动"));
                }
            } else {
                self::echoJson(array( 'code'=> 500, 'msg'=>"未查询到抽奖活动"));
            }
            $rdata = $JFLotteryRecord->where(array("l_id" => $id,"userid" =>$uid ))->find();
            if(count($rdata) > 0) {
                self::echoJson(array( 'code'=> 500, 'msg'=>"用户已经有抽奖记录了，请等待开奖"));
            }

            $drdata = $JFLotteryRecord->where(array("l_id" => $id,"dnum" =>$dnum ))->find();
            if(count($drdata) > 0) {
                self::echoJson(array( 'code'=> 500, 'msg'=>"该位置已经坐满"));
            }


            //扣取积分.
            $needjf = $data["needjf"];
            $pointRecord = $UserPointRecord->where(array("user_id" => $uid))->find();
            if($pointRecord["all_point"] < $needjf) {
                self::echoJson(array( 'code'=> 500, 'msg'=>"你当前积分只有".$pointRecord["all_point"].",无法参与抽奖活动"));
            } else {
                // 组装数据
                $udata = [
                    'all_point'          =>( $pointRecord["all_point"] - $needjf) ,
                ];
                // 入库
                $UserPointRecord->where(array("user_id" =>$uid ))->save($udata);
            }


            if($dnum <= 0) {
                self::echoJson(array( 'code'=> 500, 'msg'=>"系统出错1"));
            }

            // 组装数据
            $data = [
                'l_id'          => $id,
                'userid'          => $uid,
                'dnum'          => $dnum,
                'addtime'      => date("Y-m-d H:i:s"),
            ];

            // 入库
            $res = $JFLotteryRecord->add($data);
            if ($res) {
                self::echoJson(array( 'code'=> 200, 'msg'=>"success"));
            } else {
                self::echoJson(array( 'code'=> 500, 'msg'=>"系统出错"));
            }
        }
        $res = [
            'code'=> 500,
            'msg'=>"未查询到用户"
        ];
        self::echoJson($res);
    }

    public function result() {
        // 实例化Model类
        $JFLotteryRecord = new \Common\Model\JFLotteryRecordModel();
        $Rookie = new \Common\Model\JFLotteryModel();
        $User = new \Common\Model\UserModel();
        $UserPointRecord =new \Common\Model\UserPointRecordModel();

        $token = $_REQUEST["token"];
        if(isset($token)) {
            $res_token = $User->checkToken($token);
            if ($res_token['code'] != 0) {
                // 用户身份不合法
                self::echoJson($res_token);
            } else {
                // 获取用户ID
                $uid = $res_token['uid'];
            }
            //$uid = 1;

            $id = $_REQUEST["id"];
            if ($id) {
                $data = $Rookie->where("id = $id")->find();
                if ($data === null) {
                    self::echoJson(array( 'code'=> 404, 'msg'=>"未查询到抽奖活动"));
                }
            } else {
                self::echoJson(array( 'code'=> 500, 'msg'=>"未查询到抽奖活动"));
            }

            $rdata = $JFLotteryRecord->where(array("l_id" => $id,"userid" =>$uid ))->find();
            if ($rdata === null) {
                self::echoJson(array( 'code'=> 404, 'msg'=>"未查询到参加抽奖活动"));
            }

            if($rdata["dnum"] == $data["num"]) {
                $status = 1;
            } else {
                $status = 0;
                //未中奖，返积分.
                $backjf = $data["backjf"];
                $pointRecord = $UserPointRecord->where(array("user_id" => $uid))->find();
                // 组装数据
                $udata = [
                    'all_point'          =>( $pointRecord["all_point"] +  $backjf) ,
                ];
                // 入库
                $UserPointRecord->where(array("user_id" =>$uid ))->save($udata);
            }

            // 组装数据
            $data = [
                'isLottery' => $status
            ];
            // 入库
             $JFLotteryRecord->where(array("l_id" => $id,"userid" =>$uid ))->save($data);
             self::echoJson(array( 'code'=> 200, 'msg'=>"success","data" => array("isLottery" => $status)));

        }
        $res = [
            'code'=> 500,
            'msg'=>"未查询到用户"
        ];
        self::echoJson($res);
    }

    public function address() {
        // 实例化Model类
        $JFLotteryRecord = new \Common\Model\JFLotteryRecordModel();
        $Rookie = new \Common\Model\JFLotteryModel();
        $User = new \Common\Model\UserModel();

        $token = $_REQUEST["token"];
        if(isset($token)) {
            $res_token = $User->checkToken($token);
            if ($res_token['code'] != 0) {
                // 用户身份不合法
                self::echoJson($res_token);
            } else {
                // 获取用户ID
                $uid = $res_token['uid'];
            }
            //$uid = 1;

            $id = $_REQUEST["id"];
            if ($id) {
                $data = $Rookie->where("id = $id")->find();
                if ($data === null) {
                    self::echoJson(array( 'code'=> 404, 'msg'=>"未查询到抽奖活动"));
                }
            } else {
                self::echoJson(array( 'code'=> 500, 'msg'=>"未查询到抽奖活动"));
            }

            $rdata = $JFLotteryRecord->where(array("l_id" => $id,"userid" =>$uid ))->find();
            if ($rdata == null) {
                self::echoJson(array( 'code'=> 404, 'msg'=>"未查询到参加抽奖活动"));
            }
            if ($rdata["orderstatus"] > 0) {
                self::echoJson(array( 'code'=> 500, 'msg'=>"订单已经发货"));
            }
            // 组装数据
            $data = [
                'receiver'          => @$_REQUEST["receiver"],
                'phone'          => @$_REQUEST["phone"],
                'area'          => @$_REQUEST["area"],
                'address'          => @$_REQUEST["address"],
                'tag'          => @$_REQUEST["tag"],
                'isDefault'          => @$_REQUEST["isDefault"],
            ];

            // 入库
            $res = $JFLotteryRecord->where(array("l_id" => $id,"userid" =>$uid ))->save($data);
            if ($res) {
                self::echoJson(array( 'code'=> 200, 'msg'=>"success"));
            } else {
                self::echoJson(array( 'code'=> 500, 'msg'=>"请重试"));
            }
        }
        $res = [
            'code'=> 500,
            'msg'=>"未查询到用户"
        ];
        self::echoJson($res);
    }

    public function getLog()
    {
        // 实例化模型
        $JFLotteryRecord = new \Common\Model\JFLotteryRecordModel();
        $Rookie = new \Common\Model\JFLotteryModel();
        $User = new \Common\Model\UserModel();

        $token = $_REQUEST["token"];
        $id = $_REQUEST["id"];
        $status = isset($_REQUEST["status"]) ? $_REQUEST["status"] : -1;

        if(isset($token)) {
            $res_token = $User->checkToken($token);
            if ($res_token['code'] != 0) {
                // 用户身份不合法
                self::echoJson($res_token);
            } else {
                // 获取用户ID
                $uid = $res_token['uid'];
            }
            //$uid = 1;
        } else {
            $res = [
                'code'=> 500,
                'msg'=>"未查询到用户"
            ];
            self::echoJson($res);
        }

        $where = array();
        $where["userid"] = $uid;
        if(intval($id) > 0) {
            $where["id"] = $id;
        }
        if($status >= 0) {
            $where["status"] = $status;
        }
        $data = $JFLotteryRecord->where($where)->select();
        if ($data === null) {
            // 未查询到数据
            $res = [
                'code'=> 200,
                'msg'=>"未查询到数据"
            ];
        } else {
            foreach($data as $key => $v) {
                $item = $Rookie->where(array("id" => $v["l_id"]))->find();
                $data[$key]["name"] = $item["name"];
                $data[$key]["num"] = $item["num"] ;
                $data[$key]["open_time"] = $item["open_time"] ;
                $data[$key]["goodsimg"] = $item["goodsimg"] ;
                $data[$key]["needjf"] = $item["needjf"] ;
                if($v["num"] == $item["dnum"]) {
                    $data[$key]["isLottery"] = 1;
                } else {
                    $data[$key]["isLottery"] = 0;
                }
            }
            // 查询成功
            $res = [
                'code'=>200,
                'msg'=>'成功',
                'data'=>$data,
            ];
        }
        self::echoJson($res);
    }

    public function done() {
        // 实例化Model类
        $JFLotteryRecord = new \Common\Model\JFLotteryRecordModel();
        $Rookie = new \Common\Model\JFLotteryModel();
        $User = new \Common\Model\UserModel();

        $token = $_REQUEST["token"];
        $id = $_REQUEST["id"];
        if(isset($token)) {
            $res_token = $User->checkToken($token);
            if ($res_token['code'] != 0) {
                // 用户身份不合法
                self::echoJson($res_token);
            } else {
                // 获取用户ID
                $uid = $res_token['uid'];
            }
            //$uid = 1;

            if ($id) {
                $data = $Rookie->where("id = $id")->find();
                if ($data === null) {
                    self::echoJson(array( 'code'=> 404, 'msg'=>"未查询到抽奖活动"));
                }
            } else {
                self::echoJson(array( 'code'=> 500, 'msg'=>"未查询到抽奖活动"));
            }

            $rdata = $JFLotteryRecord->where(array("l_id" => $id,"userid" =>$uid ))->find();
            if ($rdata === null) {
                self::echoJson(array( 'code'=> 404, 'msg'=>"未查询到参加抽奖活动"));
            }

            if ($rdata["orderstatus"] != 2) {
                self::echoJson(array( 'code'=> 500, 'msg'=>"订单未发货或者已完成"));
            }

            // 组装数据
            $data = [
                'orderstatus' => 3
            ];
            // 入库
            $res = $JFLotteryRecord->where(array("l_id" => $id,"userid" =>$uid ))->save($data);
            if ($res) {
                self::echoJson(array( 'code'=> 200, 'msg'=>"success"));
            } else {
                self::echoJson(array( 'code'=> 500, 'msg'=>"请重试"));
            }
        }
        $res = [
            'code'=> 500,
            'msg'=>"未查询到用户"
        ];
        self::echoJson($res);
    }


    private static function echoJson($res) {
        echo json_encode($res, JSON_UNESCAPED_UNICODE); exit;
    }

}
