<?php
/**
 * 拼多多订单管理类
 */
namespace Common\Model;
use Think\Model;

class PddOrderModel extends Model
{
	//验证规则
	protected $_validate =array(
			array('user_id','require','用户不能为空！',self::EXISTS_VALIDATE),  //存在验证，必填
			array('user_id','is_positive_int','用户不存在',self::EXISTS_VALIDATE,'function'),  //存在验证，必须是正整数
	);
	
	/**
	 * 获取订单详情
	 * @param int $id:订单ID
	 * @return array|boolean
	 */
	public function getOrderMsg($id)
	{
		$msg=$this->where("id='$id'")->find();
		if($msg)
		{
			if($msg['user_id'])
			{
				$User=new \Common\Model\UserModel();
				$userMsg=$User->getUserMsg($msg['user_id']);
				$msg['user_account']=$userMsg['phone'];
			}
			return $msg;
		}else {
			return false;
		}
	}
	
	/**
	 * 给会员返利
	 * @param string $order_sn:订单号
	 * @param string $money:佣金
	 * @return boolean
	 */
	public function treat($order_sn,$money)
	{
		$msg=$this->where("order_sn='$order_sn'")->find();
		if($msg)
		{
			//给购买会员返利
			$uid=$msg['user_id'];
			$User=new \Common\Model\UserModel();
			$UserMsg=$User->getUserMsg($uid);
			//根据用户所在的组获取相应收益比例
			$UserGroup=new \Common\Model\UserGroupModel();
			$groupMsg=$UserGroup->getGroupMsg($UserMsg['group_id']);
			if($groupMsg and $UserMsg)
			{
				//佣金改为元
				$money=$money/100;
				//佣金-客户
				$money_user=$money*$groupMsg['fee_user']/100;
				//四舍五入
				$money_user=round($money_user, 2);
				//佣金-扣税
				$money_service=$money*$groupMsg['fee_service']/100;
				//四舍五入
				$money_service=round($money_service, 2);
				//佣金-平台
				$money_plantform=$money*$groupMsg['fee_plantform']/100;
				//四舍五入
				$money_plantform=round($money_plantform, 2);
				$data_user=array(
						'balance'=>$UserMsg['balance']+$money_user,
						'balance_user'=>$UserMsg['balance_user']+$money_user,
						'balance_service'=>$UserMsg['balance_service']+$money_service,
						'balance_plantform'=>$UserMsg['balance_plantform']+$money_plantform,
				);
				if(!$User->create($data_user))
				{
					//验证不通过
					return false;
				}else {
					//开启事务
					$User->startTrans();
					//增加用户余额
					$res_balance=$User->where("uid='$uid'")->save($data_user);
					//保存余额变动记录
					$UserBalanceRecord=new \Common\Model\UserBalanceRecordModel();
					$all_money=$UserMsg['balance']+$money_user;
					$res_record=$UserBalanceRecord->addLog($uid, $money_user, $all_money, 'pdd','2',$order_sn,'3');
					
					//修改本订单状态
					//计算实际佣金
					$commission=$money_user*100;
					$data_order=array(
							'user_id'=>$uid,
							'status'=>'2',
							'promotion_amount'=>$commission
					);
					$res_order=$this->where("order_sn='$order_sn'")->save($data_order);
					
					if($res_balance!==false and $res_record!==false and $res_order!==false)
					{
						//极光推送消息
						Vendor('jpush.jpush','','.class.php');
						$jpush=new \jpush();
						$alias=$uid;//推送别名
						$title='收入通知';
						$content='您有一笔'.$money_user.'元收入，请查收！';
						$key='banlance';
						$value='pdd';
						$res_push=$jpush->push($alias,$title,$content,'',$msg_title='',$msg_content='',$key,$value);
						
						//给直接推荐、间接推荐人返利
						//并且购买用户是普通会员
						if($UserMsg['referrer_id'] and ($UserMsg['group_id']=='1' or $UserMsg['group_id']=='2'))
						{
							//存在直接推荐人
							$referrer_id=$UserMsg['referrer_id'];
							$referrerMsg=$User->getUserMsg($referrer_id);
							//不同会员组，直接推荐佣金不同
							switch ($referrerMsg['group_id'])
							{
								//成长熊
								case 1:
									//总佣金12%
									$referrer_money=$money*0.12;
									//团队中精英熊、汇客熊会员数
									$is_vip=0;
									break;
								//奋斗熊
								case 2:
									//总佣金12%
									$referrer_money=$money*0.12;
									//团队中精英熊、汇客熊会员数
									$is_vip=0;
									break;
								//精英熊
								case 3:
									//总佣金15%
									$referrer_money=$money*0.15;
									//团队中精英熊、汇客熊会员数
									$is_vip=1;
									break;
								//汇客熊
								case 4:
									//总佣金15%
									$referrer_money=$money*0.15;
									//团队中精英熊、汇客熊会员数
									$is_vip=1;
									break;
							}
							//四舍五入，保留2位
							$referrer_money=round($referrer_money,2);
							//增加直接推荐人用户余额
							$res_balance_r=$User->where("uid='$referrer_id'")->setInc('balance',$referrer_money);
							//保存余额变动记录
							$all_money_r=$referrerMsg['balance']+$referrer_money;
							$res_record_r=$UserBalanceRecord->addLog($referrer_id, $referrer_money, $all_money_r, 'pdd_r','2',$order_sn,'3');
							
							if($res_balance_r!==false and $res_record_r!==false) {
								$alias=$referrer_id;//推送别名
								$title='收入通知';
								$content='您有一笔'.$referrer_money.'元收入，请查收！';
								$key='banlance';
								$value='pdd1';
								$res_push=$jpush->push($alias,$title,$content,'',$msg_title='',$msg_content='',$key,$value);
								
								//给间接推荐人返利
								if($referrerMsg['referrer_id'])
								{
									//存在间接推荐人
									$referrer_id2=$referrerMsg['referrer_id'];
									$referrerMsg2=$User->getUserMsg($referrer_id2);
									//不同会员组，间接推荐佣金不同
									switch ($referrerMsg2['group_id'])
									{
										//成长熊
										case 1:
											//无佣金
											$referrer_money2=0;
											break;
										//奋斗熊
										case 2:
											//总佣金5%
											$referrer_money2=$money*0.05;
											break;
										//精英熊
										case 3:
											//总佣金10%
											$referrer_money2=$money*0.1;
											//团队中精英熊、汇客熊会员数
											$is_vip+=1;
											break;
										//汇客熊
										case 4:
											//总佣金12%
											$referrer_money2=$money*0.12;
											//团队中精英熊、汇客熊会员数
											$is_vip+=1;
											break;
									}
									if($referrer_money2>0)
									{
										//四舍五入，保留2位
										$referrer_money2=round($referrer_money2,2);
										//增加间接推荐人用户余额
										$res_balance_r2=$User->where("uid='$referrer_id2'")->setInc('balance',$referrer_money2);
										//保存余额变动记录
										$all_money_r2=$referrerMsg2['balance']+$referrer_money2;
										$res_record_r2=$UserBalanceRecord->addLog($referrer_id2, $referrer_money2, $all_money_r2, 'pdd_r2','2',$order_sn,'3');
									}else {
										$res_balance_r2=true;
										$res_record_r2=true;
									}
									if($res_balance_r2!==false and $res_record_r2!==false)
									{
										$alias=$referrer_id2;//推送别名
										$title='收入通知';
										$content='您有一笔'.$referrer_money2.'元收入，请查收！';
										$key='banlance';
										$value='pdd2';
										$res_push=$jpush->push($alias,$title,$content,'',$msg_title='',$msg_content='',$key,$value);
										
										//往上找无限极，给与团队奖励
										if($is_vip<2)
										{
											//团队路径
											$path=$UserMsg['path'];
											$teamList=$User->where("uid in ($path)")->field('uid,group_id,balance')->order('uid desc')->select();
											//删除团队中的自己、一级、二级推荐人，从第四个开始计算
											$team_num=count($teamList);
											for($i=3;$i<$team_num;$i++)
											{
												if($is_vip<2)
												{
													$referrer_tgid=$teamList[$i]['group_id'];
													if($referrer_tgid=='3' or $referrer_tgid=='4')
													{
														//精英熊、汇客熊可以拿
														$referrer_tid=$teamList[$i]['uid'];
														//团队佣金
														if($is_vip==0)
														{
															if($referrer_tgid=='3')
															{
																//团队佣金=总佣金10%-精英熊
																$referrer_money_team=$money*0.1;
															}else {
																//团队佣金=总佣金12%-汇客熊
																$referrer_money_team=$money*0.12;
															}
														}else {
															//团队佣金=总佣金5%
															$referrer_money_team=$money*0.05;
														}
														//四舍五入，保留2位
														$referrer_money_team=round($referrer_money_team,2);
														if($referrer_money_team>0)
														{
															//增加团队推荐人用户余额
															$res_balance_rt=$User->where("uid='$referrer_tid'")->setInc('balance',$referrer_money_team);
															//保存余额变动记录
															$all_money_rt=$teamList[$i]['balance']+$referrer_money_team;
															$res_record_rt=$UserBalanceRecord->addLog($referrer_tid, $referrer_money_team, $all_money_rt, 'pdd_rt','2',$order_sn,'3');
															if($res_balance_rt!==false and $res_record_rt!==false)
															{
																//团队精英熊、汇客熊人数+1
																$is_vip+=1;
																
																$alias=$referrer_tid;//推送别名
																$title='收入通知';
																$content='您有一笔'.$referrer_money_team.'元收入，请查收！';
																$key='banlance';
																$value='pddt';
																$res_push=$jpush->push($alias,$title,$content,'',$msg_title='',$msg_content='',$key,$value);
																
																continue;
															}else {
																//回滚
																$User->rollback();
																return false;
															}
														}
													}else {
														continue;
													}
												}else {
													//团队奖励已完成，跳出循环
													break;
												}
											}
											//提交事务
											$User->commit();
											return true;
										}else {
											//提交事务
											$User->commit();
											return true;
										}
									}else {
										//回滚
										$User->rollback();
										return false;
									}
								}else {
									//不存在间接推荐人
									//提交事务
									$User->commit();
									return true;
								}
							}else {
								//回滚
								$User->rollback();
								return false;
							}
						}else {
							//不存在直接推荐人
							//提交事务
							$User->commit();
							return true;
						}
					}else {
						//回滚
						$User->rollback();
						return false;
					}
				}
			}else {
				//用户组不存在
				return false;
			}
		}else {
			return false;
		}
	}
	
