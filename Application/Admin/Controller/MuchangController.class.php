<?php
/**
 * 抽奖管理
 */
namespace Admin\Controller;
use Admin\Common\Controller\AuthController;

class MuchangController extends AuthController
{
    public function index()
    {
        // 实例化Model类
        $Muchang = new \Common\Model\MuchangModel();
        $Page = new \Common\Model\PageModel();
        $User = new \Common\Model\UserDetailModel();


        $where = array();

        // 查询数据条数
        $count = $Muchang->where($where)->count();

        // 分页显示输出
        $per = 15;
        if ($_GET['p']) {
            $p = $_GET['p'];
        } else {
            $p = 1;
        }
        $page = $Page->show($count,$per);

        // 查询数据
        $data = $Muchang->where($where)->order('id desc')->page($p.','.$per)->select();

        if(count($data) > 0) {
            foreach($data as $k => $v) {
                $udata = $User->where(array("user_id" => $v["uid"]))->find();
                $data[$k]["username"] = $udata["nickname"];
            }
        }

        // 模板渲染
        $this->assign('list', $data);
        $this->assign('page', $page);
        $this->display();
    }

    public function edit()
    {
        // 实例化Model类
        $Muchang = new \Common\Model\MuchangModel();
        $uid = $_REQUEST["uid"];

        // 查询数据
        $data = $Muchang->where("uid = $uid")->find();

        if (I('POST.')) {
            layout(false);

            if(strtotime(I('POST.dogdate')) >= time()) {
                $dog = 1;
            } else {
                $dog = 0;
            }

            if(strtotime(I('POST.ysddate')) >= time() && $data["isysd"] == 0 && strtotime(I('POST.ysddate')) != strtotime($data["ysddate"])) {
                $isysd = 1;
            } else {
                $isysd = $data["isysd"];
            }

            if(strtotime(I('POST.ynddate')) >= time() && $data["isynd"] == 0 && strtotime(I('POST.ynddate')) != strtotime($data["ynddate"])) {
                $isynd = 1;
            } else {
                $isynd = $data["isynd"];
            }

            // 组装数据
            $data = array(
                "jinbi" => I('POST.jinbi'),
                "ji" => I('POST.ji'),
                "kuoliang" => I('POST.kuoliang'),
                "dan" => I('POST.dan'),
                "undan" => I('POST.undan'),
                "dogdate" => I('POST.dogdate'),
                "dog" => $dog,
                "ysddate" => I('POST.ysddate'),
                "isysd" => $isysd,
                "ynddate" => I('POST.ynddate'),
                "isynd" => $isynd,
            );

            // 入库
            $res = $Muchang->where("uid = $uid")->save($data);
            if ($res) {
                $this->success('修改成功',U('index'));
            } else {
                $this->error('系统出错，请重试');
            }

        } else {

            // 模板渲染
            $this->assign('data', $data);
            $this->assign('uid', $uid);
            $this->display();
        }
    }

    public function showedit($uid)
    {
        // 实例化Model类
        $Muchang = new \Common\Model\MuchangModel();
        $MuchangLog = new \Common\Model\MuchangLogModel();
        $uid = $_REQUEST["uid"];

        // 查询数据
        $data = $Muchang->where("uid = $uid")->find();

        if (I('POST.') && count($data) > 0) {
            $uid = $_REQUEST["uid"];
            $kouliang = $_REQUEST["kouliang"];
            $zengsong = $_REQUEST["zengsong"];
            $star = $_REQUEST["star"];
            $data2 = $res = null;
            $system = 0;
            if(isset($_REQUEST["kouliang"]) && intval($kouliang) > 0) {
                $data2 = array(
                    "kouliang" => $data["kouliang"]+$kouliang,
                );
                $system = 2;
                $remark = "系统赠送口粮数量:".$kouliang;
            }
            if(isset($_REQUEST["zengsong"]) && intval($zengsong) > 0) {
                $data2 = array(
                    "zengsong" => $data["zengsong"]+$zengsong,
                );
                $system = 7;
                $remark = "系统赠送金币数量:".$zengsong;
            }
            if(isset($_REQUEST["star"]) && intval($star) > 0) {
                $data2 = array(
                    "star" => $star,
                );
                $system = 9;
                if($star == 0) {
                    $starname =  "无";
                }
                if($star == 1) {
                    $starname = "一星达人";
                }
                if($star == 2) {
                    $starname =  "二星达人";
                }
                if($star == 3) {
                    $starname =  "三星达人";
                }
                if($star == 4) {
                    $starname =  "牧场金主";
                }
                $remark = "系统调整星级达人等级为:".$starname;
            }
           if($data2 != null) {
               // 入库
               $res = $Muchang->where("uid = $uid")->save($data2);
           }

            if ($res) {

                $MuchangLog->add(array(
                    "uid" => 0,
                    "tuid" => $uid,
                    "type" => 5,
                    "jinbi" => @$zengsong,
                    "kouliang" => @$kouliang,
                    "system" => @$system,
                    "remark" => @$remark,
                    "addtime" => date("Y-m-d H:i:s")
                ));

                echo '1';
            } else {
                echo '0';
            }
        } else {
            echo '0';
        }
    }

