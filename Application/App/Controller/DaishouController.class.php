<?php

namespace App\Controller;

use App\Common\Controller\AuthController;

class DaishouController extends AuthController
{
    public $gaodeapi = "https://restapi.amap.com/v3/";

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

    public function shop()
    {
        // 实例化Model类
        $Model = new \Common\Model\DaishouShopModel();

        $location = $_REQUEST["location"];
        $type = $_REQUEST["type"];

        $where = array();
        $data = $Model->where($where)->select();

        if(count($data) > 0) {
            foreach ($data as $k => $val) {
                //$data[$k]["img"] = $this->HOSTURL.$data[$k]["img"];
                if($location != null || $location != "") {
                    $port = $this->gaodeapi."direction/driving?output=JSON&key=8dbe868eaaeec8eb6869a8bd9f00d0f2&origin=$location&destination=".$val["location"]."&extensions=all";
                    $juliArr = $this->postUrl($port,array());
                    $data[$k]["meter"] = @$juliArr["route"]["paths"][0]["distance"];
                } else {
                    $data[$k]["meter"]  = 0;
                }

            }
            if($location != null || $location != "") {
                $data = $this->arrSort($data,"meter","asc");
            }
        }

        // 查询成功
        $res = array(
            'code'=>0,
            'msg'=>'成功',
            'data'=>array_values($data),
        );
        self::echoJson($res);

    }

    public function order()
    {
        // 实例化Model类
        $Model = new \Common\Model\DaishouOrderModel();
        $Log = new \Common\Model\DaishouOrderLogModel();

        $uid = self::getToken();
        $show = $_REQUEST["show"];
        $status = $_REQUEST["status"];
        $orderSn = $_REQUEST["ordersn"];
        $shopid = $_REQUEST["shopid"];
        $type = $_REQUEST["type"];

        $where["uid"] = $uid;
        if($orderSn != "" || $orderSn != null) {
            $where["ordersn"] = $orderSn;
        }
        if($type != null) {
            $where["type"] = $type;
        }
        if($type == 1) {
            if($status != null) {
                $where["status1"] = $status;
            }
        }
        if($type ==2) {
            if($status != null) {
                $where["status2"] = $status;
            }
        }
        if($shopid != null) {
            $where["shopid"] = $shopid;
        }
        if($show == "index") {
            $data = $Model->where($where)->where("status1 < 4")->order("id desc")->select();
        } else {
            if($shopid != null) {
                $data = $Model->where($where)->where("status1 < 4 and gettype != 2 ")->order("id desc")->select();
            } else {
                $data = $Model->where($where)->order("id desc")->select();
            }
        }

        if(count($data) > 0) {
            foreach ($data as $k => $v) {
                if($v["type"] == 1) {
                    $data[$k]["status"] = $v["status1"];
                    if( $v["status1"] == 0) {
                        $data[$k]["statusdesc"] = "包裹到店";
                    }
                    if( $v["status1"] == 1) {
                        $data[$k]["statusdesc"] = "已缴费";
                    }
                    if( $v["status1"] == 2) {
                        $data[$k]["statusdesc"] = "包裹到店";
                    }
                    if( $v["status1"] == 3) {
                        $data[$k]["statusdesc"] = "派送中";
                    }
                    if( $v["status1"] == 4 ){
                        $data[$k]["statusdesc"] = "已送达";
                    }
                    if( $v["status1"] == 5 ){
                        $data[$k]["statusdesc"] = "已完成";
                    }
                }
                if($v["type"] == 2) {
                    $data[$k]["status"] = $v["status2"];
                    if( $v["status2"] == 0) {
                        $data[$k]["statusdesc"] = "包裹到店";
                    }
                    if( $v["status2"] == 1) {
                        $data[$k]["statusdesc"] = "已缴费";
                    }
                    if( $v["status2"] == 2) {
                        $data[$k]["statusdesc"] = "包裹到店";
                    }
                    if( $v["status2"] == 3) {
                        $data[$k]["statusdesc"] = "派送中";
                    }
                    if( $v["status2"] == 4 ){
                        $data[$k]["statusdesc"] = "已送达";
                    }
                    if( $v["status2"] == 5 ){
                        $data[$k]["statusdesc"] = "已完成";
                    }
                }
                $orderInfo = $Log->where(array("ordersn" => $v["ordersn"]))->order("id desc")->select();
                if(count($orderInfo) > 0) {
                    foreach($orderInfo as $k1 => $v1) {
                        $orderInfo[$k1]["statusdesc"] = "";
//                        if( $v1["status1"] == 0) {
//                            $orderInfo[$k1]["statusdesc"] = "包裹到店";
//                        }
//                        if( $v1["status1"] == 1) {
//                            $orderInfo[$k1]["statusdesc"] =  "已缴费";
//                        }
//                        if( $v1["status1"] == 2) {
//                            $orderInfo[$k1]["statusdesc"] =  "包裹到店";
//                        }
//                        if( $v1["status1"] == 3) {
//                            $orderInfo[$k1]["statusdesc"] =  "派送中";
//                        }
//                        if( $v1["status1"] == 4 ){
//                            $orderInfo[$k1]["statusdesc"] =  "已送达";
//                        }
//                        if( $v1["status1"] == 5 ){
//                            $orderInfo[$k1]["statusdesc"] =  "已完成";
//                        }
                    }
                }
                $data[$k]["detail"] = $orderInfo;
            }
        }
        $res = array(
            'code'=>0,
            'msg'=>'成功',
            'data'=>array_values($data),
        );

        $this->echoJson($res);
    }