	/**
	 * 给会员返利-预估
	 * @param string $order_sn:订单号
	 * @param string $money:佣金
	 * @return boolean
	 */
	public function treat_tmp($order_sn,$money)
	{
		$msg=$this->where("order_sn='$order_sn'")->find();
		if($msg)
		{
			$UserBalanceRecordTmp=new \Common\Model\UserBalanceRecordTmpModel();
			//判断该订单是否已存在
			$where=array(
					'type'=>'3',//拼多多
					'order_id'=>$order_sn
			);
			$res_exist=$UserBalanceRecordTmp->where($where)->order('id desc')->find();
			if($res_exist)
			{
				//已存在，不处理
				return true;
			}else {
				//给购买会员返利
				$uid=$msg['user_id'];
				$User=new \Common\Model\UserModel();
				$UserMsg=$User->getUserMsg($uid);
				//根据用户所在的组获取相应收益比例
				$UserGroup=new \Common\Model\UserGroupModel();
				$groupMsg=$UserGroup->getGroupMsg($UserMsg['group_id']);
				if($groupMsg and $UserMsg)
				{
					//佣金改为元
					$money=$money/100;
					//佣金-客户
					$money_user=$money*$groupMsg['fee_user']/100;
					//四舍五入
					$money_user=round($money_user, 2);
						
					//开启事务
					$UserBalanceRecordTmp->startTrans();
					//保存余额变动记录-预估
					$create_time=date('Y-m-d H:i:s',$msg['order_create_time']);
					$res_record=$UserBalanceRecordTmp->addLog($uid,$money_user,$action='pdd',$order_sn,$type='3',$create_time);
					if($res_record!==false)
					{
						//给直接推荐、间接推荐人返利
						//并且购买用户是普通会员
						if($UserMsg['referrer_id'] and ($UserMsg['group_id']=='1' or $UserMsg['group_id']=='2'))
						{
							//存在直接推荐人
							$referrer_id=$UserMsg['referrer_id'];
							$referrerMsg=$User->getUserMsg($referrer_id);
							//不同会员组，直接推荐佣金不同
							switch ($referrerMsg['group_id'])
							{
								//成长熊
								case 1:
									//总佣金12%
									$referrer_money=$money*0.12;
									//团队中精英熊、汇客熊会员数
									$is_vip=0;
									break;
								//奋斗熊
								case 2:
									//总佣金12%
									$referrer_money=$money*0.12;
									//团队中精英熊、汇客熊会员数
									$is_vip=0;
									break;
								//精英熊
								case 3:
									//总佣金15%
									$referrer_money=$money*0.15;
									//团队中精英熊、汇客熊会员数
									$is_vip=1;
									break;
								//汇客熊
								case 4:
									//总佣金15%
									$referrer_money=$money*0.15;
									//团队中精英熊、汇客熊会员数
									$is_vip=1;
									break;
							}
							//四舍五入，保留2位
							$referrer_money=round($referrer_money,2);
							//保存余额变动记录
							$res_record_r=$UserBalanceRecordTmp->addLog($referrer_id,$referrer_money,$action='pdd_r',$order_sn,$type='3',$create_time);
							if($res_record_r!==false)
							{
								//给间接推荐人返利
								if($referrerMsg['referrer_id'])
								{
									//存在间接推荐人
									$referrer_id2=$referrerMsg['referrer_id'];
									$referrerMsg2=$User->getUserMsg($referrer_id2);
									//不同会员组，间接推荐佣金不同
									switch ($referrerMsg2['group_id'])
									{
										//成长熊
										case 1:
											//无佣金
											$referrer_money2=0;
											break;
										//奋斗熊
										case 2:
											//总佣金5%
											$referrer_money2=$money*0.05;
											break;
										//精英熊
										case 3:
											//总佣金10%
											$referrer_money2=$money*0.1;
											//团队中精英熊、汇客熊会员数
											$is_vip+=1;
											break;
										//汇客熊
										case 4:
											//总佣金12%
											$referrer_money2=$money*0.12;
											//团队中精英熊、汇客熊会员数
											$is_vip+=1;
											break;
									}
									if($referrer_money2>0)
									{
										//四舍五入，保留2位
										$referrer_money2=round($referrer_money2,2);
										//保存余额变动记录
										$res_record_r2=$UserBalanceRecordTmp->addLog($referrer_id2,$referrer_money2,$action='pdd_r2',$order_sn,$type='3',$create_time);
									}else {
										$res_record_r2=true;
									}
									if($res_record_r2!==false)
									{
										//往上找无限极，给与团队奖励
										if($is_vip<2)
										{
											//团队路径
											$path=$UserMsg['path'];
											$teamList=$User->where("uid in ($path)")->field('uid,group_id,balance')->order('uid desc')->select();
											//删除团队中的自己、一级、二级推荐人，从第四个开始计算
											$team_num=count($teamList);
											for($i=3;$i<$team_num;$i++)
											{
												if($is_vip<2)
												{
													$referrer_tgid=$teamList[$i]['group_id'];
													if($referrer_tgid=='3' or $referrer_tgid=='4')
													{
														//精英熊、汇客熊可以拿
														$referrer_tid=$teamList[$i]['uid'];
														//团队佣金
														if($is_vip==0)
														{
															if($referrer_tgid=='3')
															{
																//团队佣金=总佣金10%-精英熊
																$referrer_money_team=$money*0.1;
															}else {
																//团队佣金=总佣金12%-汇客熊
																$referrer_money_team=$money*0.12;
															}
														}else {
															//团队佣金=总佣金5%
															$referrer_money_team=$money*0.05;
														}
														//四舍五入，保留2位
														$referrer_money_team=round($referrer_money_team,2);
														if($referrer_money_team>0)
														{
															//保存余额变动记录
															$res_record_rt=$UserBalanceRecordTmp->addLog($referrer_tid,$referrer_money_team,$action='pdd_rt',$order_sn,$type='3',$create_time);
															if($res_record_rt!==false)
															{
																//团队精英熊、汇客熊人数+1
																$is_vip+=1;
																continue;
															}else {
																//回滚
																$UserBalanceRecordTmp->rollback();
																return false;
															}
														}
													}else {
														continue;
													}
												}else {
													//团队奖励已完成，跳出循环
													break;
												}
											}
											//提交事务
											$UserBalanceRecordTmp->commit();
											return true;
										}else {
											//提交事务
											$UserBalanceRecordTmp->commit();
											return true;
										}
									}else {
										//回滚
										$UserBalanceRecordTmp->rollback();
										return false;
									}
								}else {
									//不存在间接推荐人
									//提交事务
									$UserBalanceRecordTmp->commit();
									return true;
								}
							}else {
								//回滚
								$UserBalanceRecordTmp->rollback();
								return false;
							}
						}else {
							//不存在直接推荐人
							//提交事务
							$UserBalanceRecordTmp->commit();
							return true;
						}
					}else {
						//回滚
						$UserBalanceRecordTmp->rollback();
						return false;
					}
				}else {
					return false;
				}
			}
		}else {
			return false;
		}
	}
}
?>