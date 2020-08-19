<?php
/**
 * 牧场
 */
namespace App\Controller;

use App\Common\Controller\AuthController;

class MuchangController extends AuthController
{
    public $url = "http://muchang.api.html48.com";

    public function getToken()
    {
        $User = new \Common\Model\UserModel();
        $token = trim($_REQUEST["token"]);
        if (!isset($token)) {
            $res = array(
                'code' => 500,
                'msg' => "未查询到用户"
            );
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
        //$uid = 12;
        return $uid;
    }

    public function index()
    {
        $uid = self::getToken();
        $Muchang = new \Common\Model\MuchangModel();
        $Config = new \Common\Model\MuchangConfigModel();
        $res = $Muchang->where(array("uid" => $uid))->find();
        $configInfo = $Config->find();
        $gonggao = $configInfo["gonggao"];
        $jsClass = array(
            array(
                "mt" =>"m0",
                "class" =>"bird1",
            ),
            array(
                "mt" =>"m30",
                "class" =>"bird2",
            ),
            array(
                "mt" =>"m50",
                "class" =>"bird3",
            ),
            array(
                "mt" =>"m20",
                "class" =>"bird4",
            ),
            array(
                "mt" =>"m60",
                "class" =>"bird5",
            ),
            array(
                "mt" =>"m60",
                "class" =>"bird6",
            ),
            array(
                "mt" =>"m100",
                "class" =>"bird7",
            ),
            array(
                "mt" =>"m120",
                "class" =>"bird8",
            ),
            array(
                "mt" =>"m100",
                "class" =>"bird9",
            ),
            array(
                "mt" =>"m60",
                "class" =>"bird10",
            ),
            array(
                "mt" =>"m50",
                "class" =>"bird11",
            )
        );

        if(count($res) > 0) {
            if($res["ji"] >= 11) {
                $res["jiclass"] = $jsClass;
            } else {
                for ($i=0;$i < $res["ji"];$i++) {
                    //$r = rand(0,count($jsClass) - 1);
                    $r = $i;
                    $res["jiclass"][$i] = $jsClass[$r];
                    //unset($jsClass[$r]);
                    //$jsClass = array_values($jsClass);
                }
            }
        }

        $res["googgao"] = $gonggao;

        self::echoJson(array("code" => 0,"data" => $res,"msg" => "success"));
    }

    public function status()
    {
        $uid = self::getToken();
        $Muchang = new \Common\Model\MuchangModel();

        $status = $_REQUEST["status"];

        if($status == 1) {
            $data2 = array(
                "isreg" => 1,
            );
        }
        if($status == 2) {
            $data2 = array(
                "islogin" => 1,
            );
        }
        if($status == 3) {
            $data2 = array(
                "isysd" => 0,
                "isynd" => 0
            );
        }
        if($status == 4) {
            $data2 = array(
                "isysd" => 0,
                "isynd" => 0
            );
        }
        if($data2 != null) {
            // 入库
            $Muchang->where("uid = $uid")->save($data2);
        }
        self::echoJson(array("code" => 0,"data" => array(),"msg" => "success"));
    }

    //偷蛋
    public function toudan()
    {
        $uid = self::getToken();
        $tuid = $_REQUEST["tuid"];
        $MuchangLog = new \Common\Model\MuchangLogModel();
        $Muchang = new \Common\Model\MuchangModel();
        $mcInfo = $Muchang->where(array("uid" => $uid))->find();
        $tmcInfo = $Muchang->where(array("uid"=>$tuid))->find();
        $Config = new \Common\Model\MuchangConfigModel();
        $configInfo = $Config->find();
        if(@$tmcInfo["dog"] == 1) {
            self::echoJson(array("code" => 100,"data" => array(),"msg" => "该牧场有哈士奇守护无法偷蛋"));
        }

        if(@$tmcInfo["undan"] > 0) {
            $tlog = $MuchangLog->where(array("type = 3 and tuid = $tuid and addtime >= '".date("Y-m-d 00:00:00")."' and addtime <='" .date("Y-m-d 23:59:59")."'"))->select();
            $tdan = count($tlog);
            if($tdan > 0) {
                self::echoJson(array("code" => 100,"data" => array(),"msg" => "该牧场今天可偷蛋次数已用光"));
            }
        } else {
            self::echoJson(array("code" => 100,"data" => array(),"msg" => "该牧场无蛋可偷"));
        }

        //拿到用户当天偷蛋数
//        if($mcInfo["ji"] < 20) {
//            self::echoJson(array("code" => 100,"data" => array(),"msg" => "饲养满20才能偷蛋喔"));
//        }
        $log = $MuchangLog->where(array("type = 3 and uid = $uid and addtime >= '".date("Y-m-d 00:00:00")."' and addtime <='" .date("Y-m-d 23:59:59")."'"))->select();
        $dan = count($log);
        if($mcInfo["ji"] < 20 && $dan >= 1) {
            self::echoJson(array("code" => 100,"data" => array(),"msg" => "你当天偷蛋数已满"));
        }
        if($mcInfo["ji"] < 50 && $dan > 5) {
            self::echoJson(array("code" => 100,"data" => array(),"msg" => "你当天偷蛋数已满"));
        }
        if($mcInfo["ji"] < 100 && $dan > 10) {
            self::echoJson(array("code" => 100,"data" => array(),"msg" => "你当天偷蛋数已满"));
        }
        if($mcInfo["ji"] < 300 && $dan > 30) {
            self::echoJson(array("code" => 100,"data" => array(),"msg" => "你当天偷蛋数已满"));
        }
        if($mcInfo["ji"] >= 300 && $dan > 100) {
            self::echoJson(array("code" => 100,"data" => array(),"msg" => "你当天偷蛋数已满"));
        }


        //开始偷蛋
        $toudan =floor($tmcInfo["undan"] * ( $configInfo["toudan"]/ 10));

        if($toudan <= 0) {
            self::echoJson(array("code" => 100,"data" => array(),"msg" => "该牧场剩余蛋数无法偷取"));
        }

        $Muchang->where(array("uid" =>$uid ))->save(array(
            "dan" => ($mcInfo["dan"] + $toudan)
        ));
        $Muchang->where(array("uid" =>$tuid ))->save(array(
            "undan" => ($tmcInfo["undan"] - $toudan)
        ));

        $MuchangLog->add(array(
            "uid" => $uid,
            "tuid" => $tuid,
            "type" => 3,
            "dan" => $toudan,
            "remark" => "偷取了".$toudan."个蛋",
            "addtime" => date("Y-m-d H:i:s")
        ));

        self::echoJson(array("code" => 0,"data" => array(),"msg" =>  "偷取了".$toudan."个蛋"));
    }

    //收蛋
    public function getdan()
    {
        $uid = self::getToken();
        $Muchang = new \Common\Model\MuchangModel();
        $MuchangLog = new \Common\Model\MuchangLogModel();

        $res = $Muchang->where(array("uid" => $uid))->find();
        if(@$res["undan"] <= 0) {
            self::echoJson(array("code" => 100,"data" => array(),"msg" => "你可以收蛋数为0"));
        }

        if(count($res) > 0) {
            $Muchang->where(array("uid" => $uid))->save(array("dan" => ($res["dan"] + $res["undan"]),"undan" => 0));
            $MuchangLog->add(array(
                "uid" => $uid,
                "tuid" => 0,
                "type" => 2,
                "dan" => $res["undan"],
                "remark" => "你收取了".$res["undan"]."个蛋",
                "addtime" => date("Y-m-d H:i:s")
            ));

        }
        self::echoJson(array("code" => 0,"data" => $Muchang->where(array("uid" => $uid))->find(),"msg" => "你收取了".$res["undan"]."个蛋"));
    }

    //喂粮
    public function kouliang()
    {
        $uid = self::getToken();
        $Muchang = new \Common\Model\MuchangModel();
        $MuchangLog = new \Common\Model\MuchangLogModel();

        $res = $Muchang->where(array("uid" => $uid))->find();
        if(count($res) > 0) {
            if($res["kouliang"] <= 0) {
                self::echoJson(array("code" => 600,"data" => $res,"msg" => "剩余口粮不足"));
            }
            //今天已经喂粮多少次
            $tlog = $MuchangLog->where(array("type = 1 and uid = $uid and addtime >= '".date("Y-m-d 00:00:00")."' and addtime <='" .date("Y-m-d 23:59:59")."'"))->select();
            $times = 0;
            if(count($tlog) > 0 ) {
                foreach ($tlog as $k => $v) {
                    $times += $v["kouliang"];
                }
            }
            //开始喂养
            $need = $res["ji"] - $times;
            if($need <= 0) {
                self::echoJson(array("code" => 600,"data" => $res,"msg" => "无需喂养"));
            }
            if($need > $res["kouliang"]) {
                $need = $res["kouliang"];
            }
            $Muchang->where(array("uid" => $uid))->save(array("kouliang" => ($res["kouliang"] - $need)));

            $MuchangLog->add(array(
                "uid" => $uid,
                "tuid" => 0,
                "type" => 1,
                "kouliang" => $need,
                "remark" => "你喂养了".$need."口粮",
                "addtime" => date("Y-m-d H:i:s")
            ));

            self::echoJson(array("code" => 0,"data" => $Muchang->where(array("uid" => $uid))->find(),"msg" => "你喂养了".$need."口粮"));

        }
        self::echoJson(array("code" => 600,"data" => $res,"msg" => "牧场没有动物需要喂养"));
    }

    public function getGoods()
    {
        self::getToken();
        // 实例化Model类
        $MuchangGoods = new \Common\Model\MuchangGoodsModel();
        // 查询数据
        $data = $MuchangGoods->order('id desc')->select();
        self::echoJson(array("code" => 0,"data" => $data,"msg" => "success"));
    }

    public function buyGoods()
    {
        $uid = self::getToken();
        $goodsId = $_REQUEST["goodsId"];
        if(intval($goodsId) <= 0) {
            self::echoJson(array("code" => 600,"data" => array(),"msg" => "商品不存在"));
        }
        $User=new \Common\Model\UserModel();
        $MuchangGoods = new \Common\Model\MuchangGoodsModel();
        $MuchangOrder = new \Common\Model\MuchangOrderModel();
        $MuchangLog = new \Common\Model\MuchangLogModel();
        $Muchang = new \Common\Model\MuchangModel();
        $mcInfo = $Muchang->where(array("uid" => $uid))->find();
        $udata = $MuchangGoods->where(array("id" => $goodsId))->find();
        if($udata["price"] > ($mcInfo["jinbi"]+$mcInfo["zengsong"])) {
            self::echoJson(array("code" => 601,"data" => array(),"msg" => "你剩余金币不足"));
        }
        //更新金币
        if($mcInfo["zengsong"] >= $udata["price"]) {
            $udata1 = array(
                'zengsong'          => ($mcInfo["zengsong"] - $udata["price"]) ,
            );
        } else {
            $udata1 = array(
                'zengsong'  => 0,
                'jinbi'     =>(($mcInfo["jinbi"]+$mcInfo["zengsong"]) - $udata["price"]) ,
            );
        }

        // 入库
        $Muchang->where(array("uid" =>$uid ))->save($udata1);
        //插入购买记录
        // 组装数据
        $data = array(
            'uid' => $uid,
            'goods_id' => $goodsId,
            'price' => $udata["price"],
            'status' => 1,
            'addtime' => date("Y-m-d H:i:s")
        );
        // 入库
        $MuchangOrder->add($data);
        //新增 商品类型 1是动物 2是口粮 3是哈士奇
        if($udata["goods_type"] == 1) {
            $Muchang->where(array("uid" =>$uid ))->save(array(
                "ji" => ($mcInfo["ji"] + $udata["num"])
            ));
            $MuchangLog->add(array(
                "uid" => $uid,
                "type" => 4,
                "tuid" => 0,
                "ji" => $udata["num"],
                "jinbi" => "-".$udata["price"],
                "remark" => "购买了".$udata["num"]."个动物",
                "addtime" => date("Y-m-d H:i:s")
            ));
        }
        if($udata["goods_type"] == 2) {
            $Muchang->where(array("uid" =>$uid ))->save(array(
                "kouliang" => ($mcInfo["kouliang"] + $udata["num"])
            ));
            $MuchangLog->add(array(
                "uid" => $uid,
                "type" => 4,
                "tuid" => 0,
                "kouliang" => $udata["num"],
                "jinbi" => "-".$udata["price"],
                "remark" => "购买了".$udata["num"]."包口粮",
                "addtime" => date("Y-m-d H:i:s")
            ));
        }
        if($udata["goods_type"] == 3) {
            if(intval($mcInfo["dog"]) <= 0) {
                $dogDate = date("Y-m-d H:m:s",strtotime("+30 days"));
            } else {
                if(strtotime($mcInfo["dogdate"]) > time()) {
                    self::echoJson(array("code" => 600,"data" => array(),"msg" => "你已购买哈士奇,无需重复购买"));
                    $dogDate = date("Y-m-d H:m:s",strtotime($mcInfo["dogdate"])+(86400*30));
                } else {
                    $dogDate = date("Y-m-d H:m:s",strtotime("+30 days"));
                }
            }

            $Muchang->where(array("uid" =>$uid ))->save(array(
                "dog" => 1,
                "dogdate" => $dogDate
            ));
            $MuchangLog->add(array(
                "uid" => $uid,
                "type" => 4,
                "tuid" => 0,
                "ji" => $udata["num"],
                "jinbi" => "-".$udata["price"],
                "remark" => "购买了".$udata["num"]."个哈士奇，有效期到".$dogDate,
                "addtime" => date("Y-m-d H:i:s")
            ));
        }
        self::echoJson(array("code" => 0,"data" => array(),"msg" => "success"));
    }

    //金币变动记录
    public function jinbiList()
    {
        $uid = self::getToken();
        $MuchangLog = new \Common\Model\MuchangLogModel();
        $Muchang = new \Common\Model\MuchangModel();
        $User=new \Common\Model\UserModel();
        $res = $Muchang->where(array("uid" => $uid))->find();



        // 查询数据
        $tlog = $MuchangLog->where(array(" (uid = ".$uid." or tuid = ".$uid.") "))->order('id desc')->select();

        $sum = 0;
        $today = 0;
        foreach ($tlog as $key => $val) {
            if($val["jinbi"] > 0) {
                $sum += $val["jinbi"];
                if(strtotime($val["addtime"]) > strtotime(date("Y-m-d 00:00:00")) && strtotime($val["addtime"]) < strtotime(date("Y-m-d 23:59:59"))) {
                    $today += $val["jinbi"];
                }
            }
            if(intval($val["tuid"]) > 0) {
                $msg=$User->getUserDetail($val["tuid"]);
                $tlog[$key]["nickname"] = $msg["detail"]["nickname"];
                $tlog[$key]["remark"] = $tlog[$key]["nickname"].$tlog[$key]["remark"];
            } else {
                $msg=$User->getUserDetail($val["uid"]);
                $tlog[$key]["nickname"] = $msg["detail"]["nickname"];
                $tlog[$key]["remark"] = $tlog[$key]["nickname"].$tlog[$key]["remark"];
            }
        }

        self::echoJson(array("code" => 0,"data" => array(
            "jinbi" => @$res["jinbi"],
            "sum" => $sum,
            "today" => $today,
            "list" => $tlog
        ),"msg" => "success"));

    }

    public function zhuanzhuan()
    {
        self::getToken();
        $tuid = $_REQUEST["tuid"];
        $Muchang = new \Common\Model\MuchangModel();
        $User=new \Common\Model\UserModel();
        $Config = new \Common\Model\MuchangConfigModel();
        $configInfo = $Config->find();
        $gonggao = $configInfo["gonggao"];
        $where = "1 = 1";
        if($tuid > 0) {
            $where .= " and  uid = ".$tuid;
        }
        $mc = $Muchang->where($where)->order('undan desc')->select();

        $jsClass = array(
            array(
                "mt" =>"m0",
                "class" =>"bird1",
            ),
            array(
                "mt" =>"m30",
                "class" =>"bird2",
            ),
            array(
                "mt" =>"m50",
                "class" =>"bird3",
            ),
            array(
                "mt" =>"m20",
                "class" =>"bird4",
            ),
            array(
                "mt" =>"m60",
                "class" =>"bird5",
            ),
            array(
                "mt" =>"m60",
                "class" =>"bird6",
            ),
            array(
                "mt" =>"m100",
                "class" =>"bird7",
            ),
            array(
                "mt" =>"m120",
                "class" =>"bird8",
            ),
            array(
                "mt" =>"m100",
                "class" =>"bird9",
            ),
            array(
                "mt" =>"m60",
                "class" =>"bird10",
            ),
            array(
                "mt" =>"m50",
                "class" =>"bird11",
            )
        );

        if(count($mc) > 0) {
            foreach ($mc as $key => $val) {
                $msg=$User->getUserDetail($val["uid"]);
                $mc[$key]["nickname"] = $msg["detail"]["nickname"];
                $mc[$key]["avatar"] = $this->url.$msg["detail"]["avatar"];
                $mc[$key]["sex"] = $msg["detail"]["sex"];
                $mc[$key]["jiclass"] = array();
                if($val["ji"] >= 11) {
                    $mc[$key]["jiclass"] = $jsClass;
                } else {
                    for ($i=0;$i < $val["ji"];$i++) {
                        $r = $i;
                        $mc[$key]["jiclass"][$i] = $jsClass[$r];
                    }
                }
                $mc[$key]["gonggao"] = $gonggao;
            }
        }
        self::echoJson(array("code" => 0,"data" => $mc,"msg" => "success"));
    }

    //日产蛋列表
    public function daydanlist()
    {
        $uid = self::getToken();
        $MuchangLog = new \Common\Model\MuchangLogModel();

        $tlog = $MuchangLog->where(array("system = 1 and kouliang = 0 and tuid = ".$uid." "))->order('id desc')->select();

        $sum = 0;
        if(count($tlog) > 0) {
            foreach ($tlog as $key => $val) {
                $sum += $val["dan"];
            }
        }

        self::echoJson(array("code" => 0,"data" => array(
            "sum" => $sum,
            "list" => $tlog
        ),"msg" => "success"));

    }

    //总产蛋列表
    public function sumdanlist()
    {
        $uid = self::getToken();
        $MuchangLog = new \Common\Model\MuchangLogModel();

        $tlog = $MuchangLog->where(array("system = 5 and kouliang = 0 and tuid = ".$uid." "))->order('id desc')->select();

        self::echoJson(array("code" => 0,"data" => array(
            "sum" => @$tlog[0]["dan"],
            "list" => $tlog
        ),"msg" => "success"));

    }

    //交易中心
    public function jiaoyiList()
    {
        self::getToken();
        $Model = new \Common\Model\MuchangJiaoyiModel();
        $User=new \Common\Model\UserModel();

        $id = $_REQUEST["id"];
        $where = "status = 0";
        if($id > 0) {
            $where .= " and  id = ".$id;
        }

        $data = $Model->where($where)->order('id desc')->select();
        if(count($data) > 0) {
            foreach ($data as $key => $val) {
                $msg=$User->getUserDetail($val["uid"]);
                $data[$key]["nickname"] = $msg["detail"]["nickname"];
                $data[$key]["img"] = $this->url.$val["img"];
                $data[$key]["timg"] = $this->url.$val["timg"];
            }
        }
        self::echoJson(array("code" => 0,"data" => $data,"msg" => "success"));
    }

    public function addJiaoyi()
    {
        $uid = self::getToken();
        $img = $_REQUEST["img"];
        $num = $_REQUEST["num"];
        $phone = $_REQUEST["phone"];
        $price = $_REQUEST["price"];
        $wx = $_REQUEST["wx"];
        $Model = new \Common\Model\MuchangJiaoyiModel();
        $MuchangLog = new \Common\Model\MuchangLogModel();
        $Muchang = new \Common\Model\MuchangModel();
        $res = $Muchang->where(array("uid" => $uid))->find();

        if(count($res) > 0) {
            if($res["dan"] < $num) {
                self::echoJson(array("code" => 1001,"data" => array(),"msg" => "你出售蛋数已超"));
            }
            //$img为传入字符串
            $path = 'Public/Upload/User/avatar';
            $img = str_replace(" ","+",$img);
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $img, $result)){
                $type = $result[2];
                $new_file = $path."/";
                if(!file_exists($new_file)){
                    //检查是否有该文件夹，如果没有就创建，并给予最高权限
                    mkdir($new_file, 0777);
                }
                $new_file = $new_file.date("YmdHis").time().".{$type}";
                if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $img)))){
                    $imgs = '/'.$new_file;
                    $Muchang->where(array("uid" => $uid))->save(array(
                        "dan" => ($res["dan"] - $num)
                    ));
                    $Model->add(array(
                        "uid" => $uid,
                        "num" => $num,
                        "img" => $imgs,
                        "phone" => $phone,
                        "price" => $price,
                        "wx" => $wx,
                        "addtime" => date("Y-m-d H:i:s")
                    ));

                    $MuchangLog->add(array(
                        "uid" => $uid,
                        "tuid" => 0,
                        "type" => 6,
                        "dan" => $num,
                        "remark" => "交易挂售了".$num,
                        "addtime" => date("Y-m-d H:i:s")
                    ));
                    self::echoJson(array("code" => 0,"data" => array(),"msg" => "success"));
                }
            }
        }
        self::echoJson(array("code" => 1000,"data" => array(),"msg" => "系统错误"));

    }

    //发起支付
    public function payJiaoyi()
    {
        $uid = self::getToken();
        $img = $_REQUEST["timg"];
        $id = $_REQUEST["id"];
        $Model = new \Common\Model\MuchangJiaoyiModel();
        $MuchangLog = new \Common\Model\MuchangLogModel();
        //$img为传入字符串
        $path = 'Public/Upload/User/avatar';
        $img = str_replace(" ","+",$img);
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $img, $result)){
            $type = $result[2];
            $new_file = $path."/";
            if(!file_exists($new_file)){
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file, 0777);
            }
            $new_file = $new_file.date("YmdHis").time().".{$type}";
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $img)))){
                $data = $Model->where(array("id" => $id))->order('id desc')->find();
                if(count($data) > 0) {
                    $imgs = '/'.$new_file;
                    $Model->where(array("id" => $id))->save(array(
                        "status" => 2,
                        "timg" => $imgs,
                        "tuid" => $uid
                    ));
                    $MuchangLog->add(array(
                        "uid" => $uid,
                        "tuid" => $data["uid"],
                        "type" => 6,
                        "dan" => $data["dan"],
                        "remark" => "交易购买了".$data["dan"],
                        "addtime" => date("Y-m-d H:i:s")
                    ));
                    self::echoJson(array("code" => 0,"data" => array(),"msg" => "success"));
                }

            }
        }
        self::echoJson(array("code" => 1000,"data" => array(),"msg" => "系统错误"));
    }

    public function yaoqing()
    {
        $uid = self::getToken();
        $MuchangLog = new \Common\Model\MuchangLogModel();
        $User=new \Common\Model\UserModel();
        $tlog1 = $MuchangLog->where(array("type = 7 and uid = ".$uid))->select();
        $tlog2 = $MuchangLog->where(array("type = 8 and uid = ".$uid))->select();
        $today = $MuchangLog->where(array(" (type = 8 or type = 7) and uid = ".$uid." and addtime >= '".date("Y-m-d 00:00:00")."' and addtime <='" .date("Y-m-d 23:59:59")."'"))->select();

        $one = count($tlog1);
        $two = count($tlog2);
        $sum = $one + $two;
        $today = count($today);

        if($one > 0) {
            foreach ($tlog1 as $key => $val) {
                $msg=$User->getUserDetail($val["uid"]);
                $tlog1[$key]["nickname"] = $msg["detail"]["nickname"];
                $tlog1[$key]["avatar"] = $this->url.$msg["detail"]["avatar"];
                $tlog1[$key]["sex"] = $msg["detail"]["sex"];
            }
        }

        if($two > 0) {
            foreach ($tlog2 as $key => $val) {
                $msg=$User->getUserDetail($val["uid"]);
                $tlog2[$key]["nickname"] = $msg["detail"]["nickname"];
                $tlog2[$key]["avatar"] = $this->url.$msg["detail"]["avatar"];
                $tlog2[$key]["sex"] = $msg["detail"]["sex"];
            }
        }



        self::echoJson(array("code" => 0,"data" => array(
            "one" => $one,
            "two" => $two,
            "sum" => $sum,
            "today" => $today,
            "oneList" => $tlog1,
            "twoList" => $tlog2
        ),"msg" => "success"));


    }

    public function shuju()
    {
        $uid = self::getToken();
        $MuchangJiaoyi = new \Common\Model\MuchangJiaoyiModel();
        $today = $MuchangJiaoyi->where(array(" addtime >= '".date("Y-m-d 00:00:00",strtotime("-7days"))."' "))->order('addtime asc')->select();
        $back = array();
        $max = 0;
        if(count($today) > 0) {
            foreach ($today as $key => $val) {
                if($val["price"] > $max) {
                    $max = $val["price"];
                }
                if(isset($back[date("Ymd",strtotime($val["addtime"]))])) {
                    $back[date("Ymd",strtotime($val["addtime"]))]["money"] = ($back[date("Ymd",strtotime($val["addtime"]))]["money"] + $val["price"]) / 2;
                } else {
                    $back[date("Ymd",strtotime($val["addtime"]))]["money"] = $val["price"];
                    $back[date("Ymd",strtotime($val["addtime"]))]["time"] = date("m/d",strtotime($val["addtime"]));
                }
            }
        }
        self::echoJson(array("code" => 0,"data" => array(
            "max" => $max,
            "list" => array_values($back)
        ),"msg" => "success"));
    }

    public function jihuoma()
    {
        $uid = self::getToken();

        $MuchangJihuoma = new \Common\Model\MuchangJihuomaModel();

        // 查询数据
        $data = $MuchangJihuoma->where("uid =" .$uid." and status = 2")->order('id desc')->select();

        self::echoJson(array("code" => 0,"data" => $data,"msg" => "success"));
    }

    public function usejihuoma()
    {
        $uid = self::getToken();
        $no = $_REQUEST["no"];
        $MuchangJihuoma = new \Common\Model\MuchangJihuomaModel();
        $MuchangGoods = new \Common\Model\MuchangGoodsModel();
        $Muchang = new \Common\Model\MuchangModel();
        $MuchangLog = new \Common\Model\MuchangLogModel();

        // 查询数据
        $data = $MuchangJihuoma->where("no = '$no'")->find();
        if (count($data) > 0 && $data["status"] != 3) {
            if($data["uid"] == 0 || $data["uid"] == $uid) {
                $gdata = $MuchangGoods->where(array("id" => $data["goods_id"]))->find();
                $mcInfo = $Muchang->where(array("uid" => $uid))->find();
                //新增 商品类型 1是动物 2是口粮 3是哈士奇
                if($gdata["goods_type"] == 1) {
                    $Muchang->where(array("uid" =>$uid ))->save(array(
                        "ji" => ($mcInfo["ji"] + $gdata["num"])
                    ));
                    $MuchangLog->add(array(
                        "uid" => $uid,
                        "type" => 9,
                        "dan" => $data["num"],
                        "remark" => "使用激活码".$no."激活了".$gdata["num"]."个动物",
                        "addtime" => date("Y-m-d H:i:s")
                    ));
                }
                if($gdata["goods_type"] == 2) {
                    $Muchang->where(array("uid" =>$uid ))->save(array(
                        "kouliang" => ($mcInfo["kouliang"] + $gdata["num"])
                    ));
                    $MuchangLog->add(array(
                        "uid" => $uid,
                        "type" => 9,
                        "kouliang" => $data["num"],
                        "remark" => "使用激活码".$no."激活了".$gdata["num"]."包口粮",
                        "addtime" => date("Y-m-d H:i:s")
                    ));
                }
                if($gdata["goods_type"] == 3) {
                    if(intval($mcInfo["dog"]) <= 0) {
                        $dogDate = date("Y-m-d H:m:s",strtotime("+30 days"));
                    } else {
                        if(strtotime($mcInfo["dogdate"]) > time()) {
                            $dogDate = date("Y-m-d H:m:s",strtotime($mcInfo["dogdate"])+(86400*30));
                        } else {
                            $dogDate = date("Y-m-d H:m:s",strtotime("+30 days"));
                        }
                    }

                    $Muchang->where(array("uid" =>$uid ))->save(array(
                        "dog" => 1,
                        "dogdate" => $dogDate
                    ));
                    $MuchangLog->add(array(
                        "uid" => $uid,
                        "type" => 9,
                        "remark" => "使用激活码".$no."激活了个哈士奇，有效期到".$dogDate,
                        "addtime" => date("Y-m-d H:i:s")
                    ));
                }

                if($gdata["goods_type"] == 4) {
                    if(strtotime($mcInfo["ysdstart"]) > time()) {
                        self::echoJson(array("code" => 1000,"data" => array(),"msg" => "使用延寿丹距离上次不到20天无法使用"));
                    }
                    $Muchang->where(array("uid" =>$uid ))->save(array(
                        "isysd" => 1,
                        "ysddate" => date("Y-m-d H:i:s",strtotime("+2 days")),
                        "ysdstart" => date("Y-m-d H:i:s",strtotime("+20 days")),
                    ));
                    $MuchangLog->add(array(
                        "uid" => $uid,
                        "type" => 9,
                        "remark" => "使用激活码".$no."激活了延寿丹",
                        "addtime" => date("Y-m-d H:i:s")
                    ));
                }

                if($gdata["goods_type"] == 5) {
                    if(strtotime($mcInfo["yndstart"]) > time()) {
                        self::echoJson(array("code" => 1000,"data" => array(),"msg" => "使用延年丹距离上次不到20天无法使用"));
                    }
                    $Muchang->where(array("uid" =>$uid ))->save(array(
                        "isynd" => 1,
                        "ynddate" => date("Y-m-d H:i:s",strtotime("+3 days")),
                        "yndstart" => date("Y-m-d H:i:s",strtotime("+20 days")),
                    ));
                    $MuchangLog->add(array(
                        "uid" => $uid,
                        "type" => 9,
                        "remark" => "使用激活码".$no."激活了延年丹",
                        "addtime" => date("Y-m-d H:i:s")
                    ));
                }

                $data2 = array(
                    "uid" => $uid,
                    "status" => 3,
                );
                $MuchangJihuoma->where("no = '$no'")->save($data2);
                self::echoJson(array("code" => 0,"data" => array(),"msg" => "激活成功"));
            } else {
                self::echoJson(array("code" => 1000,"data" => array(),"msg" => "处理失败"));
            }
        }
        self::echoJson(array("code" => 1000,"data" => array(),"msg" => "找不到激活码"));
    }

    public function code()
    {
        $_GET['text'] = 1;
        if(!isset($_GET['text'])){
            header("Content-type: text/html; charset=utf-8");
            echo '参数错误.';
            exit;
        }
        $text = strtoupper(trim($_GET['text']));

        //引入类库
        Vendor('code.phpqrcode');
        $errorCorrectionLevel =intval(2) ;//容错级别
        $matrixPointSize = intval(4);     //生成图片大小
        $margin =1;//外边距离(白边)
        //实例类库里的QRcode类对象
        $qr = new \QRcode();

        $path = 'Public/Upload/User/code/'.$text.'.png';
        $qr->png($text,$path, $errorCorrectionLevel, $matrixPointSize, 1);
        die;
    }

    public function star()
    {
        $Muchang = new \Common\Model\MuchangModel();
        $MuchangLog = new \Common\Model\MuchangLogModel();
        $mc = $Muchang->select();
        foreach ($mc as $key => $val) {
            if($val["ji"] >= 20 && $val["ji"] < 50 && $val["star"] < 1) {
                $Muchang->where(array("uid" =>$val["uid"] ))->save(array("star" => 1));
                $MuchangLog->add(array(
                    "uid" => 0,
                    "tuid" => $val["uid"],
                    "type" => 5,
                    "system" => 9,
                    "remark" => "星级达人更新为一星达人",
                    "addtime" => date("Y-m-d H:i:s")
                ));
            }
            if($val["ji"] >= 50 && $val["ji"] < 100 && $val["star"] < 2) {
                $Muchang->where(array("uid" =>$val["uid"] ))->save(array("star" => 2));
                $MuchangLog->add(array(
                    "uid" => 0,
                    "tuid" => $val["uid"],
                    "type" => 5,
                    "system" => 9,
                    "remark" => "星级达人更新为二星达人",
                    "addtime" => date("Y-m-d H:i:s")
                ));
            }
            if($val["ji"] >= 100 && $val["ji"] < 300 && $val["star"] < 3) {
                $Muchang->where(array("uid" =>$val["uid"] ))->save(array("star" => 3));
                $MuchangLog->add(array(
                    "uid" => 0,
                    "tuid" => $val["uid"],
                    "type" => 5,
                    "system" => 9,
                    "remark" => "星级达人更新为三星达人",
                    "addtime" => date("Y-m-d H:i:s")
                ));
                $Muchang->where(array("uid" =>$val["uid"] ))->save(array(
                    "isysd" => 1,
                    "ysddate" => date("Y-m-d H:i:s",strtotime("+2 days")),
                    "ysdstart" => date("Y-m-d H:i:s",strtotime("+20 days")),
                ));
                $MuchangLog->add(array(
                    "uid" => 0,
                    "tuid" => $val["uid"],
                    "type" => 5,
                    "system" => 9,
                    "remark" => "升级三星达人赠送了延寿丹",
                    "addtime" => date("Y-m-d H:i:s")
                ));
            }
            if($val["ji"] >= 300  && $val["star"] < 4) {
                $Muchang->where(array("uid" =>$val["uid"] ))->save(array("star" => 4));
                $MuchangLog->add(array(
                    "uid" => 0,
                    "tuid" => $val["uid"],
                    "type" => 5,
                    "system" => 9,
                    "remark" => "星级达人更新为牧场金主",
                    "addtime" => date("Y-m-d H:i:s")
                ));
                $Muchang->where(array("uid" =>$val["uid"] ))->save(array(
                    "isynd" => 1,
                    "ynddate" => date("Y-m-d H:i:s",strtotime("+3 days")),
                    "yndstart" => date("Y-m-d H:i:s",strtotime("+20 days")),
                ));
                $MuchangLog->add(array(
                    "uid" => 0,
                    "tuid" => $val["uid"],
                    "type" => 5,
                    "system" => 9,
                    "remark" => "升级牧场金主赠送了延年丹",
                    "addtime" => date("Y-m-d H:i:s")
                ));
            }
        }
        echo "success:result".count($mc);
    }


    public function sysn()
    {
        $Muchang = new \Common\Model\MuchangModel();
        $Config = new \Common\Model\MuchangConfigModel();
        $configInfo = $Config->find();
        $User=new \Common\Model\UserModel();
        $MuchangLog = new \Common\Model\MuchangLogModel();
        $mc = $Muchang->select();
        $kuoliang = 1;
        foreach ($mc as $key => $val) {
            //达人奖励
            if($val["star"] == 1) {
                $star = $configInfo["kouliang1"];
                $Muchang->where(array("uid" =>$val["uid"] ))->setInc("kouliang" ,$star);
                $MuchangLog->add(array(
                    "uid" => 0,
                    "tuid" => $val["uid"],
                    "type" => 5,
                    "kouliang" => 1,
                    "system" => $star,
                    "remark" => "一星达人赠送".$star."袋口粮",
                    "addtime" => date("Y-m-d H:i:s")
                ));
            }
            if($val["star"] == 2) {
                $star = $configInfo["kouliang2"];
                $Muchang->where(array("uid" =>$val["uid"] ))->setInc("kouliang" ,$star);
                $MuchangLog->add(array(
                    "uid" => 0,
                    "tuid" => $val["uid"],
                    "type" => 5,
                    "kouliang" => 1,
                    "system" => $star,
                    "remark" => "二星达人赠送".$star."袋口粮",
                    "addtime" => date("Y-m-d H:i:s")
                ));
            }
            if($val["star"] == 3) {
                $star = $configInfo["kouliang3"];
                $Muchang->where(array("uid" =>$val["uid"] ))->setInc("kouliang" ,$star);
                $MuchangLog->add(array(
                    "uid" => 0,
                    "tuid" => $val["uid"],
                    "type" => 5,
                    "kouliang" => 1,
                    "system" => $star,
                    "remark" => "三星达人赠送".$star."袋口粮",
                    "addtime" => date("Y-m-d H:i:s")
                ));
            }
            if($val["star"] == 4) {
                $star = $configInfo["kouliang4"];
                $Muchang->where(array("uid" =>$val["uid"] ))->setInc("kouliang" ,$star);
                $MuchangLog->add(array(
                    "uid" => 0,
                    "tuid" => $val["uid"],
                    "type" => 5,
                    "kouliang" => 1,
                    "system" => $star,
                    "remark" => "牧场金主赠送".$star."袋口粮",
                    "addtime" => date("Y-m-d H:i:s")
                ));
            }

            //推荐奖励
            $referrer_num = $User->where("referrer_id='".$val["uid"]."'")->select();
            if(count($referrer_num) > 0) {
                $r1 = 0;
                foreach ($referrer_num as $key1 => $val1) {
                    $res = $Muchang->where(array("uid" => $val1["uid"]))->find();
                    if(@$res["ji"] > 0) {
                        $r1++;
                    }
                }
                //增加口粮
                if($r1 > 0) {
                    $r1 = $r1 * $configInfo["zhitui"];
                    $Muchang->where(array("uid" =>$val["uid"] ))->setInc("kouliang" ,$r1);
                    $MuchangLog->add(array(
                        "uid" => 0,
                        "tuid" => $val["uid"],
                        "type" => 5,
                        "kouliang" => 1,
                        "system" => $r1,
                        "remark" => "直推赠送".$r1."袋口粮",
                        "addtime" => date("Y-m-d H:i:s")
                    ));
                }
            }

            $sub_referrer_num=$User->where("sub_referrer_id='".$val["uid"]."'")->select();
            if(count($sub_referrer_num) > 0) {
                $r2 = 0;
                foreach ($sub_referrer_num as $key2 => $val2) {
                    $res = $Muchang->where(array("uid" => $val2["uid"]))->find();
                    if(@$res["ji"] > 0) {
                        $r2++;
                    }
                }
                if($r2 > 0) {
                    $r2 = $r2 * $configInfo["tuandui"];
                    //增加口粮
                    $Muchang->where(array("uid" =>$val["uid"] ))->setInc("kouliang" ,$r2);
                    $MuchangLog->add(array(
                        "uid" => 0,
                        "tuid" => $val["uid"],
                        "type" => 5,
                        "kouliang" => 1,
                        "system" => $r2,
                        "remark" => "团推赠送".$r2."袋口粮",
                        "addtime" => date("Y-m-d H:i:s")
                    ));
                }

            }


            //增加口粮
            $Muchang->where(array("uid" =>$val["uid"] ))->setInc("kouliang" ,$kuoliang);
            $MuchangLog->add(array(
                "uid" => 0,
                "tuid" => $val["uid"],
                "type" => 5,
                "kouliang" => 1,
                "system" => $kuoliang,
                "remark" => "赠送".$kuoliang."袋口粮",
                "addtime" => date("Y-m-d H:i:s")
            ));

            //更改登录状态
            $Muchang->where(array("uid" =>$val["uid"] ))->save(array("islogin" => 0));

            //检查哈士奇是否过期
            if($val["dog"] == 1 && strtotime($val["dogdate"]) <= time()) {
                $Muchang->where(array("uid" =>$val["uid"] ))->save(array("dog" => 0,"dogdate" => ""));
                $MuchangLog->add(array(
                    "uid" => 0,
                    "tuid" => $val["uid"],
                    "type" => 5,
                    "system" => 4,
                    "remark" => "哈士奇已过期，过期日期为".$val["dogdate"],
                    "addtime" => date("Y-m-d H:i:s")
                ));
            }

            //收蛋
            //今天已经喂粮多少次
            $tlog = $MuchangLog->where(array("type = 1 and uid = ".$val["uid"]." and addtime >= '".date("Y-m-d 00:00:00",strtotime("-1 days"))."' and addtime <='" .date("Y-m-d 23:59:59",strtotime("-1 days"))."'"))->select();
            //$tlog = $MuchangLog->where(array("type = 1 and uid = ".$val["uid"]." and addtime >= '".date("Y-m-d 00:00:00")."' and addtime <='" .date("Y-m-d 23:59:59")."'"))->select();
            $times = 0;
            if(count($tlog) > 0 ) {
                foreach ($tlog as $k => $v) {
                    $times += $v["kouliang"];
                }
            }
            if($times > 0) {
                $Muchang->where(array("uid" =>$val["uid"] ))->setInc("undan" ,$times);
            }
            $MuchangLog->add(array(
                "uid" => 0,
                "tuid" => $val["uid"],
                "type" => 5,
                "dan" => $times,
                "system" => 1,
                "remark" => "今日生蛋".$times,
                "addtime" => date("Y-m-d H:i:s")
            ));
            $MuchangLog->add(array(
                "uid" => 0,
                "tuid" => $val["uid"],
                "type" => 5,
                "dan" => ($times + $val["dan"]),
                "system" => 5,
                "remark" => "总蛋数为".($times + $val["dan"]),
                "addtime" => date("Y-m-d H:i:s")
            ));
            $userInfo = $User->where(array("uid" =>$val["uid"] ))->find();
            $User->where(array("uid" =>$val["uid"] ))->save(array("daydanshu" => $times,"danshu" => ($userInfo["danshu"]+$times)));

            $tlog1 = $MuchangLog->where(array("ji > 0 and uid = ".$val["uid"]." and addtime >= '".date("Y-m-d 00:00:00",strtotime("-20 days"))."' and addtime <='" .date("Y-m-d 23:59:59",strtotime("-20 days"))."'"))->select();
            if($val["ysddate"] != null && strtotime($val["ysddate"]) > time()) {
                $tlog1 = $MuchangLog->where(array("ji > 0 and uid = ".$val["uid"]." and addtime >= '".date("Y-m-d 00:00:00",strtotime("-17 days"))."' and addtime <='" .date("Y-m-d 23:59:59",strtotime("-17 days"))."'"))->select();
            }
            if($val["ynddate"] != null && strtotime($val["ynddate"]) > time()) {
                $tlog1 = $MuchangLog->where(array("ji > 0 and uid = ".$val["uid"]." and addtime >= '".date("Y-m-d 00:00:00",strtotime("-17 days"))."' and addtime <='" .date("Y-m-d 23:59:59",strtotime("-17 days"))."'"))->select();
            }

            //鸡周期已到
            $jiTimes = 0;
            if(count($tlog1) > 0 ) {
                foreach ($tlog1 as $k1 => $v1) {
                    $jiTimes += $v1["ji"];
                }
            }
            if($jiTimes > 0) {
                if($jiTimes > $val["ji"]) {
                    $jiTimes = $val["ji"];
                }
                $Muchang->where(array("uid" =>$val["uid"] ))->save(array("ji" => ($val["ji"] - $jiTimes)));

                $MuchangLog->add(array(
                    "uid" => 0,
                    "tuid" => $val["uid"],
                    "type" => 5,
                    "ji" => $jiTimes,
                    "system" => 3,
                    "remark" => "".$jiTimes."的动物已到产蛋周期，明起不再产蛋",
                    "addtime" => date("Y-m-d H:i:s")
                ));
            }


        }


        echo "success:result".count($mc);

    }



    private static function echoJson($res)
    {
        header('content-type:application/json');
        echo json_encode($res);
        exit;
    }

}