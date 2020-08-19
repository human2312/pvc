<?php
/**
 * 抽奖管理
 */
namespace Admin\Controller;
use Admin\Common\Controller\AuthController;

class PtuanController extends AuthController
{

    public function shop()
    {
        // 实例化Model类
        $JFLottery = new \Common\Model\PtuanShopModel();
        $Page = new \Common\Model\PageModel();
        $User = new \Common\Model\UserModel();


        $where = array();

        // 查询数据条数
        $count = $JFLottery->where($where)->count();

        // 分页显示输出
        $per = 15;
        if ($_GET['p']) {
            $p = $_GET['p'];
        } else {
            $p = 1;
        }
        $page = $Page->show($count,$per);

        // 查询数据
        $data = $JFLottery->where($where)->order('id desc')->page($p.','.$per)->select();

        if(count($data) > 0) {
            foreach($data as $k => $v) {
                $udata = $User->where(array("uid" => $v["user_id"]))->find();
                $data[$k]["username"] = $udata["phone"];
            }
        }

        // 模板渲染
        $this->assign('data', $data);
        $this->assign('page', $page);
        $this->display();
    }

    public function shopStatus()
    {
        // 实例化Model类
        $Shop = new \Common\Model\PtuanShopModel();

        layout(false);

        // 删除
        $id = $_REQUEST["id"];
        $status = $_REQUEST["status"];

        $res = $Shop->where("id = $id")->save(array("status" => $status));

        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }


    public function goods()
    {
        // 实例化Model类
        $JFLottery = new \Common\Model\PtuanGoodsModel();
        $Shop = new \Common\Model\PtuanShopModel();
        $Page = new \Common\Model\PageModel();
        $User = new \Common\Model\UserModel();
        $Order = new \Common\Model\PtuanOrderModel();

        $where = array(
            'isOpen' => 1
        );

        // 查询数据条数
        $count = $JFLottery->where($where)->count();

        // 分页显示输出
        $per = 15;
        if ($_GET['p']) {
            $p = $_GET['p'];
        } else {
            $p = 1;
        }
        $page = $Page->show($count,$per);

        // 查询数据
        $data = $JFLottery->where($where)->order('pid desc')->page($p.','.$per)->select();

        if(count($data) > 0) {
            foreach($data as $k => $v) {
                $sdata = $Shop->where(array("id" => $v["shop_id"]))->find();
                $data[$k]["shopname"] = $sdata["name"];

                $condition['goods_id'] = $v["id"];
                $condition['pid'] =  $v["pid"];
                $condition['_logic'] = 'OR';
                $data[$k]["orderNum"] = $Order->where($condition)->count();

                $data[$k]["orderNowNum"] = $Order->where(array("goods_id" =>$v["id"] ))->count();

                $udata = $User->where(array("uid" => $sdata["user_id"]))->find();
                $data[$k]["username"] = $udata["phone"];

            }
        }

        // 模板渲染
        $this->assign('data', $data);
        $this->assign('page', $page);
        $this->display();
    }

    public function order()
    {
        // 实例化Model类
        $JFLottery = new \Common\Model\PtuanOrderModel();
        $Goods = new \Common\Model\PtuanGoodsModel();
        $Shop = new \Common\Model\PtuanShopModel();
        $Page = new \Common\Model\PageModel();
        $User = new \Common\Model\UserModel();

        $goods_id = $_REQUEST["goods_id"];

        $where = array("goods_id" => $goods_id);

        // 查询数据条数
        $count = $JFLottery->where($where)->count();

        // 分页显示输出
        $per = 15;
        if ($_GET['p']) {
            $p = $_GET['p'];
        } else {
            $p = 1;
        }
        $page = $Page->show($count,$per);

        // 查询数据
        $data = $JFLottery->where($where)->order('id desc')->page($p.','.$per)->select();

        if(count($data) > 0) {
            foreach($data as $k => $v) {
                $gsdata = $Goods->where(array("id" => $v["goods_id"]))->find();
                $data[$k]["goodsname"] = $gsdata["name"];


                $udata = $User->where(array("uid" => $v["user_id"]))->find();
                $data[$k]["username"] = $udata["phone"];

            }
        }

        // 模板渲染
        $this->assign('data', $data);
        $this->assign('page', $page);
        $this->display();
    }

    public function oldorder()
    {
        // 实例化Model类
        $JFLottery = new \Common\Model\PtuanOrderModel();
        $Goods = new \Common\Model\PtuanGoodsModel();
        $Shop = new \Common\Model\PtuanShopModel();
        $Page = new \Common\Model\PageModel();
        $User = new \Common\Model\UserModel();

        $goods_id = $_REQUEST["goods_id"];

        $where["pid"] = $goods_id;
        $where["qi"] =  array('neq',1);

        // 查询数据条数
        $count = $JFLottery->where($where)->count();

        // 分页显示输出
        $per = 15;
        if ($_GET['p']) {
            $p = $_GET['p'];
        } else {
            $p = 1;
        }
        $page = $Page->show($count,$per);

        // 查询数据
        $data = $JFLottery->where($where)->order('qi desc ,id desc')->page($p.','.$per)->select();

        if(count($data) > 0) {
            foreach($data as $k => $v) {
                $gsdata = $Goods->where(array("id" => $v["goods_id"]))->find();
                $data[$k]["goodsname"] = $gsdata["name"];


                $udata = $User->where(array("uid" => $v["user_id"]))->find();
                $data[$k]["username"] = $udata["phone"];

            }
        }

        // 模板渲染
        $this->assign('data', $data);
        $this->assign('page', $page);
        $this->display();
    }

    //  修改拉新活动
    public function edit($id)
    {
        // 实例化Model类
        $Goods = new \Common\Model\PtuanGoodsModel();

        // 查询数据
        $data = $Goods->where("id = $id")->find();

        if (I('POST.')) {
            layout(false);


            // 组装数据
            $data = [
                'qipai'          => I('POST.qipai'),
                'status'          => I('POST.status'),
                'back_l'          => I('POST.back_l'),
            ];

            // 入库
            $res = $Goods->where("id = $id")->save($data);
            if ($res) {
                $this->success('修改成功',U('goods'));
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

    //提前开奖
    public function goodsOpen()
    {
        // 实例化Model类
        $Goods = new \Common\Model\PtuanGoodsModel();

        layout(false);

        // 删除
        $id = $_REQUEST["id"];

        $res = $Goods->where("id = $id")->save(array("isOpen" => 2,"is_close" => 1));

        if ($res) {
            //新增一个正在活动的商品
            $goodsInfo = $Goods->where(array("id" => $id))->find();
            if(intval($goodsInfo["pid"]) <= 0) {
                $pid = $id;
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
                    'lucky' => rand(1, 9),
                    'startTime' => date("Y-m-d H:i:s"),
                    'endTime' => date("Y-m-d H:i:s", strtotime("+1 day")),
                    'price' => $goodsInfo["price"],
                    'sale' => $goodsInfo["sale"],
                    'back_l' => $goodsInfo["back_l"],
                    'fee' => $goodsInfo["fee"],
                    'qty' => $goodsInfo["qty"],
                    'qipai' => $goodsInfo["qipai"],
                    'isOpen' => 1,
                    'isAuto' => '1',
                    'pid' => $pid,
                    'addtime' => date("Y-m-d H:i:s")
                ];
                // 入库
                $Goods->add($data);
            }
            echo 1;
        } else {
            echo 0;
        }
    }

}
