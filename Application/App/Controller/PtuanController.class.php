<?php
/**
 * 拉新活动接口
 */
namespace App\Controller;

use App\Common\Controller\AuthController;

class PtuanController extends AuthController
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
        //$uid = 10;
        return $uid;
    }


    public function getShop()
    {
        $uid = self::getToken();
        $Shop = new \Common\Model\PtuanShopModel();

        $where = array("user_id" => $uid);
        $data = $Shop->where($where)->find();
        if ($data === null) {
            // 未查询到数据
            $res = [
                'code' => 200,
                'msg' => "未查询到数据"
            ];
        } else {
            // 查询成功
            $res = [
                'code' => 200,
                'msg' => '成功',
                'data' => $data,
            ];
        }
        self::echoJson($res);
    }

    public function addShop()
    {
        $uid = self::getToken();
        $Shop = new \Common\Model\PtuanShopModel();
        $name = $_REQUEST["name"];
        $shop_type = $_REQUEST["shop_type"];
        $phone = $_REQUEST["phone"];
        $address = $_REQUEST["address"];
        $code = $_REQUEST["code"];
        if ($name == "" || $phone == "" || $address == "") {
            $res = [
                'code' => 500,
                'msg' => "字段缺失"
            ];
            self::echoJson($res);
        }

        //验证短信是否正确
        $sms=new \Common\Model\SmsModel();
        $res=$sms->checkCode($phone, $code);
        if($res["code"] != 0) {
            $res = [
                'code' => 500,
                'msg' => "验证码有误"
            ];
            self::echoJson($res);
        }


        // 组装数据
        $data = [
            'user_id' => $uid,
            'name' => $name,
            'shop_type' => $shop_type,
            'phone' => $phone,
            'address' => $address,
            'addtime' => date("Y-m-d H:i:s")
        ];
        // 入库
        $isdata = $Shop->where(array("user_id" => $uid))->select();
        if (count($isdata) <= 0) {
            $res = $Shop->add($data);
        } else {
            $res = $Shop->where("user_id = $uid")->save($data);
        }

        if ($res) {
            $res = [
                'code' => 200,
                'msg' => 'success'
            ];
            self::echoJson($res);
        } else {
            $res = [
                'code' => 500,
                'msg' => '系统出错'
            ];
            self::echoJson($res);
        }
    }

    public function addGoods()
    {
        $uid = self::getToken();
        $Goods = new \Common\Model\PtuanGoodsModel();
        $Shop = new \Common\Model\PtuanShopModel();
        $name = $_REQUEST["name"];
        $imgs = $_REQUEST["imgs"];
        $desc = $_REQUEST["desc"];
        $tags = $_REQUEST["tags"];
        $startTime = $_REQUEST["startTime"];
        $endTime = $_REQUEST["endTime"];
        $price = $_REQUEST["price"];
        $sale = $_REQUEST["sale"];
        $backl = $_REQUEST["backl"];
        $fee = $_REQUEST["fee"];
        $qty = $_REQUEST["qty"];
        $qipai = $_REQUEST["qipai"];
        if ($name == "") {
            $res = [
                'code' => 500,
                'msg' => "字段缺失"
            ];
            self::echoJson($res);
        }
        $shopdata = $Shop->where(array("user_id" => $uid))->find();
        if ($shopdata == null) {
            $res = [
                'code' => 500,
                'msg' => "店铺缺失"
            ];
            self::echoJson($res);
        }

        // 组装数据
        $data = [
            'shop_id' => $shopdata["id"],
            'name' => $name,
            'imgs' => $imgs,
            'desc' => $desc,
            'lucky' => rand(1,9),
            'tags' => $tags,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'price' => $price,
            'sale' => $sale,
            'back_l' => $backl,
            'fee' => $fee,
            'qty' => $qty,
            'qipai' => $qipai,
            'addtime' => date("Y-m-d H:i:s")
        ];
        // 入库
        $res = $Goods->add($data);

        if ($res) {
            $res = [
                'code' => 200,
                'msg' => 'success'
            ];
            self::echoJson($res);
        } else {
            $res = [
                'code' => 500,
                'msg' => '系统出错'
            ];
            self::echoJson($res);
        }
    }

    public function getGoodsList()
    {
        //self::getToken();
        $Goods = new \Common\Model\PtuanGoodsModel();
        $Order = new \Common\Model\PtuanOrderModel();
        $id = $_REQUEST["id"];
        if ($id > 0) {
            $where = "id = $id ";
        } else {
            $where = " is_close = 0 and status = 1 and qipai > 0 and back_l > 0 ";
        }

        $data = $Goods->where($where)->order('id desc')->select();
        if ($data === null) {
            // 未查询到数据
            $res = [
                'code' => 200,
                'msg' => "未查询到数据"
            ];
        } else {
            foreach ($data as $key => $val) {
                $data[$key]["imgsList"] = json_decode($val["imgs"],true);
                $data[$key]["salenum"] = $Order->where(array("goods_id" => $val["id"]))->count();
            }

            // 查询成功
            $res = [
                'code' => 200,
                'msg' => '成功',
                'data' => $data,
            ];
        }
        self::echoJson($res);
    }

    public function getShopGoodsList()
    {
        $uid = self::getToken();
        $Goods = new \Common\Model\PtuanGoodsModel();
        $Shop = new \Common\Model\PtuanShopModel();
        $Order = new \Common\Model\PtuanOrderModel();
        $id = $_REQUEST["id"];
        if ($id > 0) {
            $where = "  id = $id ";
        } else {
            $where = " pid = 0  ";
        }

        //卖家
        $sdata = $Shop->where(array("user_id" => $uid))->find();
        if($sdata == null) {
            $res = [
                'code' => 200,
                'msg' => "未查询到卖家数据"
            ];
            self::echoJson($res);
        } else {
            $where .= " and shop_id = ".$sdata["id"];
        }

        $data = $Goods->where($where)->order('id desc')->select();
        if ($data === null) {
            // 未查询到数据
            $res = [
                'code' => 200,
                'msg' => "未查询到数据"
            ];
        } else {
            foreach ($data as $key => $val) {
                $data[$key]["imgsList"] = json_decode($val["imgs"],true);
                $data[$key]["salenum"] = $Order->where(array("goods_id" => $val["id"]))->count();
            }

            // 查询成功
            $res = [
                'code' => 200,
                'msg' => '成功',
                'data' => $data,
            ];
        }
        self::echoJson($res);
    }

    public function getGoodsOrderList()
    {
        $Order = new \Common\Model\PtuanOrderModel();
        $Goods = new \Common\Model\PtuanGoodsModel();
        $UserDetail = new \Common\Model\UserDetailModel();
        $goods_id = $_REQUEST["goods_id"];
        if (intval($goods_id) <= 0) {
            $res = [
                'code' => 500,
                'msg' => "字段缺失"
            ];
            self::echoJson($res);
        }

        $data = $Order->where(array("goods_id" => $goods_id))->order("id desc")->select();
        if ($data === null) {
            // 未查询到数据
            $res = [
                'code' => 200,
                'msg' => "未查询到数据"
            ];
        } else {
            foreach ($data as $key => $val) {
                $data[$key]["goods"] = $Goods->where("id = ".$val["goods_id"])->find();
                $userInfo = $UserDetail->where("user_id = ".$val["user_id"])->find();
                $data[$key]["nickname"] = $userInfo["nickname"];
                $data[$key]["avatar"] = $userInfo["avatar"];
                $data[$key]["qipai"] = $data[$key]["goods"]["qipai"];
                $data[$key]["price"] = $data[$key]["goods"]["price"];
                unset($data[$key]["goods"]);
            }
            // 查询成功
            $res = [
                'code' => 200,
                'msg' => '成功',
                'data' => array("items" => $data,"count" => count($data)),
            ];
        }
        self::echoJson($res);
    }

    public function payOrder()
    {
        $uid = self::getToken();
        $Order = new \Common\Model\PtuanOrderModel();
        $Goods = new \Common\Model\PtuanGoodsModel();
        $User = new \Common\Model\UserModel();
        $Dmoney = new \Common\Model\DmoneyUserModel();
        $goods_id = $_REQUEST["goods_id"];
        $num = $_REQUEST["num"];
        $pay = $_REQUEST["pay"];
        if ($goods_id == "") {
            $res = [
                'code' => 500,
                'msg' => "字段缺失"
            ];
            self::echoJson($res);
        }

        // 入库
        $isdata = $Order->where(array("goods_id" => $goods_id,"user_id" => $uid))->find();
        if ($isdata != null) {
            $res = [
                'code' => 500,
                'msg' => "订单已存在"
            ];
            self::echoJson($res);
        }

        //扣减
        $goodsdata = $Goods->where(array("id" => $goods_id,"isOpen" => 1))->find();
        if ($goodsdata == null) {
            $res = [
                'code' => 500,
                'msg' => "商品缺失"
            ];
            self::echoJson($res);
        }
        if($pay != 1 && $pay != 2) {
            $res = [
                'code' => 500,
                'msg' => "请选择支付方式"
            ];
            self::echoJson($res);
        }

        if($pay == 1) {
            //扣取积分.
            $needjf = $goodsdata["qipai"];
            $pointRecord = $User->where(array("uid" => $uid))->find();
            if($pointRecord["jifen"] < $needjf) {
                self::echoJson(array( 'code'=> 500, 'msg'=>"你当前积分只有".$pointRecord["all_point"].",无法支付"));
            } else {
                // 组装数据
                $udata = [
                    'jifen'          =>( $pointRecord["jifen"] - $needjf) ,
                ];
                // 入库
                $User->where(array("uid" =>$uid ))->save($udata);
            }
        }
        if($pay == 2) {
            $needjf = $goodsdata["qipai"];
            $Dmoneyuser = $Dmoney->where(array("user_id" => $uid))->select();
            $isPay = 0;
            if(count($Dmoneyuser) > 0) {
                foreach($Dmoneyuser as $key => $val) {
                    if($val["account"] >= $needjf) {
                        // 组装数据
                        $udata = [
                            'account'          =>( $val["account"] - $needjf) ,
                        ];
                        // 入库
                        $Dmoney->where(array("user_id" =>$uid,"name" => $val["name"]))->save($udata);
                        $isPay++;
                        break;
                    }
                }
            }
            if($isPay == 0) {
                self::echoJson(array( 'code'=> 500, 'msg'=>"你当前数字资产不足,无法支付"));
            }
        }
        $order_sn = date("YmdHis").rand(10000,99999);

        if($goodsdata["pid"] == 0) {
            $pid = $goods_id;
        }else {
            $pid = $goodsdata["pid"];
        }
        // 组装数据
        $data = [
            'order_sn' => $order_sn,
            'goods_id' => $goods_id,
            'qi' => $goodsdata["qi"],
            'pid' => $pid,
            'user_id' => $uid,
            'num' => $num,
            'isQuankuan' => 2,
            'orderstatus' => '1',
            'addtime' => date("Y-m-d H:i:s")
        ];
        // 入库
        $res = $Order->add($data);
        if ($res) {
            $Goods->where("id = $goods_id")->save(array("salenum" => $goodsdata["salenum"] + 1));
            $res = [
                'code' => 200,
                'msg' => 'success',
                'result' => $order_sn,
            ];
            self::echoJson($res);
        } else {
            $res = [
                'code' => 200,
                'msg' => 'success'
            ];
            self::echoJson($res);
        }
    }

    public function pay()
    {
        $uid = self::getToken();
        $Order = new \Common\Model\PtuanOrderModel();
        $Goods = new \Common\Model\PtuanGoodsModel();
        $User = new \Common\Model\UserModel();
        $Dmoney = new \Common\Model\DmoneyUserModel();
        $goods_id = $_REQUEST["goods_id"];
        $pay = $_REQUEST["pay"];
        $remark = $_REQUEST["remark"];
        $invoices = $_REQUEST["invoices"];
        $num = $_REQUEST["num"];

        //扣减
        $goodsdata = $Goods->where(array("id" => $goods_id))->find();
        if ($goodsdata == null) {
            $res = [
                'code' => 500,
                'msg' => "商品缺失"
            ];
            self::echoJson($res);
        }

        if($pay != 1 && $pay != 2) {
            $res = [
                'code' => 500,
                'msg' => "请选择支付方式"
            ];
            self::echoJson($res);
        }

        if($goodsdata["pid"] == 0) {
            $pid = $goods_id;
        }else {
            $pid = $goodsdata["pid"];
        }

        if($pay == 1) {
            //扣取积分.
            $needjf = $goodsdata["price"];
            $pointRecord = $User->where(array("uid" => $uid))->find();
            if($pointRecord["jifen"] < $needjf) {
                self::echoJson(array( 'code'=> 500, 'msg'=>"你当前积分只有".$pointRecord["all_point"].",无法支付"));
            } else {
                // 组装数据
                $udata = [
                    'jifen'          =>( $pointRecord["jifen"] - $needjf) ,
                ];
                // 入库
                $User->where(array("uid" =>$uid ))->save($udata);
            }
        }
        if($pay == 2) {
            $needjf = $goodsdata["price"];
            $Dmoneyuser = $Dmoney->where(array("user_id" => $uid))->select();
            $isPay = 0;
            if(count($Dmoneyuser) > 0) {
                foreach($Dmoneyuser as $key => $val) {
                    if($val["account"] >= $needjf) {
                        // 组装数据
                        $udata = [
                            'account'          =>( $val["account"] - $needjf) ,
                        ];
                        // 入库
                        $Dmoney->where(array("user_id" =>$uid,"name" => $val["name"]))->save($udata);
                        $isPay++;
                        break;
                    }
                }
            }
            if($isPay == 0) {
                self::echoJson(array( 'code'=> 500, 'msg'=>"你当前数字资产不足,无法支付"));
            }
        }

        $order_sn = date("YmdHis").rand(10000,99999);

        // 组装数据
        $data = [
            'order_sn' => $order_sn,
            'goods_id' => $goods_id,
            'qi' => $goodsdata["qi"],
            'pid' => $pid,
            'user_id' => $uid,
            'num' => $num,
            'pay' => $pay,
            'remark' => @$remark,
            'invoices' => @$invoices,
            'receiver' => @$_REQUEST["receiver"],
            'phone' => @$_REQUEST["phone"],
            'area' => @$_REQUEST["area"],
            'address' => @$_REQUEST["address"],
            'isDefault' => @$_REQUEST["isDefault"],
            'orderstatus' => '1',
            'isQuankuan' => 1,
            'addtime' => date("Y-m-d H:i:s")
        ];

        // 入库
        $res = $Order->add($data);
        if ($res) {
            $Goods->where("id = $goods_id")->save(array("salenum" => $goodsdata["salenum"] + 1));
            $res = [
                'code' => 200,
                'msg' => 'success',
                'result' => $order_sn
            ];
            self::echoJson($res);
        } else {
            $res = [
                'code' => 200,
                'msg' => 'success'
            ];
            self::echoJson($res);
        }
    }

    public function payDone()
    {
        $Order = new \Common\Model\PtuanOrderModel();
        $Goods = new \Common\Model\PtuanGoodsModel();
        $order_sn= $_REQUEST["order_sn"] ;

        if ($order_sn == "") {
            $res = [
                'code' => 500,
                'msg' => "字段缺失"
            ];
            self::echoJson($res);
        }
        // 组装数据
        $data = [
            'orderstatus' => 2 // 已付款
        ];
        // 入库
        $isdata = $Order->where(array("order_sn" => $order_sn))->find();
        if ($isdata === null) {
            $res = [
                'code' => 500,
                'msg' => "订单缺失"
            ];
            self::echoJson($res);
        } else {
            $res = $Order->where("order_sn = $order_sn")->save($data);
            //满9人进入待开奖状态
            $orderData = $Order->where(array("goods_id" => $isdata["goods_id"]))->select();
            if(count($orderData) >= 9) {
                //新增一个正在活动的商品
                $goodsInfo = $Goods->where(array("id" => $isdata["goods_id"],"isOpen" => 1))->find();
                if(intval($goodsInfo["pid"]) <= 0) {
                    $pid = $isdata["goods_id"];
                } else {
                    $pid = $goodsInfo["pid"];
                }
                if($goodsInfo != null) {
                    // 组装数据
                    $data = [
                        'shop_id' => $goodsInfo["shop_id"],
                        'name' => $goodsInfo["name"],
                        'imgs' => $goodsInfo["imgs"],
                        'qi' => $goodsInfo["qi"]+1,
                        'desc' => $goodsInfo["desc"],
                        'tags' => $goodsInfo["tags"],
                        'lucky' => rand(1,9),
                        'startTime' => date("Y-m-d H:i:s"),
                        'endTime' => date("Y-m-d H:i:s",strtotime("+1 day")),
                        'price' => $goodsInfo["price"],
                        'sale' => $goodsInfo["sale"],
                        'back_l' => $goodsInfo["back_l"],
                        'fee' => $goodsInfo["fee"],
                        'qty' => $goodsInfo["qty"],
                        'qipai' => $goodsInfo["qipai"],
                        'isOpen' => 1,
                        'isAuto' => '1',
                        'pid' => $pid,
                        'addTime' => date("Y-m-d H:i:s")
                    ];
                    // 入库
                    $Goods->add($data);
                }
                $Goods->where("id = ".$isdata["goods_id"])->save(array("isOpen" => 2,"is_close" => 1));
            }
        }
        if ($res) {
            $res = [
                'code' => 200,
                'msg' => 'success'
            ];
            self::echoJson($res);
        } else {
            $res = [
                'code' => 200,
                'msg' => 'success'
            ];
            self::echoJson($res);
        }
    }

    public function luckyOrder()
    {
        $uid = self::getToken();
        $Order = new \Common\Model\PtuanOrderModel();
        $Goods = new \Common\Model\PtuanGoodsModel();
        $User = new \Common\Model\UserModel();
        $goods_id = $_REQUEST["goods_id"];
        $lucky = $_REQUEST["lucky"];

        //扣减
        $goodsdata = $Goods->where(array("id" => $goods_id))->find();
        if ($goodsdata == null) {
            $res = [
                'code' => 500,
                'msg' => "商品缺失"
            ];
            self::echoJson($res);
        }
        if($goodsdata["lucky"] == $lucky) {
            //中奖
            $orderstatus = 3;
            $isluckey = 2;
        } else {
            //返积分
            $needjf = $goodsdata["back_l"];
            $pointRecord = $User->where(array("uid" => $uid))->find();
            // 组装数据
            $udata = [
                'jifen'          =>( $pointRecord["jifen"] + $needjf) ,
            ];
            // 入库
            $User->where(array("uid" =>$uid ))->save($udata);

            $orderstatus = 4;
            $isluckey = 1;
        }

        // 组装数据
        $data = [
            'orderstatus' => $orderstatus,
            'lucky' => $lucky,
            'isluckey' => $isluckey
        ];
        // 入库
        $isdata = $Order->where(array("goods_id" => $goods_id,"user_id" => $uid))->find();
        if ($isdata === null) {
            $res = [
                'code' => 500,
                'msg' => "订单缺失"
            ];
            self::echoJson($res);
        } else {
            if($isdata["isluckey"] > 0) {
                $res = [
                    'code' => 500,
                    'msg' => "已抽奖"
                ];
                self::echoJson($res);
            }
            $res = $Order->where("order_sn = ".$isdata["order_sn"])->save($data);
        }
        $res = [
            'code' => 200,
            'msg' => 'success',
            'result' => @$goodsdata["lucky"]
        ];
        self::echoJson($res);
    }

    public function addOrder()
    {
        $uid = self::getToken();
        $Order = new \Common\Model\PtuanOrderModel();
        $Goods = new \Common\Model\PtuanGoodsModel();
        $User = new \Common\Model\UserModel();
        $Dmoney = new \Common\Model\DmoneyUserModel();
        $goods_id = $_REQUEST["goods_id"];
        $order_sn= $_REQUEST["order_sn"] ;
        $pay = $_REQUEST["pay"];
        $remark = $_REQUEST["remark"];
        $invoices = $_REQUEST["invoices"];
        if ($order_sn == "") {
            $res = [
                'code' => 500,
                'msg' => "字段缺失"
            ];
            self::echoJson($res);
        }

        //扣减
        $goodsdata = $Goods->where(array("id" => $goods_id))->find();
        if ($goodsdata == null) {
            $res = [
                'code' => 500,
                'msg' => "商品缺失"
            ];
            self::echoJson($res);
        }

        $isdata = $Order->where(array("order_sn" => $order_sn))->find();
        if ($isdata === null) {
            $res = [
                'code' => 500,
                'msg' => "订单缺失"
            ];
            self::echoJson($res);
        } else {
            if($isdata["orderstatus"] != 3) {
                $res = [
                    'code' => 500,
                    'msg' => "订单状态有误"
                ];
                self::echoJson($res);
            }
        }

        if($pay != 1 && $pay != 2) {
            $res = [
                'code' => 500,
                'msg' => "请选择支付方式"
            ];
            self::echoJson($res);
        }

        if($pay == 1) {
            //扣取积分.
            $needjf = $goodsdata["price"];
            $pointRecord = $User->where(array("uid" => $uid))->find();
            if($pointRecord["jifen"] < $needjf) {
                self::echoJson(array( 'code'=> 500, 'msg'=>"你当前积分只有".$pointRecord["all_point"].",无法支付"));
            } else {
                // 组装数据
                $udata = [
                    'jifen'          =>( $pointRecord["jifen"] - $needjf) ,
                ];
                // 入库
                $User->where(array("uid" =>$uid ))->save($udata);
            }
        }
        if($pay == 2) {
            $needjf = $goodsdata["price"];
            $Dmoneyuser = $Dmoney->where(array("user_id" => $uid))->select();
            $isPay = 0;
            if(count($Dmoneyuser) > 0) {
                foreach($Dmoneyuser as $key => $val) {
                    if($val["account"] >= $needjf) {
                        // 组装数据
                        $udata = [
                            'account'          =>( $val["account"] - $needjf) ,
                        ];
                        // 入库
                        $Dmoney->where(array("user_id" =>$uid,"name" => $val["name"]))->save($udata);
                        $isPay++;
                        break;
                    }
                }
            }
            if($isPay == 0) {
                self::echoJson(array( 'code'=> 500, 'msg'=>"你当前数字资产不足,无法支付"));
            }
        }

        // 组装数据
        $data = [
            'pay' => $pay,
            'remark' => @$remark,
            'invoices' => @$invoices,
            'receiver' => @$_REQUEST["receiver"],
            'phone' => @$_REQUEST["phone"],
            'area' => @$_REQUEST["area"],
            'address' => @$_REQUEST["address"],
            'isDefault' => @$_REQUEST["isDefault"],
            'orderstatus' => '5'
        ];
        $res = $Order->where("order_sn = $order_sn")->save($data);
        // 入库

        if ($res) {
            $Goods->where("id = $goods_id")->save(array("salenum" => $goodsdata["salenum"] + 1));
            $res = [
                'code' => 200,
                'msg' => 'success'
            ];
            self::echoJson($res);
        } else {
            $res = [
                'code' => 200,
                'msg' => 'success'
            ];
            self::echoJson($res);
        }
    }

    public function editOrder()
    {
        $uid = self::getToken();
        $Order = new \Common\Model\PtuanOrderModel();
        $Goods = new \Common\Model\PtuanGoodsModel();
        $order_sn= $_REQUEST["order_sn"] ;
        $goods_id = $_REQUEST["goods_id"];
        $pay = $_REQUEST["pay"];
        $remark = $_REQUEST["remark"];
        $invoices = $_REQUEST["invoices"];
        $num = $_REQUEST["num"];
        if ($order_sn == "") {
            $res = [
                'code' => 500,
                'msg' => "字段缺失"
            ];
            self::echoJson($res);
        }

        //扣减
        $goodsdata = $Goods->where(array("id" => $goods_id))->find();
        if ($goodsdata == null) {
            $res = [
                'code' => 500,
                'msg' => "商品缺失"
            ];
            self::echoJson($res);
        }

        // 组装数据
        $data = [
            'goods_id' => $goods_id,
            'user_id' => $uid,
            'pay' => $pay,
            'remark' => $remark,
            'invoices' => @$invoices,
            'num' => $num,
            'receiver' => @$_REQUEST["receiver"],
            'phone' => @$_REQUEST["phone"],
            'area' => @$_REQUEST["area"],
            'address' => @$_REQUEST["address"],
            'tag' => @$_REQUEST["tag"],
            'isDefault' => @$_REQUEST["isDefault"]
        ];
        // 入库
        $isdata = $Order->where(array("order_sn" => $order_sn))->find();
        if ($isdata === null) {
            $res = [
                'code' => 500,
                'msg' => "订单缺失"
            ];
            self::echoJson($res);
        } else {
            $res = $Order->where("order_sn = $order_sn")->save($data);
        }

        if ($res) {
            $res = [
                'code' => 200,
                'msg' => 'success'
            ];
            self::echoJson($res);
        } else {
            $res = [
                'code' => 200,
                'msg' => 'success'
            ];
            self::echoJson($res);
        }
    }

    public function expressOrder()
    {
        self::getToken();
        $Order = new \Common\Model\PtuanOrderModel();
        $order_sn= $_REQUEST["order_sn"] ;
        $shipid = $_REQUEST["shipid"];
        $shipname = $_REQUEST["shipname"];
        $express = $_REQUEST["express"];
        if ($order_sn == "") {
            $res = [
                'code' => 500,
                'msg' => "字段缺失"
            ];
            self::echoJson($res);
        }


        // 组装数据
        $data = [
            'shipid'          =>$shipid,
            'shipname'          => $shipname,
            'express'          => $express,
            'shiptime'      => date("Y-m-d H:i:s"),
            'orderstatus' => '7'
        ];

        // 入库
        $isdata = $Order->where(array("order_sn" => $order_sn))->find();
        if ($isdata === null) {
            $res = [
                'code' => 500,
                'msg' => "订单缺失"
            ];
            self::echoJson($res);
        } else {
            $res = $Order->where("order_sn = $order_sn")->save($data);
        }

        if ($res) {
            $res = [
                'code' => 200,
                'msg' => 'success'
            ];
            self::echoJson($res);
        } else {
            $res = [
                'code' => 200,
                'msg' => 'success'
            ];
            self::echoJson($res);
        }
    }

    public function backOrder()
    {
        self::getToken();
        $Order = new \Common\Model\PtuanOrderModel();
        $order_sn= $_REQUEST["order_sn"] ;
        $backremark = $_REQUEST["backremark"];
        if ($order_sn == "") {
            $res = [
                'code' => 500,
                'msg' => "字段缺失"
            ];
            self::echoJson($res);
        }

        // 组装数据
        $data = [
            'backremark'          => $backremark,
            'orderstatus' => '6'
        ];

        // 入库
        $isdata = $Order->where(array("order_sn" => $order_sn))->find();
        if ($isdata === null) {
            $res = [
                'code' => 500,
                'msg' => "订单缺失"
            ];
            self::echoJson($res);
        } else {
            if($isdata["orderstatus"] < 3) {
                $res = $Order->where("order_sn = $order_sn")->save($data);
            } else {
                $res = [
                    'code' => 500,
                    'msg' => "订单不允许退款"
                ];
                self::echoJson($res);
            }
        }
        if ($res) {
            $res = [
                'code' => 200,
                'msg' => 'success'
            ];
            self::echoJson($res);
        } else {
            $res = [
                'code' => 500,
                'msg' => '系统出错'
            ];
            self::echoJson($res);
        }
    }

    public function success()
    {
        self::getToken();
        $Order = new \Common\Model\PtuanOrderModel();
        $order_sn= $_REQUEST["order_sn"] ;
        if ($order_sn == "") {
            $res = [
                'code' => 500,
                'msg' => "字段缺失"
            ];
            self::echoJson($res);
        }

        // 组装数据
        $data = [
            'orderstatus' => '9'
        ];

        // 入库
        $isdata = $Order->where(array("order_sn" => $order_sn))->find();
        if ($isdata === null) {
            $res = [
                'code' => 500,
                'msg' => "订单缺失"
            ];
            self::echoJson($res);
        } else {
            $res = $Order->where("order_sn = $order_sn")->save($data);
        }
        if ($res) {
            $res = [
                'code' => 200,
                'msg' => 'success'
            ];
            self::echoJson($res);
        } else {
            $res = [
                'code' => 500,
                'msg' => '系统出错'
            ];
            self::echoJson($res);
        }
    }

    public function okBackOrder()
    {
        self::getToken();
        $Order = new \Common\Model\PtuanOrderModel();
        $User = new \Common\Model\UserModel();
        $Dmoney = new \Common\Model\DmoneyUserModel();
        $Goods = new \Common\Model\PtuanGoodsModel();
        $order_sn= $_REQUEST["order_sn"] ;
        if ($order_sn == "") {
            $res = [
                'code' => 500,
                'msg' => "字段缺失"
            ];
            self::echoJson($res);
        }

        // 组装数据
        $data = [
            'orderstatus' => '8'
        ];

        // 入库
        $isdata = $Order->where(array("order_sn" => $order_sn))->find();

        if ($isdata === null) {
            $res = [
                'code' => 500,
                'msg' => "订单缺失"
            ];
            self::echoJson($res);
        } else {
            if($isdata["orderstatus"] == 6) {
                $goodsdata = $Goods->where(array("id" => $isdata["goods_id"]))->find();
                if($isdata["pay"] == 1) {
                    //扣取积分.
                    $needjf = $goodsdata["price"];
                    $pointRecord = $User->where(array("uid" =>  $isdata["user_id"]))->find();
                    // 组装数据
                    $udata = [
                        'jifen'          =>( $pointRecord["jifen"] + $needjf) ,
                    ];
                    // 入库
                    $User->where(array("uid" =>$isdata["user_id"] ))->save($udata);
                }
                if($isdata["pay"] == 2) {
                    $needjf = $goodsdata["price"];
                    $Dmoneyuser = $Dmoney->where(array("user_id" => $isdata["user_id"]))->select();
                    if(count($Dmoneyuser) > 0) {
                        foreach($Dmoneyuser as $key => $val) {
                                // 组装数据
                                $udata = [
                                    'account'          =>( $val["account"] + $needjf) ,
                                ];
                                // 入库
                                $Dmoney->where(array("user_id" =>$isdata["user_id"],"name" => $val["name"]))->save($udata);
                                break;
                        }
                    }
                }
                $res = $Order->where("order_sn = $order_sn")->save($data);
            } else {
                $res = [
                    'code' => 500,
                    'msg' => "订单不允许同意退款"
                ];
                self::echoJson($res);
            }
        }
        if ($res) {
            $res = [
                'code' => 200,
                'msg' => 'success'
            ];
            self::echoJson($res);
        } else {
            $res = [
                'code' => 500,
                'msg' => '系统出错'
            ];
            self::echoJson($res);
        }
    }

    public function getOrderList()
    {
        $uid = self::getToken();
        $Order = new \Common\Model\PtuanOrderModel();
        $Goods = new \Common\Model\PtuanGoodsModel();
        $Shop = new \Common\Model\PtuanShopModel();
        $UserDetail = new \Common\Model\UserDetailModel();
        $orderstatus = $_REQUEST["orderstatus"];
        $order_sn = $_REQUEST["order_sn"];

        //写死买家
        $type = 2;
        //echo $type;exit;
       // $type = $_REQUEST["type"];
        if ($order_sn > 0) {
            $where = " order_sn = $order_sn ";
        } else {
            $where = " 1= 1 ";
        }
        if ($orderstatus > 1) {
            if($orderstatus  == 4) {
                //待开奖
                $where .= " and  orderstatus IN (1,2) and isQuankuan != 1 ";
            } else if($orderstatus  == 8) {
                //已开奖
                $where .= " and  orderstatus IN (3,4) ";
            }else if($orderstatus  == 6) {
                //补尾款
                $where .= " and  orderstatus IN (3) ";
            }else {
                $where .= " and  orderstatus = $orderstatus ";
            }
        }

        if ($type == 1) {
            //卖家
            $sdata = $Shop->where(array("user_id" => $uid))->find();
            if($sdata == null) {
                $res = [
                    'code' => 200,
                    'msg' => "未查询到卖家数据"
                ];
                self::echoJson($res);
            }
            $gdata = $Goods->where(array("shop_id" => $sdata["id"]))->select();
            $goods_idx = "";
            if(count($gdata) > 0) {
                foreach($gdata as $k => $v) {
                    $goods_idx .= $v["id"].",";
                }
                $goods_idx = trim($goods_idx,",");
                $where .= " and  goods_id in ('".$goods_idx."') ";
            }
        }
        if ($type == 2) {
            //买家
            $where .= " and  user_id = $uid  ";
        }

        if($type != 1 && $type != 2) {
            $res = [
                'code' => 500,
                'msg' => "请选择订单类型"
            ];
            self::echoJson($res);
        }
        $data = $Order->where($where)->order("id desc")->select();
        if ($data === null) {
            // 未查询到数据
            $res = [
                'code' => 200,
                'msg' => "未查询到数据"
            ];
        } else {
            foreach ($data as $key => $val) {
                $data[$key]["goods"] = $Goods->where("id = ".$val["goods_id"])->find();
                $userInfo = $UserDetail->where("user_id = ".$val["user_id"])->find();
                $data[$key]["avatar"] = $userInfo["avatar"];
            }
            // 查询成功
            $res = [
                'code' => 200,
                'msg' => '成功',
                'data' => $data,
            ];
        }
        self::echoJson($res);
    }

    public function getShopOrderList()
    {
        $uid = self::getToken();
        $Order = new \Common\Model\PtuanOrderModel();
        $Goods = new \Common\Model\PtuanGoodsModel();
        $Shop = new \Common\Model\PtuanShopModel();
        $UserDetail = new \Common\Model\UserDetailModel();
        $orderstatus = $_REQUEST["orderstatus"];
        $order_sn = $_REQUEST["order_sn"];

        //写死卖家
        $type = 1;
        //echo $type;exit;
        // $type = $_REQUEST["type"];
        if ($order_sn > 0) {
            $where = " order_sn = $order_sn ";
        } else {
            $where = " 1= 1 ";
        }
        if ($orderstatus > 1) {
            if($orderstatus  == 4) {
                $where .= " and  orderstatus IN (1,2) ";
            } else if($orderstatus  == 8) {
                $where .= " and  orderstatus IN (3,4) ";
            }else if($orderstatus  == 6) {
                $where .= " and  orderstatus IN (3) ";
            }else {
                $where .= " and  orderstatus = $orderstatus ";
            }
        }

        if ($type == 1) {
            //卖家
            $sdata = $Shop->where(array("user_id" => $uid))->find();
            if($sdata == null) {
                $res = [
                    'code' => 200,
                    'msg' => "未查询到卖家数据"
                ];
                self::echoJson($res);
            }
            $gdata = $Goods->where(array("shop_id" => $sdata["id"]))->select();
            $goods_idx = "";
            if(count($gdata) > 0) {
                foreach($gdata as $k => $v) {
                    $goods_idx .= $v["id"].",";
                }
                $goods_idx = trim($goods_idx,",");
                $where .= " and  goods_id in ('".$goods_idx."') ";
            } else {
                $where .= " and  goods_id = 0 ";
            }
        }
        $data = $Order->where($where)->order("id desc")->select();
        if ($data === null) {
            // 未查询到数据
            $res = [
                'code' => 200,
                'msg' => "未查询到数据"
            ];
        } else {
            foreach ($data as $key => $val) {
                $data[$key]["goods"] = $Goods->where("id = ".$val["goods_id"])->find();
                $userInfo = $UserDetail->where("user_id = ".$val["user_id"])->find();
                $data[$key]["avatar"] = $userInfo["avatar"];
            }
            // 查询成功
            $res = [
                'code' => 200,
                'msg' => '成功',
                'data' => $data,
            ];
        }
        self::echoJson($res);
    }

    public function address() {
        // 实例化Model类
        $uid = self::getToken();
        $Address = new \Common\Model\PtuanAddressModel();

        // 组装数据
        $data = [
            'receiver'          => @$_REQUEST["receiver"],
            'phone'          => @$_REQUEST["phone"],
            'area'          => @$_REQUEST["area"],
            'address'          => @$_REQUEST["address"],
            'tag'          => @$_REQUEST["tag"],
            'user_id'  => $uid,
            'isDefault'          => @$_REQUEST["isDefault"],
        ];
        // 入库
        $res = $Address->add($data);
        if ($res) {
            $res = [
                'code' => 200,
                'msg' => '成功',
                'data' => $data,
            ];
        } else {
            $res = [
                'code' => 500,
                'msg' => '系统出错'
            ];
        }
        self::echoJson($res);
    }

    public function getAddress() {
        // 实例化Model类
        $uid = self::getToken();
        $Address = new \Common\Model\PtuanAddressModel();

        // 入库
        $res = $Address->where(array("user_id" => $uid))->order('id desc')->find();
        if ($res) {
            $res = [
                'code' => 200,
                'msg' => '成功',
                "data" => $res
            ];
        } else {
            $res = [
                'code' => 200,
                'msg' => 'empty'
            ];
        }
        self::echoJson($res);
    }

    public function upload()
    {
        self::getToken();
        $goodsimg = null;
        if(!empty($_FILES['goodsimg']['name']))
        {
            $config = array(
                'mimes'         =>  array(), //允许上传的文件MiMe类型
                'maxSize'       =>  1024*1024*4, //上传的文件大小限制 (0-不做限制)
                'exts'          =>  array('jpg', 'gif', 'png', 'jpeg'), //允许上传的文件后缀
                'subName'       =>  '', //子目录创建方式，为空
                'rootPath'      =>  './Public/Upload/GoodsCat/', //保存根路径
                'savePath'      =>  '', //保存路径
                'saveExt'       =>  '', //文件保存后缀，空则使用原后缀
            );
            $upload = new \Think\Upload($config);
            // 上传单个文件
            $info = $upload->uploadOne($_FILES['goodsimg']);
            if(!$info) {
                // 上传错误提示错误信息
                $this->error($upload->getError());
            }else{
                // 上传成功
                // 文件完成路径
                $filepath=$config['rootPath'].$info['savepath'].$info['savename'];
                $goodsimg= substr($filepath,1);
            }
        }
        if ($goodsimg === null) {
            // 未查询到数据
            $res = [
                'code' => 500,
                'msg' => "未上传"
            ];
        } else {
            // 查询成功
            $res = [
                'code' => 200,
                'msg' => '成功',
                'data' => $goodsimg,
            ];
        }
        self::echoJson($res);
    }

    public function upImgs()
    {
        $img = $_REQUEST["goodsimg"];
        //$img为传入字符串
        $path = 'Public/Upload/GoodsCat/';
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $img, $result)){
            $type = $result[2];
            $new_file = $path."/";
            if(!file_exists($new_file)){
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file, 0700);
            }
            $new_file = $new_file.date("YmdHis").time().".{$type}";
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $img)))){
                self::echoJson($res = [
                    'code' => 200,
                    'msg' => '成功',
                    'data' => '/'.$new_file,
                ]);
            }else{
                return false;
            }
        }
    }

    public function sms()
    {
        $phone = trim($_REQUEST["phone"]);
        if ($phone)
        {
            if(is_phone($phone))
            {
                //发送手机短信
                $sms=new \Common\Model\SmsModel();
                $content="@1@=".rand(1000,9999);
                $res=$sms->sendMessage($phone, $content, 'default');
            } else {
                //手机号码格式不正确
                $res=array(
                    'code'=>$this->ERROR_CODE_COMMON['PARAMETER_ERROR'],
                    'msg'=>'手机号码格式不正确'
                );
            }
        }else {
            //参数不正确，参数缺失
            $res=array(
                'code'=>$this->ERROR_CODE_COMMON['PARAMETER_ERROR'],
                'msg'=>$this->ERROR_CODE_COMMON_ZH[$this->ERROR_CODE_COMMON['PARAMETER_ERROR']]
            );
        }
        echo json_encode ($res,JSON_UNESCAPED_UNICODE);
    }


    private static function echoJson($res)
    {
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        exit;
    }

}