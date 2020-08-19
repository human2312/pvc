<?php
/**
 * 抽奖管理
 */
namespace Admin\Controller;
use Admin\Common\Controller\AuthController;

class JFLotteryController extends AuthController
{
    // 拉新活动
    public function index()
    {
        // 实例化Model类
        $JFLottery = new \Common\Model\JFLotteryModel();
        $Page = new \Common\Model\PageModel();

        // 搜索条件
        if (I('GET.search')) {
            $search = I('GET.search');
            $where['name'] = ['like', "%$search%"];
            // 搜索条件返还给模板
            $this->assign('search', $search);
        }

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
    public function add()
    {
        // 实例化Model类
        $Rookie = new \Common\Model\JFLotteryModel();

        if (I('POST.')) {
            layout(false);

            // 转成标准时间格式
            $start_time = str_replace('T', ' ', I('POST.start_time'));
            $end_time = str_replace('T', ' ', I('POST.end_time'));
            $open_time = str_replace('T', ' ', I('POST.open_time'));
            $start_time = $start_time.':00';
            $end_time = $end_time.':00';
            $open_time = $open_time.':00';

            //上传文件
            $goodsimg = "";
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
                    $goodsimg=substr($filepath,1);
                }
            }

            // 组装数据
            $data = [
                'name'          => I('POST.name'),
                'maxnum'          => I('POST.maxnum'),
                'content'          => I('POST.content'),
                'goodsimg'    => $goodsimg,
                'needjf'    =>I('POST.needjf'),
                'num'    =>I('POST.num'),
                'backjf'    =>I('POST.backjf'),
                'start_time'      => $start_time,
                'end_time'        => $end_time,
                'open_time'        => $open_time,
                'add_time'      => date("Y-m-d H:i:s")
            ];
            // 数据验证
            if (!$Rookie->create($data)) {
                $this->error($Rookie->getError());
            }

            // 入库
            $res = $Rookie->add($data);
            if ($res) {
                $this->success('添加成功',U('index'));
            } else {
                $this->error('系统出错，请重试');
            }

        } else {
            $this->display();
        }
    }

    //  修改拉新活动
    public function edit($id)
    {
        // 实例化Model类
        $Rookie = new \Common\Model\JFLotteryModel();

        // 查询数据
        $data = $Rookie->where("id = $id")->find();

        if (I('POST.')) {
            layout(false);

            // 转成标准时间格式
            $start_time = str_replace('T', ' ', I('POST.start_time'));
            $end_time = str_replace('T', ' ', I('POST.end_time'));
            $open_time = str_replace('T', ' ', I('POST.open_time'));
            $start_time = $start_time.':00';
            $end_time = $end_time.':00';
            $open_time = $open_time.':00';

            //上传文件
            $goodsimg = "";
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
                    $goodsimg=substr($filepath,1);
                }
            }else {
                $goodsimg=I('post.oldimg');
            }

            // 组装数据
            $data = [
                'name'          => I('POST.name'),
                'maxnum'          => I('POST.maxnum'),
                'content'          => I('POST.content'),
                'goodsimg'    => $goodsimg,
                'needjf'    =>I('POST.needjf'),
                'num'    =>I('POST.num'),
                'backjf'    =>I('POST.backjf'),
                'start_time'      => $start_time,
                'end_time'        => $end_time,
                'open_time'        => $open_time,
                'add_time'      => date("Y-m-d H:i:s")
            ];

            // 入库
            $res = $Rookie->where("id = $id")->save($data);
            if ($res) {
                $this->success('修改成功',U('index'));
            } else {
                $this->error('系统出错，请重试');
            }

        } else {

            // 时间空格转T
            $data['start_time'] = str_replace(" ", "T", $data['start_time']);
            $data['end_time'] = str_replace(" ", "T", $data['end_time']);
            $data['open_time'] = str_replace(" ", "T", $data['open_time']);

            // 模板渲染
            $this->assign('data', $data);
            $this->assign('id', $id);
            $this->display();
        }
    }

    //  删除拉新活动
    public function del()
    {
        // 实例化Model类
        $Rookie = new \Common\Model\JFLotteryModel();

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

    //删除原分类图片
    public function deloldimg($cat_id)
    {
        $GoodsCat=new \Common\Model\JFLotteryModel();
        $res=$GoodsCat->where("id=$cat_id")->find();

        if($res===false)
        {
            echo '0';
        }else {
            $oldimg=$res['goodsimg'];
            //修改img为空
            $data=array(
                'goodsimg'=>''
            );
            $res2=$GoodsCat->where("id=$cat_id")->save($data);
            if($res2)
            {
                $oldimg='.'.$oldimg;
                unlink($oldimg);
                echo '1';
            }else {
                echo '0';
            }
        }
    }

}