    //增加代收
    public function addDaishou()
    {
        // 实例化Model类
        $Model = new \Common\Model\DaishouOrderModel();
        $Log = new \Common\Model\DaishouOrderLogModel();

        $uid = self::getToken();
        $shopid = $_REQUEST["shopid"];
        $address_id = $_REQUEST["address_id"];
        $size = $_REQUEST["size"];
        $fee = $_REQUEST["fee"];

        $ordersn = "1".$uid.time().rand(100,999);
        //扣去余额

        $Model->add(array(
            "uid" => $uid,
            "ordersn" => $ordersn,
            "shopid" => $shopid,
            "type" => 1,
            "address" => $address_id,
            "size" => $size,
            "fee" => $fee,
            "status1" => 1,
            "addtime" => date("Y-m-d H:i:s")
        ));
        $Log->add(array(
            "uid" => $uid,
            "ordersn" => $ordersn,
            "status" => 1,
            "remark" => "订单".$ordersn."下单成功",
            "addtime" => date("Y-m-d H:i:s")
        ));
        self::echoJson(array("code" => 0,"data" => array(),"msg" =>  "success"));
    }


    public function addDaiji()
    {
        // 实例化Model类
        $Model = new \Common\Model\DaishouOrderModel();
        $Log = new \Common\Model\DaishouOrderLogModel();

        $uid = self::getToken();
        $shopid = $_REQUEST["shopid"];
        $address_id = $_REQUEST["address_id"];
        $saddress_id = $_REQUEST["saddress_id"];
        $size = $_REQUEST["size"];
        $fee = $_REQUEST["fee"];

        $ordersn = "2".$uid.time().rand(100,999);
        //扣去余额

        $Model->add(array(
            "uid" => $uid,
            "ordersn" => $ordersn,
            "shopid" => $shopid,
            "type" => 2,
            "saddress_id" => $saddress_id,
            "address" => $address_id,
            "size" => $size,
            "fee" => $fee,
            "status1" => 1,
            "addtime" => date("Y-m-d H:i:s")
        ));
        $Log->add(array(
            "uid" => $uid,
            "ordersn" => $ordersn,
            "status" => 1,
            "remark" => "订单".$ordersn."下单成功",
            "addtime" => date("Y-m-d H:i:s")
        ));
        self::echoJson(array("code" => 0,"data" => array(),"msg" =>  "success"));
    }

    public function arrSort($array,$key,$order="asc"){//asc是升序 desc是降序
        $arr_nums=$arr=array();
        foreach($array as $k=>$v){
            $arr_nums[$k]=$v[$key];
        }
        if($order=='asc'){
            asort($arr_nums);
        }else{
            arsort($arr_nums);
        }
        foreach($arr_nums as $k=>$v){
            $arr[$k]=$array[$k];
        }
        return $arr;
    }

