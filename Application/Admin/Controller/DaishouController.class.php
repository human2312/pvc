<?php

namespace Admin\Controller;
use Admin\Common\Controller\AuthController;

use Think\Model;

class DaishouController extends AuthController
{
    public function index()
    { 
        // 实例化Model类
        $Model = new \Common\Model\DaishouShopModel();
        $Page = new \Common\Model\PageModel();


        $where = array();

        // 查询数据条数
        $count = $Model->where($where)->count();

        // 分页显示输出
        $per = 15;
        if ($_GET['p']) {
            $p = $_GET['p'];
        } else {
            $p = 1;
        }
        $page = $Page->show($count,$per);

        // 查询数据
        $data = $Model->where($where)->order('id desc')->page($p.','.$per)->select();

        if(count($data) > 0) {
            foreach($data as $k => $v) {

            }
        }

        // 模板渲染
        $this->assign('list', $data);
        $this->assign('page', $page);
        $this->display();
    }

    public function addshop()
    {
        // 实例化Model类
        $Model = new \Common\Model\DaishouShopModel();

        if (I('POST.')) {
            layout(false);

            //上传文件
            $img = "";
            if(!empty($_FILES['img']['name']))
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
                $info = $upload->uploadOne($_FILES['img']);
                if(!$info) {
                    // 上传错误提示错误信息
                    $this->error($upload->getError());
                }else{
                    // 上传成功
                    // 文件完成路径
                    $filepath=$config['rootPath'].$info['savepath'].$info['savename'];
                    $img=substr($filepath,1);
                }
            }

            $city = "";

            $locationaddress = I('POST.province').I('POST.city').I('POST.county').I('POST.address');
            if(strpos($locationaddress,'珠海') !== false){
                $city = "珠海市";
            }
            if(strpos($locationaddress,'澳门') !== false){
                $city = "澳门特别行政区";
            }

            $port = $this->gaodeapi."&city=$city&address=".I('POST.province').I('POST.city').I('POST.county').I('POST.address');

            $res = $this->postUrl($port,array());
            $location = "";
            if($res != null) {
                $location = @$res["geocodes"][0]["location"];
            }

            // 组装数据
            $data = array(
                'name'          => I('POST.name'),
                'dsname'          => I('POST.dsname'),
                'tel'          => I('POST.tel'),
                'province'    => I('POST.province'),
                'city'    => I('POST.city'),
                'county'    => I('POST.county'),
                'address'    => I('POST.address'),
                'location'     => $location,
                'img'       => $img,
                'addtime'      => date("Y-m-d H:i:s")
            );
            // 入库
            $res = $Model->add($data);
            if ($res) {
                $this->success('添加成功',U('index'));
            } else {
                $this->error('系统出错，请重试');
            }

        } else {
            $this->display();
        }
    }

    public function editshop($id)
    {
        // 实例化Model类
        $Model = new \Common\Model\DaishouShopModel();

        $data = $Model->where("id = $id")->find();

        if (I('POST.')) {
            layout(false);

            //上传文件
            $img = "";
            if(!empty($_FILES['img']['name']))
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
                $info = $upload->uploadOne($_FILES['img']);
                if(!$info) {
                    // 上传错误提示错误信息
                    $this->error($upload->getError());
                }else{
                    // 上传成功
                    // 文件完成路径
                    $filepath=$config['rootPath'].$info['savepath'].$info['savename'];
                    $img=substr($filepath,1);
                }
            }

            $city = "";
            $locationaddress = I('POST.province').I('POST.city').I('POST.county').I('POST.address');
            if(strpos($locationaddress,'珠海') !== false){
                $city = "珠海市";
            }
            if(strpos($locationaddress,'澳门') !== false){
                $city = "澳门特别行政区";
            }

            $port = $this->gaodeapi."&city=$city&address=".I('POST.province').I('POST.city').I('POST.county').I('POST.address');

            $res = $this->postUrl($port,array());
            $location = "";
            if($res != null) {
                $location = @$res["geocodes"][0]["location"];
            }

            // 组装数据
            $data = array(
                'name'          => I('POST.name'),
                'dsname'          => I('POST.dsname'),
                'tel'          => I('POST.tel'),
                'province'    => I('POST.province'),
                'city'    => I('POST.city'),
                'county'    => I('POST.county'),
                'address'    => I('POST.address'),
                'location'     => $location,
                'img'       => $img
            );
            // 入库
            $res = $Model->where(array("id" => $id))->save($data);
            if ($res) {
                $this->success('添加成功',U('index'));
            } else {
                $this->error('系统出错，请重试');
            }

        } else {

            // 模板渲染
            $this->assign('data', $data);
            $this->assign('id', $id);
            $this->display();
        }
    }

    public function daishouorder()
    {
        // 实例化Model类
        $Model = new \Common\Model\DaishouOrderModel();
        $Page = new \Common\Model\PageModel();
        $User = new \Common\Model\UserDetailModel();
        $Shop = new \Common\Model\DaishouShopModel();
        $User2 = new \Common\Model\UserModel();

        $where["type"] = 1;

        $phone = $_REQUEST["phone"];
        if($phone != null) {
            $udata = $User2->where(array("phone" => $phone))->find();
            if(count($udata) > 0) {
                $where["uid"] = @$udata["uid"];
            } else {
                $where["uid"] = 0;
            }
        }
        $uid = $_REQUEST["uid"];
        if($uid != null) {
            $where["uid"] = $uid;
        }
        $code = $_REQUEST["code"];
        if($code != null) {
            $where["code"] = $code;
        }
        $fromsn = $_REQUEST["fromsn"];
        if($fromsn != null) {
            $where["fromsn"] = $fromsn;
        }


        // 查询数据条数
        $count = $Model->where($where)->count();

        // 分页显示输出
        $per = 15;
        if ($_GET['p']) {
            $p = $_GET['p'];
        } else {
            $p = 1;
        }
        $page = $Page->show($count,$per);

        // 查询数据
        $data = $Model->where($where)->where("status1 < 4")->order('id desc')->page($p.','.$per)->select();


        if(count($data) > 0) {
            foreach($data as $k => $v) {
                $udata = $User->where(array("user_id" => $v["uid"]))->find();
                $data[$k]["username"] = $udata["nickname"];
                $sdata = $Shop->where(array("id" => $v["shopid"]))->find();
                $data[$k]["shopname"] = $sdata["name"];
            }
        }

        // 模板渲染
        $this->assign('list', $data);
        $this->assign('page', $page);
        $this->display();
    }

    public function daishouorder2()
    {
        // 实例化Model类
        $Model = new \Common\Model\DaishouOrderModel();
        $Page = new \Common\Model\PageModel();
        $User = new \Common\Model\UserDetailModel();
        $Shop = new \Common\Model\DaishouShopModel();
        $User2 = new \Common\Model\UserModel();

        $where["type"] = 1;

        $phone = $_REQUEST["phone"];
        if($phone != null) {
            $udata = $User2->where(array("phone" => $phone))->find();
            if(count($udata) > 0) {
                $where["uid"] = @$udata["uid"];
            } else {
                $where["uid"] = 0;
            }
        }
        $uid = $_REQUEST["uid"];
        if($uid != null) {
            $where["uid"] = $uid;
        }
        $code = $_REQUEST["code"];
        if($code != null) {
            $where["code"] = $code;
        }
        $fromsn = $_REQUEST["fromsn"];
        if($fromsn != null) {
            $where["fromsn"] = $fromsn;
        }


        // 查询数据条数
        $count = $Model->where($where)->count();

        // 分页显示输出
        $per = 10000;
        if ($_GET['p']) {
            $p = $_GET['p'];
        } else {
            $p = 1;
        }

        // 查询数据
        $data = $Model->where($where)->where("status1 < 4")->order('id desc')->page($p.','.$per)->select();


        if(count($data) > 0) {
            foreach($data as $k => $v) {
                $udata = $User->where(array("user_id" => $v["uid"]))->find();
                $data[$k]["username"] = $udata["nickname"];
                $sdata = $Shop->where(array("id" => $v["shopid"]))->find();
                $data[$k]["shopname"] = $sdata["name"];
            }
        }

        // 模板渲染
        $this->assign('list', $data);
        $this->display();
    }

    public function doneorder()
    {
        // 实例化Model类
        $Model = new \Common\Model\DaishouOrderModel();
        $Page = new \Common\Model\PageModel();
        $User = new \Common\Model\UserDetailModel();
        $Shop = new \Common\Model\DaishouShopModel();
        $User2 = new \Common\Model\UserModel();

        $where["type"] = 1;

        $phone = $_REQUEST["phone"];
        if($phone != null) {
            $udata = $User2->where(array("phone" => $phone))->find();
            if(count($udata) > 0) {
                $where["uid"] = @$udata["uid"];
            } else {
                $where["uid"] = 0;
            }
        }
        $code = $_REQUEST["code"];
        if($code != null) {
            $where["code"] = $code;
        }
        $fromsn = $_REQUEST["fromsn"];
        if($fromsn != null) {
            $where["fromsn"] = $fromsn;
        }


        // 查询数据条数
        $count = $Model->where($where)->count();

        // 分页显示输出
        $per = 15;
        if ($_GET['p']) {
            $p = $_GET['p'];
        } else {
            $p = 1;
        }
        $page = $Page->show($count,$per);

        // 查询数据
        $data = $Model->where($where)->where("status1 >= 4")->order('id desc')->page($p.','.$per)->select();

        if(count($data) > 0) {
            foreach($data as $k => $v) {
                $udata = $User->where(array("user_id" => $v["uid"]))->find();
                $data[$k]["username"] = $udata["nickname"];
                $sdata = $Shop->where(array("id" => $v["shopid"]))->find();
                $data[$k]["shopname"] = $sdata["name"];
            }
        }

        // 模板渲染
        $this->assign('list', $data);
        $this->assign('page', $page);
        $this->display();
    }



    public function inorder()
    {
        // 实例化Model类
        $Model = new \Common\Model\DaishouOrderModel();
        $Page = new \Common\Model\PageModel();
        $User = new \Common\Model\UserDetailModel();
        $Shop = new \Common\Model\DaishouShopModel();
        $User2 = new \Common\Model\UserModel();

        $where["type"] = 1;

        $phone = $_REQUEST["phone"];
        if($phone != null) {
            $udata = $User2->where(array("phone" => $phone))->find();
            if(count($udata) > 0) {
                $where["uid"] = @$udata["uid"];
            } else {
                $where["uid"] = 0;
            }
        }
        $Shelf = $_REQUEST["Shelf"];
        if($Shelf != null) {
            $where["Shelf"] = $Shelf;
        }
        $fromsn = $_REQUEST["fromsn"];
        if($fromsn != null) {
            $where["fromsn"] = $fromsn;
        }


        // 查询数据条数
        $count = $Model->where($where)->count();

        // 分页显示输出
        $per = 15;
        if ($_GET['p']) {
            $p = $_GET['p'];
        } else {
            $p = 1;
        }
        $page = $Page->show($count,$per);

        // 查询数据
        $data = $Model->where($where)->order('id desc')->page($p.','.$per)->select();

        if(count($data) > 0) {
            foreach($data as $k => $v) {
                $udata = $User->where(array("user_id" => $v["uid"]))->find();
                $data[$k]["username"] = $udata["nickname"];
                $sdata = $Shop->where(array("id" => $v["shopid"]))->find();
                $data[$k]["shopname"] = $sdata["name"];
            }
        }

        // 模板渲染
        $this->assign('list', $data);
        $this->assign('page', $page);
        $this->display();
    }

    public function daijiorder()
    {
        // 实例化Model类
        $Model = new \Common\Model\DaishouOrderModel();
        $Page = new \Common\Model\PageModel();
        $User = new \Common\Model\UserDetailModel();
        $Shop = new \Common\Model\DaishouShopModel();
        $User2 = new \Common\Model\UserModel();

        $where["type"] = 2;

        $phone = $_REQUEST["phone"];
        if($phone != null) {
            $udata = $User2->where(array("phone" => $phone))->find();
            if(count($udata) > 0) {
                $where["uid"] = @$udata["uid"];
            } else {
                $where["uid"] = 0;
            }
        }
        $code = $_REQUEST["code"];
        if($code != null) {
            $where["code"] = $code;
        }
        $fromsn = $_REQUEST["fromsn"];
        if($fromsn != null) {
            $where["fromsn"] = $fromsn;
        }

        // 查询数据条数
        $count = $Model->where($where)->count();

        // 分页显示输出
        $per = 15;
        if ($_GET['p']) {
            $p = $_GET['p'];
        } else {
            $p = 1;
        }
        $page = $Page->show($count,$per);

        // 查询数据
        $data = $Model->where($where)->order('id desc')->page($p.','.$per)->select();

        if(count($data) > 0) {
            foreach($data as $k => $v) {
                $udata = $User->where(array("user_id" => $v["uid"]))->find();
                $data[$k]["username"] = $udata["nickname"];
                $sdata = $Shop->where(array("id" => $v["shopid"]))->find();
                $data[$k]["shopname"] = $sdata["name"];
            }
        }

        // 模板渲染
        $this->assign('list', $data);
        $this->assign('page', $page);
        $this->display();
    }


    //  代收入库
    public function adddaishou()
    {

        // 实例化Model类
        $Model = new \Common\Model\DaishouOrderModel();
        $Log = new \Common\Model\DaishouOrderLogModel();

        if (I('POST.')) {
            layout(false);

            $ordersn = "1".date("YmdHis").rand(100,999);

            // 组装数据
            $data = array(
                'ordersn'  => $ordersn,
                'fromsn'          => I('POST.fromsn'),
                'name'          => I('POST.name'),
                'amount'          => I('POST.amount'),
                'fee'          => I('POST.fee'),
                'L'          => I('POST.L'),
                'W'          => I('POST.W'),
                'H'          => I('POST.H'),
                'weight'          => I('POST.weight'),
                'Shelf'          => I('POST.shelf'),
                'size'          => I('POST.size'),
                'shopid'          => I('POST.shopid'),
                'shopremark'          => I('POST.shopremark'),
                'uid'          => I('POST.uid'),
                'code'         =>  rand(100000,666666),
                'addtime'      => date("Y-m-d H:i:s")
            );

            // 入库
            $res = $Model->add($data);

            $Log->add(array(
                "uid" => I('POST.uid'),
                "ordersn" => $ordersn,
                "status" => 0,
                "remark" => "包裹单号". I('POST.fromsn')."到达仓库",
                "addtime" => date("Y-m-d H:i:s")
            ));

            if ($res) {
                $UserOauth=new \Common\Model\UserOauthModel();
                $res_exist = $UserOauth->where("user_id='".I('POST.uid')."'")->find();
                if(count($res_exist) > 0) {
                    Vendor('pay.wxpay','','.class.php');
                    //①、获取用户openid
                    $wxpay=new \wxpay();
                    $touser = $res_exist["openid"];
                    $status = "包裹到店";
                    $ye =  I('POST.fromsn');
                    $name =  I('POST.name');
                    $res = $wxpay->PushMessage($touser,$status,$ye,$name);
                    if($res["errcode"] == 0) {
                        // 组装数据
                        $data = [
                            'sms'          => 1
                        ];
                        // 入库
                        $Model->where("ordersn = $ordersn")->save($data);
                    }
                }

                echo "<script language=JavaScript> location.replace(location.href);</script>";exit;
                $this->success('添加成功',U('adddaishou'));
            } else {
                $this->error('系统出错，请重试');
            }

        } else {
            $this->display();
        }
    }

    //  代收入库
    public function editdaishou($id)
    {
        // 实例化Model类
        $Model = new \Common\Model\DaishouOrderModel();
        $data = $Model->where("id = $id")->find();

        if (I('POST.')) {
            layout(false);
            $id = I('POST.id');
            // 组装数据
            $data = array(
                'fromsn'          => I('POST.fromsn'),
                'name'          => I('POST.name'),
                'amount'          => I('POST.amount'),
                'fee'          => I('POST.fee'),
                'L'          => I('POST.L'),
                'W'          => I('POST.W'),
                'H'          => I('POST.H'),
                'weight'          => I('POST.weight'),
                'Shelf'          => I('POST.shelf'),
                'size'          => I('POST.size'),
                'shopid'          => I('POST.shopid'),
                'shopremark'          => I('POST.shopremark'),
                'uid'          => I('POST.uid')
            );
            // 入库
            $res = $Model->where("id = $id")->save($data);

            if ($res) {
                $this->success('添加成功',U('daishouorder'));
            } else {
                $this->error('系统出错，请重试');
            }

        } else {

            // 模板渲染
            $this->assign('data', $data);
            $this->assign('id', $id);
            $this->display();
        }
    }

    public function orderlog()
    {
        // 实例化Model类
        $Model = new \Common\Model\DaishouOrderLogModel();
        $Page = new \Common\Model\PageModel();

        $ordersn = $_REQUEST["ordersn"];

        $where = array();

        if($ordersn != null) {
            $where = array("ordersn" => $ordersn);
        }

        // 查询数据条数
        $count = $Model->where($where)->count();

        // 分页显示输出
        $per = 15;
        if ($_GET['p']) {
            $p = $_GET['p'];
        } else {
            $p = 1;
        }
        $page = $Page->show($count,$per);

        // 查询数据
        $data = $Model->where($where)->order('id desc')->page($p.','.$per)->select();

        if(count($data) > 0) {
            foreach($data as $k => $v) {

            }
        }

        // 模板渲染
        $this->assign('list', $data);
        $this->assign('page', $page);
        $this->display();
    }

    public function sms()
    {
        $ordersn = $_REQUEST["ordersn"];
        $res1 = 0;
        if($ordersn != null) {

            // 实例化Model类
            $Model = new \Common\Model\DaishouOrderModel();
            $Log = new \Common\Model\DaishouOrderLogModel();
            $User = new \Common\Model\UserModel();
            $udata = $Model->where(array("ordersn = $ordersn"))->find();

            $userInfo = $User->where("uid = ". $udata["uid"])->find();

            //发送手机短信
            $sms=new \Common\Model\SmsModel();
            $content= "你的包裹".$udata["fromsn"]."已到达门店";
            $res1=$sms->sendSms($userInfo["phone"], $content, 'default');

            if($res1 > 0 ) {
                // 组装数据
                $data = [
                    'sms'          => $udata["sms"]+1
                ];
                // 入库
                $res = $Model->where("ordersn = $ordersn")->save($data);
                $Log->add(array(
                    "uid" => $udata["uid"],
                    "ordersn" => $ordersn,
                    "status" =>  $udata["uid"],
                    "remark" => "你的包裹".$udata["fromsn"]."已到达门店",
                    "addtime" => date("Y-m-d H:i:s")
                ));
            }
        }
        if ($res1 > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function wechat()
    {
        $ordersn = $_REQUEST["ordersn"];
        $res["errcode"] = 1;
        if($ordersn != null) {
            // 实例化Model类
            $Model = new \Common\Model\DaishouOrderModel();
            $udata = $Model->where(array("ordersn = $ordersn"))->find();

            $UserOauth=new \Common\Model\UserOauthModel();
            $res_exist = $UserOauth->where("user_id='".$udata["uid"]."'")->find();
            if(count($res_exist) > 0) {
                Vendor('pay.wxpay','','.class.php');
                //①、获取用户openid
                $wxpay=new \wxpay();
                $touser = $res_exist["openid"];
                $status = "包裹到店";
                $ye =  $udata["fromsn"];
                $name =  $udata["name"];
                $res = $wxpay->PushMessage($touser,$status,$ye,$name);
                if($res["errcode"] == 0) {
                    // 组装数据
                    $data = [
                        'sms'          => $udata["sms"]+1
                    ];
                    // 入库
                    $Model->where("ordersn = $ordersn")->save($data);
                }
            }
        }
        if ($res["errcode"] == 0) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function gethuowu()
    {
        $ordersn = $_REQUEST["ordersn"];
        $res = 0;
        if($ordersn != null) {

            // 实例化Model类
            $Model = new \Common\Model\DaishouOrderModel();
            $Log = new \Common\Model\DaishouOrderLogModel();

            $udata = $Model->where("ordersn=$ordersn")->find();

            // 组装数据
            $data = [
                'status1'          => 4,
                'updatetime' => date("Y-m-d H:i:s")
            ];
            // 入库
            $res = $Model->where("ordersn = $ordersn")->save($data);
            $Log->add(array(
                "uid" => $udata["uid"],
                "ordersn" => $ordersn,
                "status" => 4,
                "remark" => "你的包裹".$udata["fromsn"]."已送达",
                "addtime" => date("Y-m-d H:i:s")
            ));

        }
        if ($res > 0) {

            // 实例化Model类
            $UserOauth=new \Common\Model\UserOauthModel();
            $res_exist = $UserOauth->where("user_id='".$udata["uid"]."'")->find();
            if(count($res_exist) > 0) {
                Vendor('pay.wxpay','','.class.php');
                //①、获取用户openid
                $wxpay=new \wxpay();
                $touser = $res_exist["openid"];
                $ye =  $udata["fromsn"];
                $res = $wxpay->PushMessage2($touser,$ye);
                if($res["errcode"] == 0) {
                    // 组装数据
                    $data = [
                        'sms'          => $udata["sms"]+1
                    ];
                    // 入库
                    $Model->where("ordersn = $ordersn")->save($data);
                }
            }

            echo 1;
        } else {
            echo 0;
        }
    }

    public function batchget()
    {
        $all_id = $_REQUEST["all_id"];
        if($all_id != null) {
            // 实例化Model类
            $Model = new \Common\Model\DaishouOrderModel();
            $Log = new \Common\Model\DaishouOrderLogModel();
            $UserOauth=new \Common\Model\UserOauthModel();
            $all_id_arr = explode(',',$all_id);
            foreach($all_id_arr as $key => $val) {
                if($val > 0) {
                    $udata = $Model->where("id=$val")->find();

                    // 组装数据
                    $data = [
                        'status1'          => 4,
                        'updatetime' => date("Y-m-d H:i:s")
                    ];
                    // 入库
                    $res = $Model->where("id = $val")->save($data);
                    $Log->add(array(
                        "uid" => $udata["uid"],
                        "ordersn" => $udata["ordersn"],
                        "status" => 4,
                        "remark" => "你的包裹".$udata["fromsn"]."已送达",
                        "addtime" => date("Y-m-d H:i:s")
                    ));
                    if($res) {
                        $res_exist = $UserOauth->where("user_id='".$udata["uid"]."'")->find();
                        if(count($res_exist) > 0) {
                            Vendor('pay.wxpay','','.class.php');
                            //①、获取用户openid
                            $wxpay=new \wxpay();
                            $touser = $res_exist["openid"];
                            $ye =  $udata["fromsn"];
                            $res = $wxpay->PushMessage2($touser,$ye);
                            if($res["errcode"] == 0) {
                                // 组装数据
                                $data = [
                                    'sms'          => $udata["sms"]+1
                                ];
                                // 入库
                                $Model->where("ordersn = ".$udata["ordersn"])->save($data);
                            }
                        }

                    }
                }
            }
        }
        echo "1";
    }

    public function getmoney()
    {
        $ordersn = $_REQUEST["ordersn"];
        $res = 0;
        if($ordersn != null) {

            // 实例化Model类
            $Model = new \Common\Model\DaishouOrderModel();
            $Log = new \Common\Model\DaishouOrderLogModel();

            $udata = $Model->where("ordersn = $ordersn")->find();


            // 组装数据
            $data = [
                'status1'          => 1
            ];
            // 入库
            $res = $Model->where("ordersn = $ordersn")->save($data);
            $Log->add(array(
                "uid" => $udata["uid"],
                "ordersn" => $ordersn,
                "status" => 1,
                "remark" => "你的包裹".$udata["fromsn"]."已付清",
                "addtime" => date("Y-m-d H:i:s")
            ));

        }
        if ($res > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function finishorder()
    {
        $ordersn = $_REQUEST["ordersn"];
        $res = 0;
        if($ordersn != null) {

            // 实例化Model类
            $Model = new \Common\Model\DaishouOrderModel();
            $Log = new \Common\Model\DaishouOrderLogModel();

            $udata = $Model->where("ordersn = $ordersn")->find();

            // 组装数据
            $data = [
                'status1'          => 5,
                'updatetime'     => date("Y-m-d H:i:s")
            ];
            // 入库
            $res = $Model->where("ordersn = $ordersn")->save($data);
            $Log->add(array(
                "uid" => $udata["uid"],
                "ordersn" => $ordersn,
                "status" => 5,
                "remark" => "已完成订单",
                "addtime" => date("Y-m-d H:i:s")
            ));
        }
        if ($res > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function inShelf()
    {
        $ordersn = $_REQUEST["ordersn"];
        $shelf = $_REQUEST["shelf"];
        $res = 0;
        if($ordersn != null) {

            // 实例化Model类
            $Model = new \Common\Model\DaishouOrderModel();
            $Log = new \Common\Model\DaishouOrderLogModel();

            $udata = $Model->where("ordersn = $ordersn")->find();


            // 组装数据
            $data = [
                'status1'          => 1,
                'Shelf' => $shelf
            ];
            // 入库
            $res = $Model->where("ordersn = $ordersn")->save($data);
            $Log->add(array(
                "uid" => $udata["uid"],
                "ordersn" => $ordersn,
                "status" => 1,
                "remark" => "订单已入货柜",
                "addtime" => date("Y-m-d H:i:s")
            ));

        }
        if ($res > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function orderhome()
    {

        // 实例化Model类
        $Model = new \Common\Model\DaishouOrderHomeModel();
        $Page = new \Common\Model\PageModel();
        $User = new \Common\Model\UserDetailModel();
        $Shop = new \Common\Model\DaishouShopModel();
        $User2 = new \Common\Model\UserModel();
        $ConsigneeAddress=new \Common\Model\ConsigneeAddressModel();

        $where = array();

        // 查询数据条数
        $count = $Model->where($where)->count();

        // 分页显示输出
        $per = 15;
        if ($_GET['p']) {
            $p = $_GET['p'];
        } else {
            $p = 1;
        }

        $page = $Page->show($count,$per);

        // 查询数据
        $data = $Model->where($where)->order('id desc')->page($p.','.$per)->select();

        if(count($data) > 0) {
            foreach($data as $k => $v) {
                $udata = $User->where(array("user_id" => $v["uid"]))->find();
                $data[$k]["username"] = $udata["nickname"];
                $sdata = $Shop->where(array("id" => $v["store_id"]))->find();
                $data[$k]["shopname"] = $sdata["name"];

                $adata = $ConsigneeAddress->where(array("id" => $v["addr_id"]))->find();
                $data[$k]["address"] =  @$adata["consignee"]."/". @$adata["contact_number"]."/". @$adata["province"]. @$adata["city"].  @$adata["detail_address"];

            }
        }

        // 模板渲染
        $this->assign('list', $data);
        $this->assign('page', $page);
        $this->display();
    }

    /**
     * @title 计算总价
     * @author loveAKY
     * @date 2020-7-23 15:43
     */
    public function priceCount(){
        $W = I('w');//宽
        $H = I('h');//高
        $L = I('l');//长
        $weight = I('weight');//重量

        if(empty($W)){
            echo json_encode(array("code" => 1,"data" => array(),"msg" =>  "宽度不能为空"));
            exit();
        }

        if(empty($H)){
            echo json_encode(array("code" => 1,"data" => array(),"msg" =>  "高度不能为空"));
            exit();
        }

        if(empty($L)){
            echo json_encode(array("code" => 1,"data" => array(),"msg" =>  "长度不能为空"));
            exit();
        }

        if(empty($weight)){
            echo json_encode(array("code" => 1,"data" => array(),"msg" =>  "重量不能为空"));
            exit();
        }

        //费用配置 size:大小范围 price:首重价格(首重统一1kg) price_c:续重价格(1kg)
        $config = [
            ['size'=>30,'price'=>5,'price_c'=>2,'title'=>'特细','on'=>0],
            ['size'=>45,'price'=>6,'price_c'=>2,'title'=>'细型','on'=>1],
            ['size'=>60,'price'=>7,'price_c'=>2,'title'=>'细型','on'=>1],
            ['size'=>75,'price'=>8,'price_c'=>2,'title'=>'中小','on'=>2],
            ['size'=>90,'price'=>9,'price_c'=>2,'title'=>'中小','on'=>2],
            ['size'=>105,'price'=>10,'price_c'=>2,'title'=>'中型','on'=>3],
            ['size'=>120,'price'=>11,'price_c'=>2,'title'=>'中型','on'=>3],
            ['size'=>135,'price'=>12,'price_c'=>2,'title'=>'中大','on'=>4],
            ['size'=>150,'price'=>13,'price_c'=>2,'title'=>'中大','on'=>4],
            ['size'=>165,'price'=>14,'price_c'=>2,'title'=>'大型','on'=>5],
            ['size'=>180,'price'=>15,'price_c'=>2,'title'=>'大型','on'=>5],
            ['size'=>195,'price'=>16,'price_c'=>2,'title'=>'特大','on'=>6],
            ['size'=>210,'price'=>17,'price_c'=>2,'title'=>'特大','on'=>6],
            ['size'=>225,'price'=>18,'price_c'=>2,'title'=>'巨大','on'=>7],
            ['size'=>240,'price'=>19,'price_c'=>2,'title'=>'巨大','on'=>7]
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
        $on      = 0;

        if($size>240){
            $price   = ceil($size/15);
            $price_c = 2;
            $on      = 0;
        }else{
            foreach ($config as $k=>$v){
                if($price == 0){
                    if($size<$v['size']){
                        if($k == 0){
                            $price   = $v['price'];
                            $price_c = $v['price_c'];
                            $on      = $v['on'];
                        }else{
                            $price   = $config[$k-1]['price'];
                            $price_c = $config[$k-1]['price_c'];
                            $on      = $config[$k-1]['on'];
                        }
                    }
                }
            }
        }

        $fee = (($weight-1)*$price_c)+$price;

        echo json_encode(array("code" => 0,"data" => array('fee'=>$fee,'on'=>$on),"msg" =>  "计算成功"));
        exit();
    }

    /**
     * @title 评价列表
     * @author loveAKY
     * @time 2020-7-23 17:42
     */
    public function bbs(){

        // 实例化Model类
        $Model = new \Common\Model\DaishouOrderBbsModel();
        $Page = new \Common\Model\PageModel();

        $order = I('order');

        $where = array(
            'order'=>$order
        );

        // 查询数据条数
        $count = $Model->where($where)->count();

        // 分页显示输出
        $per = 15;
        if ($_GET['p']) {
            $p = $_GET['p'];
        } else {
            $p = 1;
        }

        $page = $Page->show($count,$per);

        // 查询数据
        $data = $Model->where($where)->order('id desc')->page($p.','.$per)->select();

        if(count($data) > 0) {
            foreach($data as $k => $v) {

            }
        }

        // 模板渲染
        $this->assign('list', $data);
        $this->assign('page', $page);
        $this->display();

    }

    public function useraccount()
    {
        //获取用户组列表
        $UserGroup=new \Common\Model\UserGroupModel();
        $glist=$UserGroup->getGroupList();
        $this->assign('glist',$glist);

        $where='1';
        $User=new \Common\Model\UserModel();

        if(trim(I('get.search'))) {
            $search=trim(I('get.search'));
            $where.=" and (username='$search' or email='$search' or phone='$search')";
        }

        $count=$User->where($where)->count();
        $per = 30;
        if($_GET['p']) {
            $p=$_GET['p'];
        }else {
            $p=1;
        }
        $Page=new \Common\Model\PageModel();
        $show= $Page->show($count,$per);// 分页显示输出
        $this->assign('page',$show);

        $list = $User->where($where)->page($p.','.$per)->order('uid desc')->select();

        if(count($list) > 0) {
            $UserDetail=new \Common\Model\UserDetailModel();
            foreach ($list as $key => $val) {
                $userInfo = $UserDetail->where("user_id='".$val["uid"]."'")->find();
                $list[$key]["nickname"] = $userInfo["nickname"];
            }
        }

        $this->assign('list',$list);
        $this->display();
    }

    //编辑会员
    public function useraccountedit($uid)
    {
        //获取用户组列表
        $UserGroup=new \Common\Model\UserGroupModel();
        $glist=$UserGroup->getGroupList('N');
        $this->assign('glist',$glist);
        //var_dump(I('post.'));exit;
        //获取会员信息
        $User=new \Common\Model\UserModel();
        $Msg=$User->getUserMsg($uid);
        $this->assign('msg',$Msg);

        if(I('post.')) {
            layout(false);
            $uid = I('post.uid');
            $data=array(
                'daishouyue'=>trim(I('post.daishouyue')),
                'daishoujifen'=>trim(I('post.daishoujifen')),
            );

            $res=$User->where("uid=$uid")->save($data);
            if ($res) {
                $Log = new \Common\Model\DaishouLogModel();
                $Log->add(array(
                    "uid" => $uid,
                    "money" => trim(I('post.daishouyue')),
                    "remark" => "管理后台操作变动用户".$uid."余额为".trim(I('post.daishouyue'))."积分为".trim(I('post.daishoujifen')),
                    "action" => "recharge",
                    "byadmin" => $_SESSION['admin_id'],
                    "addtime" => date("Y-m-d H:i:s")
                ));

                $this->success('添加成功',U('useraccount'));
            } else {
                $this->error('系统出错，请重试');
            }
        }else {
            $this->display();
        }
    }

    public function useraccountlog()
    {
        // 实例化Model类
        $Log = new \Common\Model\DaishouLogModel();
        $Page = new \Common\Model\PageModel();
        $User = new \Common\Model\UserDetailModel();

        $uid = $_REQUEST["uid"];

        $where = "";
        if($uid > 0) {
            $where = " (uid = $uid) ";
        }

        // 查询数据条数
        $count = $Log->where($where)->count();

        // 分页显示输出
        $per = 15;
        if ($_GET['p']) {
            $p = $_GET['p'];
        } else {
            $p = 1;
        }
        $page = $Page->show($count,$per);

        // 查询数据
        $data = $Log->where($where)->order('id desc')->page($p.','.$per)->select();

        if(count($data) > 0) {
            foreach($data as $k => $v) {
                if($v["uid"] == 0) {
                    $data[$k]["username"] = "";
                } else {
                    $udata = $User->where(array("user_id" => $v["uid"]))->find();
                    $data[$k]["username"] = $udata["nickname"];
                }

            }
        }

        // 模板渲染
        $this->assign('list', $data);
        $this->assign('page', $page);
        $this->display();
    }

    public function recharge()
    {
        // 实例化Model类
        $Model = new \Common\Model\DaishouRechageModel();
        $Page = new \Common\Model\PageModel();
        $User = new \Common\Model\UserDetailModel();

        $uid = $_REQUEST["uid"];

        $where = "";
        if($uid > 0) {
            $where = " (uid = $uid) ";
        }

        // 查询数据条数
        $count = $Model->where($where)->count();

        // 分页显示输出
        $per = 15;
        if ($_GET['p']) {
            $p = $_GET['p'];
        } else {
            $p = 1;
        }
        $page = $Page->show($count,$per);

        // 查询数据
        $data = $Model->where($where)->order('id desc')->page($p.','.$per)->select();

        if(count($data) > 0) {
            foreach($data as $k => $v) {
                if($v["uid"] == 0) {
                    $data[$k]["username"] = "";
                } else {
                    $udata = $User->where(array("user_id" => $v["uid"]))->find();
                    $data[$k]["username"] = $udata["nickname"];
                }

            }
        }

        // 模板渲染
        $this->assign('list', $data);
        $this->assign('page', $page);
        $this->display();
    }

    //修改充值状态
    public function rechargestatus($id,$status)
    {
        $data=array(
            'status'=>$status
        );
        $Model=new \Common\Model\DaishouRechageModel();
        $Log = new \Common\Model\DaishouLogModel();
        $User=new \Common\Model\UserModel();

        $res=$Model->where("id='$id'")->save($data);

        if($res!==false) {

             $rdata =$Model->where("id='$id'")->find();

            //开始充值
            if($status == 1 && count($rdata) > 0) {

                $uid =  $rdata["uid"];
                $udata =$User->where("uid='$uid'")->find();
                $data2=array(
                    'daishouyue'=> $udata["daishouyue"]+$rdata["money"]
                );

                $User->where("uid=$uid")->save($data2);
                $Log->add(array(
                    "uid" => $rdata["uid"],
                    "money" => $rdata["money"],
                    "remark" => "用户".$rdata["uid"]."充值".$rdata["money"]."审核成功到账",
                    "action" => "recharge_check",
                    "byadmin" => $_SESSION['admin_id'],
                    "addtime" => date("Y-m-d H:i:s")
                ));
            }

            //开始充值
            if($status == 2) {
                $Log->add(array(
                    "uid" => $rdata["uid"],
                    "money" => $rdata["money"],
                    "remark" => "用户".$rdata["uid"]."充值".$rdata["money"]."审核失败",
                    "action" => "recharge_check",
                    "byadmin" => $_SESSION['admin_id'],
                    "addtime" => date("Y-m-d H:i:s")
                ));
            }

            echo '1';
        }else {
            echo '0';
        }
    }


    public function activity()
    {
        // 实例化Model类
        $Model = new \Common\Model\DaishouActivityModel();
        $Page = new \Common\Model\PageModel();

        $where = "";

        // 查询数据条数
        $count = $Model->where($where)->count();

        // 分页显示输出
        $per = 15;
        if ($_GET['p']) {
            $p = $_GET['p'];
        } else {
            $p = 1;
        }
        $page = $Page->show($count,$per);

        // 查询数据
        $data = $Model->where($where)->order('id desc')->page($p.','.$per)->select();

        if(count($data) > 0) {

        }

        // 模板渲染
        $this->assign('list', $data);
        $this->assign('page', $page);
        $this->display();
    }

    //修改充值状态
    public function activitystatus($id,$status)
    {
        $data=array(
            'status'=>$status
        );
        $Model = new \Common\Model\DaishouActivityModel();

        $res=$Model->where("id='$id'")->save($data);

        if($res!==false) {
            echo '1';
        }else {
            echo '0';
        }
    }
}