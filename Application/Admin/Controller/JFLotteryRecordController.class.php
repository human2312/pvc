<?php
/**
 * 拉新活动提现记录
 */
namespace Admin\Controller;
use Admin\Common\Controller\AuthController;

class JFLotteryRecordController extends AuthController
{
    // 拉新活动
    public function index()
    {
        // 实例化Model类
        $JFLottery = new \Common\Model\JFLotteryModel();
        $JFLotteryRecord = new \Common\Model\JFLotteryRecordModel();
        $User = new \Common\Model\UserModel();
        $Page = new \Common\Model\PageModel();

        $id = I('GET.id');

        $where['l_id'] = $id;

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

        $ldata = $JFLottery->where(array("id" => $id))->find();

        // 查询数据
        $data = $JFLotteryRecord->where($where)->order('id desc')->page($p.','.$per)->select();

        if(count($data) > 0) {
            foreach($data as $k => $v) {
                $udata = $User->where(array("uid" => $v["userid"]))->find();
                $data[$k]["username"] = $udata["username"];
            }
        }

        // 模板渲染
        $this->assign('ldata', $ldata);
        $this->assign('data', $data);
        $this->assign('page', $page);
        $this->display();
    }

    //  修改拉新活动
    public function edit($id)
    {
        // 实例化Model类
        $JFLotteryRecord = new \Common\Model\JFLotteryRecordModel();

        // 查询数据
        $data = $JFLotteryRecord->where("id = $id")->find();

        if (I('POST.')) {
            layout(false);

            // 组装数据
            $data = [
                'receiver'          => I('POST.receiver'),
                'phone'          => I('POST.phone'),
                'area'          => I('POST.area'),
                'address'          => I('POST.address'),
                'shipid'          => I('POST.shipid'),
                'shipname'          => I('POST.shipname'),
                'express'          => I('POST.express'),
                'shiptime'      => date("Y-m-d H:i:s"),
                'orderstatus' => '2'
            ];

            // 入库
            $res = $JFLotteryRecord->where("id = $id")->save($data);
            if ($res) {
                $this->success('修改成功',U('index?id='.I('POST.l_id')));
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