    /**
     * @title 提货到家
     * @author loveAKY
     * @date 2020-7-22 15:38
     */
    public function pickGoodsHome(){

        $Log = new \Common\Model\DaishouOrderLogModel();

        $uid = self::getToken();
        $order = I('order');
        $store_id = I('store');
        $addr_id = I('addr');

        if(empty($order)||empty($store_id)||empty($addr_id)||empty($uid)){
            self::echoJson(array("code" => 1,"data" => array(),"msg" =>  "参数缺失"));
        }


        $Model = new \Common\Model\DaishouOrderHomeModel();

        $map['order'] = $order;

        //订单重复判断
        $sql = 'select * from dmooo_daishou_order where `id` in ('.$order.') and  gettype = 2;' ;

        $res = M()->execute($sql);

        if($res){
            self::echoJson(array("code" => 1,"data" => array(),"msg" =>  "该订单已处理,禁止重复处理"));
        }

        $data = array(
            "uid" => $uid,
            "order" => $order,
            "store_id" => $store_id,
            "addr_id" => $addr_id,
            "ctime" => date('Y-m-d H:i:s')
        );

        $Model->add($data);

        $sql = 'UPDATE dmooo_daishou_order SET gettype=2 where `id` in ('.$order.')';
        $res = M()->execute($sql);

        if($res){
            $orderArr = explode(',',$order);
            $Model = new \Common\Model\DaishouOrderModel();
            $orderSnStr = "";
            foreach($orderArr as $oid) {
                $orderInfo = $Model->where("id = $oid")->find();
                if(count($orderInfo) > 0) {
                    $Log->add(array(
                        "uid" => $uid,
                        "ordersn" => $orderInfo["ordersn"],
                        "status" => 1,
                        "remark" => "订单".$orderInfo["ordersn"]."改为提货到家",
                        "addtime" => date("Y-m-d H:i:s")
                    ));
                    $orderSnStr = $orderInfo["ordersn"];
                }
            }

            self::echoJson(array("code" => 0,"data" => array(
                "ordersn" => $orderSnStr
            ),"msg" =>'送货到家订单记录完成'));
        }
        self::echoJson(array("code" => 1,"data" => array(),"msg" =>  "送货到家订单完成失败"));
    }

    /**
     * @title 价格计算器
     * @author loveAKY
     * @date 2020-7-23 11:30
     */
    public function priceCount(){
        $W = I('w');//宽
        $H = I('h');//高
        $L = I('l');//长
        $weight = I('weight');//重量

        if(empty($W)){
            self::echoJson(array("code" => 1,"data" => array(),"msg" =>  "宽度不能为0"));
        }

        if(empty($H)){
            self::echoJson(array("code" => 1,"data" => array(),"msg" =>  "高度不能为0"));
        }

        if(empty($L)){
            self::echoJson(array("code" => 1,"data" => array(),"msg" =>  "长度不能为0"));
        }

        if(empty($weight)){
            self::echoJson(array("code" => 1,"data" => array(),"msg" =>  "重量不能为0"));
        }

        //费用配置 size:大小范围 price:首重价格(首重统一1kg) price_c:续重价格(1kg)
        $config = [
            ['size'=>30,'price'=>5,'price_c'=>2,'title'=>'特细'],
            ['size'=>45,'price'=>6,'price_c'=>2,'title'=>'细型'],
            ['size'=>60,'price'=>7,'price_c'=>2,'title'=>'细型'],
            ['size'=>75,'price'=>8,'price_c'=>2,'title'=>'中小'],
            ['size'=>90,'price'=>9,'price_c'=>2,'title'=>'中小'],
            ['size'=>105,'price'=>10,'price_c'=>2,'title'=>'中型'],
            ['size'=>120,'price'=>11,'price_c'=>2,'title'=>'中型'],
            ['size'=>135,'price'=>12,'price_c'=>2,'title'=>'中大'],
            ['size'=>150,'price'=>13,'price_c'=>2,'title'=>'中大'],
            ['size'=>165,'price'=>14,'price_c'=>2,'title'=>'大型'],
            ['size'=>180,'price'=>15,'price_c'=>2,'title'=>'大型'],
            ['size'=>195,'price'=>16,'price_c'=>2,'title'=>'特大'],
            ['size'=>210,'price'=>17,'price_c'=>2,'title'=>'特大'],
            ['size'=>225,'price'=>18,'price_c'=>2,'title'=>'巨大'],
            ['size'=>240,'price'=>19,'price_c'=>2,'title'=>'巨大']
//            ['size'=>240,'price'=>20,'price_c'=>2,'title'=>'巨大']//每15cm+1元首重价格
        ];

        $size = $W+$L+$H;//大小

        //中大~巨大,实际重量>5KG,且对比较轻计算体积重量=(长x宽x高)/6000
        if($size>121&&$weight>5){

            $ht = ($W*$L*$H)/6000;

            if($ht>$weight){

                $weight = $ht;

            }

        }

        $weight  = ceil($weight);//重量 进一法取整
        $size    = ceil($size);//大小 进一法取整
        $price   = 0;
        $price_c = 0;

        if($size>240){
            $price   = ceil($size/15);
            $price_c = 2;
        }else{
            foreach ($config as $k=>$v){
                if($price == 0){
                    if($size<$v['size']){
                        if($k == 0){
                            $price   = $v['price'];
                            $price_c = $v['price_c'];
                        }else{
                            $price   = $config[$k-1]['price'];
                            $price_c = $config[$k-1]['price_c'];
                        }
                    }
                }
            }
        }

        $fee = (($weight-1)*$price_c)+$price;

        self::echoJson(array("code" => 0,"data" => array('fee'=>$fee),"msg" =>  "计算成功"));
    }

