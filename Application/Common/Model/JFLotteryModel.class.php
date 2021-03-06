<?php
/**
 * 拉新活动
 */
namespace Common\Model;
use Think\Model;

class JFLotteryModel extends Model
{
    // 验证规则
    protected $_validate = array(
        array('name','require','活动名称不能为空'), // 存在验证，必填
    );
    
    /**
     * 获取最新的活动
     * @return array|boolean
     */
    public function getLastRookie()
    {
        $msg=$this->where("end_time>NOW()")->order('id desc')->find();
        if($msg){
            //获取活动奖项设置
            $RookieDetails=new \Common\Model\RookieDetailsModel();
            $msg['rewardSet']=$RookieDetails->getRewardSet($msg['id']);
            return $msg;
        }else {
            return false;
        }
    }
    
    /**
     * 获取活动信息
     * @param int $id:活动ID
     * @return array|boolean
     */
    public function getActivityMsg($id)
    {
        $msg=$this->where("id=$id")->find();
        if($msg){
            return $msg;
        }else {
            return false;
        }
    }
    
    /**
     * 获取活动详情
     * @param int $id:活动ID
     * @param string $order:奖项设置排序方式，asc、desc
     * @return array|boolean
     */
    public function getActivityDetail($id,$order='asc')
    {
        $msg=$this->getActivityMsg($id);
        if($msg){
            //获取活动奖项设置
            $RookieDetails=new \Common\Model\RookieDetailsModel();
            $msg['rewardSet']=$RookieDetails->getRewardSet($msg['id'],$order);
            return $msg;
        }else {
            return false;
        }
    }
}
