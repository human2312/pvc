<?php
/**
 * 抽奖管理
 */
namespace Admin\Controller;
use Admin\Common\Controller\AuthController;

class DmoneyController extends AuthController
{

    public function index()
    {
        // 实例化Model类
        $JFLottery = new \Common\Model\DmoneyUserModel();
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

    public function configList()
    {
        // 实例化Model类
        $JFLottery = new \Common\Model\DmoneyConfigModel();
        $Page = new \Common\Model\PageModel();


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

        // 模板渲染
        $this->assign('data', $data);
        $this->assign('page', $page);
        $this->display();
    }

    // 增加拉新活动
    public function configAdd()
    {
        // 实例化Model类
        $Rookie = new \Common\Model\DmoneyConfigModel();

        if (I('POST.')) {
            layout(false);


            // 组装数据
            $data = [
                'name'          => I('POST.name'),
                'url'          => I('POST.url'),
                'fee'          => I('POST.fee'),
                'min'    => I('POST.min'),
                'add_time'      => date("Y-m-d H:i:s")
            ];
            // 数据验证
            if (!$Rookie->create($data)) {
                $this->error($Rookie->getError());
            }

            // 入库
            $res = $Rookie->add($data);
            if ($res) {
                $this->success('添加成功',U('configList'));
            } else {
                $this->error('系统出错，请重试');
            }

        } else {
            $this->display();
        }
    }

    //  修改拉新活动
    public function configEdit($id)
    {
        // 实例化Model类
        $Rookie = new \Common\Model\DmoneyConfigModel();

        // 查询数据
        $data = $Rookie->where("id = $id")->find();

        if (I('POST.')) {
            layout(false);

            // 组装数据
            $data = [
                'name'          => I('POST.name'),
                'url'          => I('POST.url'),
                'fee'          => I('POST.fee'),
                'min'    => I('POST.min')
            ];

            // 入库
            $res = $Rookie->where("id = $id")->save($data);
            if ($res) {
                $this->success('修改成功',U('configList'));
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

    //  删除拉新活动
    public function configDel()
    {
        // 实例化Model类
        $Rookie = new \Common\Model\DmoneyConfigModel();

        layout(false);

        // 删除
        $id = I('POST.id');

        $res = $Rookie->where("id = $id")->delete();

        if ($res) {
            echo 1;
        } else {
            echo 0;
        }


    }

    // 拉新活动
    public function recharge()
    {
        // 实例化Model类
        $JFLottery = new \Common\Model\DmoneyUserLogModel();
        $Page = new \Common\Model\PageModel();
        $User = new \Common\Model\UserModel();

        $where = array(
            "u_type" => 1
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

    public function rechargeAdd()
    {
        // 实例化Model类
        $Rookie = new \Common\Model\DmoneyUserLogModel();
        $DmoneyUserModel = new \Common\Model\DmoneyUserModel();

        layout(false);

        $id = I('POST.id');

        // 查询数据
        $data = $Rookie->where("id = $id")->find();

        if(!isset($data["id"])) {
            echo 0;exit;
        }
        $DmoneyUser = $DmoneyUserModel->where(array("user_id" => $data["user_id"],"name" => $data["name"]))->find();
        if(isset($DmoneyUser["id"])) {
            $DmoneyUserModel->where("id = ".$DmoneyUser["id"])->save(array("account" => $DmoneyUser["account"] + $data["money"]));
        } else {
            $DmoneyUserModel->add(array("user_id" => $data["user_id"],"name" => $data["name"],"account" => $data["money"]));
        }

        // 组装数据
        $data = [
            'status'          => 1
        ];

        // 入库
        $res = $Rookie->where("id = $id")->save($data);

        if ($res) {
            echo 1;
        } else {
            echo 0;
        }


    }

    public function rechargeDel()
    {
        // 实例化Model类
        $Rookie = new \Common\Model\DmoneyUserLogModel();

        layout(false);

        $id = I('POST.id');

        // 组装数据
        $data = [
            'status'          => 2
        ];

        // 入库
        $res = $Rookie->where("id = $id")->save($data);

        if ($res) {
            echo 1;
        } else {
            echo 0;
        }


    }

    // 拉新活动
    public function cash()
    {
        // 实例化Model类
        $JFLottery = new \Common\Model\DmoneyUserLogModel();
        $Page = new \Common\Model\PageModel();
        $User = new \Common\Model\UserModel();

        $where = array(
            "u_type" => 2
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

    public function cashAdd()
    {
        // 实例化Model类
        $Rookie = new \Common\Model\DmoneyUserLogModel();
        $DmoneyUserModel = new \Common\Model\DmoneyUserModel();

        layout(false);

        $id = I('POST.id');

        // 查询数据
        $data = $Rookie->where("id = $id")->find();

        if(!isset($data["id"])) {
            echo 0;exit;
        }
        $DmoneyUser = $DmoneyUserModel->where(array("user_id" => $data["user_id"],"name" => $data["name"]))->find();
        if(isset($DmoneyUser["id"])) {
            if($DmoneyUser["account"] - $data["pre_money"] < 0) {
                echo 0;exit;
            }
            $DmoneyUserModel->where("id = ".$DmoneyUser["id"])->save(array("account" => $DmoneyUser["account"] - $data["pre_money"]));
        } else {
            echo 0;exit;
        }

        // 组装数据
        $data = [
            'status'          => 1
        ];

        // 入库
        $res = $Rookie->where("id = $id")->save($data);

        if ($res) {
            echo 1;
        } else {
            echo 0;
        }


    }

    public function cashDel()
    {
        // 实例化Model类
        $Rookie = new \Common\Model\DmoneyUserLogModel();

        layout(false);

        $id = I('POST.id');

        // 组装数据
        $data = [
            'status'          => 2
        ];

        // 入库
        $res = $Rookie->where("id = $id")->save($data);

        if ($res) {
            echo 1;
        } else {
            echo 0;
        }


    }


}