    public function log()
    {
        // 实例化Model类
        $MuchangLog = new \Common\Model\MuchangLogModel();
        $Page = new \Common\Model\PageModel();
        $User = new \Common\Model\UserDetailModel();

        $uid = $_REQUEST["uid"];

        $where = "";
        if($uid > 0) {
            $where = " (uid = $uid or tuid = $uid) ";
        }

        // 查询数据条数
        $count = $MuchangLog->where($where)->count();

        // 分页显示输出
        $per = 15;
        if ($_GET['p']) {
            $p = $_GET['p'];
        } else {
            $p = 1;
        }
        $page = $Page->show($count,$per);

        // 查询数据
        $data = $MuchangLog->where($where)->order('id desc')->page($p.','.$per)->select();

        if(count($data) > 0) {
            foreach($data as $k => $v) {
                if($v["uid"] == 0) {
                    $data[$k]["username"] = "";
                } else {
                    $udata = $User->where(array("user_id" => $v["uid"]))->find();
                    $data[$k]["username"] = $udata["nickname"];
                }

                if($v["tuid"] == 0) {
                    $data[$k]["tusername"] = "";
                } else {
                    $udata = $User->where(array("user_id" => $v["tuid"]))->find();
                    $data[$k]["tusername"] = $udata["nickname"];
                }


            }
        }

        // 模板渲染
        $this->assign('list', $data);
        $this->assign('page', $page);
        $this->display();
    }

    public function goods()
    {
        // 实例化Model类
        $MuchangGoods = new \Common\Model\MuchangGoodsModel();
        $Page = new \Common\Model\PageModel();


        $where = array();

        // 查询数据条数
        $count = $MuchangGoods->where($where)->count();

        // 分页显示输出
        $per = 15;
        if ($_GET['p']) {
            $p = $_GET['p'];
        } else {
            $p = 1;
        }
        $page = $Page->show($count,$per);

        // 查询数据
        $data = $MuchangGoods->where($where)->order('id desc')->page($p.','.$per)->select();

        if(count($data) > 0) {
            foreach($data as $k => $v) {

            }
        }

        // 模板渲染
        $this->assign('list', $data);
        $this->assign('page', $page);
        $this->display();
    }

    public function jihuoma()
    {
        // 实例化Model类
        $MuchangJihuoma = new \Common\Model\MuchangJihuomaModel();
        $Page = new \Common\Model\PageModel();
        $User = new \Common\Model\UserDetailModel();
        $MuchangGoods = new \Common\Model\MuchangGoodsModel();

        $where = array();

        // 查询数据条数
        $count = $MuchangJihuoma->where($where)->count();

        // 分页显示输出
        $per = 15;
        if ($_GET['p']) {
            $p = $_GET['p'];
        } else {
            $p = 1;
        }
        $page = $Page->show($count,$per);

        // 查询数据
        $data = $MuchangJihuoma->where($where)->order('id desc')->page($p.','.$per)->select();

        if(count($data) > 0) {
            foreach($data as $k => $v) {
                if(intval($v["uid"]) > 0) {
                    $udata = $User->where(array("user_id" => $v["uid"]))->find();
                    $data[$k]["username"] = $udata["nickname"];
                } else {
                    $data[$k]["username"] = "-";
                }
                $gdata = $MuchangGoods->where(array("id" => $v["goods_id"]))->find();
                $data[$k]["goods_type"] = $gdata["goods_type"];
                $data[$k]["num"] = $gdata["num"];
            }
        }

        // 模板渲染
        $this->assign('list', $data);
        $this->assign('page', $page);
        $this->display();
    }