    /**
     * @title 收货订单评价
     * @author loveAKY
     * @time 2020-7-23
     */
    public function addBbs(){

        $model =  new \Common\Model\DaishouOrderBbsModel();
        $Model2 = new \Common\Model\DaishouOrderModel();

        $data['order']   = I('order');
        $data['uid']     = self::getToken();
        $data['label']   = I('label');
        $data['score']   = I('score');
        $data['content'] = I('content');
        $data['ctime']   = date('Y-m-d H:i:s');

        //$data['label']   = ex(',',$data['label']);


        if(in_array('',$data)){
            self::echoJson(array("code" => 1,"data" => array(),"msg" =>  "参数缺失"));
        }

        $model->add($data);

        // 组装数据
        $data = array("isbbs" => 1);
        // 入库
        $Model2->where("ordersn = ".I('order'))->save($data);

        $Log = new \Common\Model\DaishouOrderLogModel();
        $Log->add(array(
            "uid" => $data['uid'],
            "ordersn" => $data['order'],
            "status" => 5,
            "remark" => "订单".$data['order']."已评价",
            "addtime" => date("Y-m-d H:i:s")
        ));

        self::echoJson(array("code" => 0,"data" => array(),"msg" =>  "评价成功"));
    }

    /**
     * @title 查看评价
     * @author loveAKY
     * @time 2020-7-23 17:42
     */
    public function bbsList(){

        // 实例化Model类
        $Model = new \Common\Model\DaishouOrderBbsModel();

        $order = I('order');

        if(!$order){
            self::echoJson(array("code" => 1,"data" => array(),"msg" =>  "参数缺失"));
        }

        $where = array(
            'order'=>$order
        );

        // 查询数据
        $data = $Model->where($where)->order('id desc')->find();

        if($data['label']){
            $data['label'] = explode(',',$data['label']);
        }

        self::echoJson(array('code'=>0,'data'=>array($data),'msg'=>'获取成功'));
    }

    public function recharge()
    {
        $uid = self::getToken();
        $img = $_REQUEST["img"];
        $money = $_REQUEST["money"];

        $Model=new \Common\Model\DaishouRechageModel();
        $Log = new \Common\Model\DaishouLogModel();

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
                $Model->add(array(
                    "uid" => $uid,
                    "money" =>$money,
                    "img" => $imgs,
                    "action" => "",
                    "status" => 0,
                    "addtime" => date("Y-m-d H:i:s")
                ));
                $Log->add(array(
                    "uid" => $uid,
                    "money" => $money,
                    "remark" => "用户".$uid."充值提交充值".$money."转账凭证待审核",
                    "action" => "recharge",
                    "byadmin" => 0,
                    "addtime" => date("Y-m-d H:i:s")
                ));
                self::echoJson(array("code" => 0,"data" => array(),"msg" => "success"));

            }
        }
        self::echoJson(array("code" => 1000,"data" => array(),"msg" => "系统错误"));
    }

    public function rechargeLog()
    {
        // 实例化Model类
        $Model=new \Common\Model\DaishouRechageModel();
        $uid = self::getToken();

        $where = array(
            "uid" => $uid
        );
        $data = $Model->where($where)->select();

        if(count($data) > 0) {
            foreach($data as $key => $val) {
                $data[$key]["img"] = $this->HOSTURL.$val["img"];
            }
        }

        // 查询成功
        $res = array(
            'code'=>0,
            'msg'=>'成功',
            'data'=>array_values($data),
        );
        self::echoJson($res);
    }

    public function activity(){

        // 实例化Model类
        $Model = new \Common\Model\DaishouActivityModel();

        $where = array(
        );
        // 查询数据
        $data = $Model->where($where)->order('id desc')->select();
        self::echoJson(array('code'=>0,'data'=>$data,'msg'=>'success'));
    }

}