    public function buildjihuoma()
    {
        // 实例化Model类
        $MuchangJihuoma = new \Common\Model\MuchangJihuomaModel();
        $id = $_REQUEST["id"];
        if($id > 0) {
            $MuchangJihuoma->add(array(
                "goods_id" => $id,
                "no" => "NO".date("m").rand(100,999),
                "status" => 1,
                "addtime" => date("Y-m-d H:i:s")
            ));
            echo '1';
        } else {
            echo '0';
        }

    }

    public function usejihuoma()
    {

        $MuchangJihuoma = new \Common\Model\MuchangJihuomaModel();
        $MuchangGoods = new \Common\Model\MuchangGoodsModel();
        $Muchang = new \Common\Model\MuchangModel();
        $MuchangLog = new \Common\Model\MuchangLogModel();
        $uid = $_REQUEST["uid"];
        $no = $_REQUEST["no"];
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
                        "tuid" => $uid,
                        "type" => 5,
                        "dan" => $data["num"],
                        "system" => 10,
                        "remark" => "使用激活码".$no."激活了".$gdata["num"]."个鸵鸟",
                        "addtime" => date("Y-m-d H:i:s")
                    ));
                }
                if($gdata["goods_type"] == 2) {
                    $Muchang->where(array("uid" =>$uid ))->save(array(
                        "kouliang" => ($mcInfo["kouliang"] + $gdata["num"])
                    ));
                    $MuchangLog->add(array(
                        "tuid" => $uid,
                        "type" => 5,
                        "kouliang" => $data["num"],
                        "system" => 10,
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
                        "tuid" => $uid,
                        "type" => 5,
                        "system" => 10,
                        "remark" => "使用激活码".$no."激活了个哈士奇，有效期到".$dogDate,
                        "addtime" => date("Y-m-d H:i:s")
                    ));
                }

                if($gdata["goods_type"] == 4) {
                    $Muchang->where(array("uid" =>$uid ))->save(array(
                        "isysd" => 1,
                        "ysddate" => date("Y-m-d H:i:s",strtotime("+2 days")),
                        "ysdstart" => date("Y-m-d H:i:s",strtotime("+20 days")),
                    ));
                    $MuchangLog->add(array(
                        "tuid" => $uid,
                        "type" => 5,
                        "dan" => $data["num"],
                        "system" => 10,
                        "remark" => "使用激活码".$no."激活了延寿丹",
                        "addtime" => date("Y-m-d H:i:s")
                    ));
                }

                if($gdata["goods_type"] == 5) {
                    $Muchang->where(array("uid" =>$uid ))->save(array(
                        "isynd" => 1,
                        "ynddate" => date("Y-m-d H:i:s",strtotime("+3 days")),
                        "yndstart" => date("Y-m-d H:i:s",strtotime("+20 days")),
                    ));
                    $MuchangLog->add(array(
                        "tuid" => $uid,
                        "type" => 5,
                        "dan" => $data["num"],
                        "system" => 10,
                        "remark" => "使用激活码".$no."激活了延年丹",
                        "addtime" => date("Y-m-d H:i:s")
                    ));
                }

                $data2 = array(
                    "uid" => $uid,
                    "status" => 3,
                );
                $MuchangJihuoma->where("no = '$no'")->save($data2);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        echo 0;
    }

    public function jihuomaedit()
    {
        // 实例化Model类
        $MuchangJihuoma = new \Common\Model\MuchangJihuomaModel();
        $id = $_REQUEST["id"];

        // 查询数据
        $data = $MuchangJihuoma->where("id = $id")->find();

        if (I('POST.') && count($data) > 0) {
            $uid = $_REQUEST["uid"];

            $data2 = $res = null;
            if(isset($_REQUEST["uid"]) && intval($uid) > 0) {
                $data2 = array(
                    "uid" => $uid,
                    "status" => 2,
                );
            }
            if(isset($_REQUEST["uid"]) && intval($uid) == 0) {
                $data2 = array(
                    "uid" => $uid,
                    "status" => 1,
                );
            }

            if($data2 != null) {
                // 入库
                $res = $MuchangJihuoma->where("id = $id")->save($data2);
            }

            if ($res) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            echo '0';
        }
    }

    public function goodsedit()
    {
        // 实例化Model类
        $MuchangGoods = new \Common\Model\MuchangGoodsModel();
        $id = $_REQUEST["id"];

        // 查询数据
        $data = $MuchangGoods->where("id = $id")->find();

        if (I('POST.') && count($data) > 0) {
            $price = $_REQUEST["price"];
            $num = $_REQUEST["num"];
            $data2 = $res = null;
            if(isset($_REQUEST["price"]) && intval($price) > 0) {
                $data2 = array(
                    "price" => $price,
                );
            }
            if(isset($_REQUEST["num"]) && intval($num) > 0) {
                $data2 = array(
                    "num" => $num,
                );
            }

            if($data2 != null) {
                // 入库
                $res = $MuchangGoods->where("id = $id")->save($data2);
            }

            if ($res) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            echo '0';
        }
    }

    public function order()
    {
        // 实例化Model类
        $MuchangOrder = new \Common\Model\MuchangOrderModel();
        $Page = new \Common\Model\PageModel();
        $User = new \Common\Model\UserDetailModel();
        $MuchangGoods = new \Common\Model\MuchangGoodsModel();


        $where = array();

        // 查询数据条数
        $count = $MuchangOrder->where($where)->count();

        // 分页显示输出
        $per = 15;
        if ($_GET['p']) {
            $p = $_GET['p'];
        } else {
            $p = 1;
        }
        $page = $Page->show($count,$per);

        // 查询数据
        $data = $MuchangOrder->where($where)->order('id desc')->page($p.','.$per)->select();

        if(count($data) > 0) {
            foreach($data as $k => $v) {
                $udata = $User->where(array("user_id" => $v["uid"]))->find();
                $data[$k]["username"] = $udata["nickname"];

                $goods = $MuchangGoods->where(array("id" => $v["goods_id"]))->find();
                if($goods["goods_type"] == 1) {
                    $data[$k]["goodsname"] =  "鸵鸟 * ".$goods['num'];
                }
                if($goods["goods_type"] == 2) {
                    $data[$k]["goodsname"] =  "口粮 * ".$goods['num'];
                }
                if($goods["goods_type"] == 3) {
                    $data[$k]["goodsname"] =  "哈士奇 * ".$goods['num'];
                }

            }
        }

        // 模板渲染
        $this->assign('list', $data);
        $this->assign('page', $page);
        $this->display();
    }

    public function jiaoyi()
    {
        // 实例化Model类
        $Model = new \Common\Model\MuchangJiaoyiModel();
        $Page = new \Common\Model\PageModel();
        $User = new \Common\Model\UserDetailModel();


        $where = " status = 0 ";

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
            }
        }

        // 模板渲染
        $this->assign('list', $data);
        $this->assign('page', $page);
        $this->display();
    }

    public function jiaoyilog()
    {
        // 实例化Model类
        $Model = new \Common\Model\MuchangJiaoyiModel();
        $Page = new \Common\Model\PageModel();
        $User = new \Common\Model\UserDetailModel();


        $where = " status > 0 ";

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

                $udata = $User->where(array("user_id" => $v["tuid"]))->find();
                $data[$k]["tusername"] = $udata["nickname"];
            }
        }

        // 模板渲染
        $this->assign('list', $data);
        $this->assign('page', $page);
        $this->display();
    }

    public function jiaoyiedit()
    {
        // 实例化Model类
        $Model = new \Common\Model\MuchangJiaoyiModel();
        $id = $_REQUEST["id"];

        // 查询数据
        $data = $Model->where("id = $id")->find();

        if (I('POST.')) {
            layout(false);
            $orderNo = date("YmdHis").time();
            // 组装数据
            $data2 = array(
                "remark" => I('POST.remark'),
                "status" => 3,
                "orderNo" => $orderNo
            );

            // 入库
            $res = $Model->where("id = $id")->save($data2);
            if ($res) {
                $Muchang = new \Common\Model\MuchangModel();
                $MuchangLog = new \Common\Model\MuchangLogModel();

                //增加口粮
                $Muchang->where(array("uid" =>$data["tuid"] ))->setInc("dan" ,intval(@$data["num"]));
                $MuchangLog->add(array(
                    "uid" => $data["uid"],
                    "tuid" => $data["tuid"],
                    "type" => 5,
                    "dan" => $data["num"],
                    "system" => 8,
                    "remark" => $orderNo."商品交易完成",
                    "addtime" => date("Y-m-d H:i:s")
                ));

                $this->success('修改成功',U('jiaoyilog'));
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

}