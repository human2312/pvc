<?php
/**
 * 拼多多商品分类管理
 */
namespace Admin\Controller;
use Admin\Common\Controller\AuthController;
class PddCatController extends AuthController
{
    public function index()
    {
    	//获取商品分类列表
    	$PddCat=new \Common\Model\PddCatModel();
    	$list=$PddCat->getGoodsCatList();
    	$this->assign('list',$list);
        $this->display();
    }
    
    //添加拼多多商品分类
    public function add()
    {
    	$PddCat=new \Common\Model\PddCatModel();
    	
    	if($_POST) {
    		layout(false);
    		if(trim(I('post.name')) and trim(I('post.pdd_id')))
    		{
    			//上传商户类型图标
    			if(!empty($_FILES['img']['name']))
    			{
    				$config = array(
    						'mimes'         =>  array(), //允许上传的文件MiMe类型
    						'maxSize'       =>  1024*1024*4, //上传的文件大小限制 (0-不做限制)
    						'exts'          =>  array('jpg', 'gif', 'png', 'jpeg'), //允许上传的文件后缀
    						'rootPath'      =>  './Public/Upload/PddCat/', //保存根路径
    						'savePath'      =>  '', //保存路径
    						'saveExt'       =>  '', //文件保存后缀，空则使用原后缀
    						'subName'       =>  '', //子目录创建方式
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
    			}else {
    				$img='';
    			}
    			//保存到数据库
    			$data=array(
    					'name'=>trim(I('post.name')),
    					'icon'=>$img,
    					'sort'=>I('post.sort'),
    					'is_show'=>I('post.is_show'),
    					'pid'=>I('post.pid'),
    					'pdd_id'=>trim(I('post.pdd_id')),
    			);
    			if(!$PddCat->create($data)) {
    				// 验证不通过
    				// 删除图片
    				if($img) {
    					@unlink($filepath);
    				}
    				$this->error($PddCat->getError());
    			}else {
    				// 验证成功
    				$res_add=$PddCat->add($data);
    				if($res_add!==false) {
    					$this->success('新增拼多多商品分类成功！',U('index'));
    				}else {
    					// 删除图片
    					if($img) {
    						@unlink($filepath);
    					}
    					$this->error('操作失败！');
    				}
    			}
    		}else {
    			$this->error('分类名称、拼多多官方分类ID不能为空！');
    		}
    	}else {
    	    //获取商户类型列表
    	    $catlist=$PddCat->getGoodsCatList('Y');
    	    $this->assign('catlist',$catlist);
    	    
    		$this->display();
    	}
    }
    
    //编辑拼多多商品分类
    public function edit($pdd_cat_id)
    {
    	$PddCat=new \Common\Model\PddCatModel();
    	//获取子分类
    	$sublist=$PddCat->getSubList($pdd_cat_id);
    	$subnum=count($sublist);
    	for($i=0;$i<$subnum;$i++)
    	{
    		$subarr[]=$sublist[$i]['jingdong_cat_id'];
    	}
    	$this->assign('subarr',$subarr);
    	
    	//获取拼多多商品分类信息
    	$msg=$PddCat->getMsg($pdd_cat_id);
    	 
    	if($_POST) {
    		layout(false);
    		if(trim(I('post.name')) and trim(I('post.pdd_id')))
    		{
    			//上传图标
    			if(!empty($_FILES['img']['name']))
    			{
    				$config = array(
    						'mimes'         =>  array(), //允许上传的文件MiMe类型
    						'maxSize'       =>  1024*1024*4, //上传的文件大小限制 (0-不做限制)
    						'exts'          =>  array('jpg', 'gif', 'png', 'jpeg'), //允许上传的文件后缀
    						'rootPath'      =>  './Public/Upload/PddCat/', //保存根路径
    						'savePath'      =>  '', //保存路径
    						'saveExt'       =>  '', //文件保存后缀，空则使用原后缀
    						'subName'       =>  '', //子目录创建方式
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
    			}else {
    				$img=I('post.oldimg');
    			}
    			//保存到数据库
    			$data=array(
    					'name'=>trim(I('post.name')),
    					'icon'=>$img,
    					'sort'=>I('post.sort'),
    					'is_show'=>I('post.is_show'),
    					'pid'=>I('post.pid'),
    					'pdd_id'=>trim(I('post.pdd_id')),
    			);
    			if(!$PddCat->create($data)) {
    				// 验证不通过
    				// 删除图片
    				if($filepath) {
    					@unlink($filepath);
    				}
    				$this->error($PddCat->getError());
    			}else {
    				// 验证成功
    				$res_edit=$PddCat->where("pdd_cat_id='$pdd_cat_id'")->save($data);
    				if($res_edit!==false) {
    					// 原图片存在，并且上传了新图片的情况下，删除原标题图片
    					if(I('post.oldimg') and $img!=I('post.oldimg')) {
    						$oldimg='.'.I('post.oldimg');
    						unlink($oldimg);
    					}
    					$this->success('修改拼多多商品分类成功！',U('index'));
    				}else {
    					// 删除图片
    					if($filepath) {
    						@unlink($filepath);
    					}
    					$this->error('修改拼多多商品分类失败！');
    				}
    			}
    		}else {
    			$this->error('分类名称、拼多多官方分类ID不能为空！');
    		}
    	}else {
    	    //获取商户类型列表
    	    $catlist=$PddCat->getGoodsCatList('Y');
    	    $this->assign('catlist',$catlist);
    	    
    	    $this->assign('msg',$msg);
    	    
    		$this->display();
    	}
    }
    
    //删除商品分类
    public function del($id)
    {
    	$PddCat=new \Common\Model\PddCatModel();
    	/* 
    	 * 先判断分类下是否有二级分类
    	 * 存在不准删除，需要先删除二级分类
    	 *  */
    	$res_p=$PddCat->where("pid=$id")->count();
    	if($res_p>0) {
    		echo '2';
    		exit();
    	}
    	
    	$msg=$PddCat->getMsg($id);
    	$res=$PddCat->where("pdd_cat_id=$id")->delete();
    	if($res!==false) {
    		//删除图片
    		if(!empty($msg['icon'])) {
    			$img='.'.$msg['icon'];
    			@unlink($img);
    		}
    		echo '1';
    	}else {
    		echo '0';
    	}
    }
    
    //修改拼多多商品分类状态
    public function changestatus($id,$status)
    {
    	$data=array(
    			'is_show'=>$status
    	);
    	$PddCat=new \Common\Model\PddCatModel();
    	if(!$PddCat->create($data)) {
    		// 验证不通过
    		echo '0';
    	}else {
    		// 验证成功
    		$res=$PddCat->where("pdd_cat_id='$id'")->save($data);
    		if($res===false) {
    			echo '0';
    		}else {
    			echo '1';
    		}
    	}
    }
    
    //批量修改排序
    public function changesort()
    {
    	$sort_array=I('post.sort');
    	$ids = implode(',', array_keys($sort_array));
    	$sql = "UPDATE __PREFIX__pdd_cat SET sort = CASE pdd_cat_id ";
    	foreach ($sort_array as $id => $sort) {
    		$sql .= sprintf("WHEN %d THEN %d ", $id, $sort);
    	}
    	$sql.= "END WHERE pdd_cat_id IN ($ids)";
    	$res = M()->execute($sql);
    	layout(false);
    	if($res===false)
    	{
    		$this->error('操作失败!');
    	}else {
    		$this->success('排序成功!',U('index'),3);
    	}
    }
    
    //删除原图标
    public function deloldimg($pdd_cat_id)
    {
    	$PddCat=new \Common\Model\PddCatModel();
    	$msg=$PddCat->where("pdd_cat_id='$pdd_cat_id'")->find();
    	if($msg===false) {
    		echo '0';
    	}else {
    		//修改icon为空
    		$data=array(
    				'icon'=>''
    		);
    		$res=$PddCat->where("pdd_cat_id='$pdd_cat_id'")->save($data);
    		if($res!==false) {
    			$oldimg='.'.$msg['icon'];
    			@unlink($oldimg);
    			echo '1';
    		}else {
    			echo '0';
    		}
    	}
    }
    
    //根据父级分类ID获取子分类列表
    public function getSubCatList($pid)
    {
    	$PddCat=new \Common\Model\PddCatModel();
    	$list=$PddCat->getSubList($pid,'asc','Y');
    	if($list) {
    		echo json_encode($list);
    	}else {
    		echo '0';
    	}
    }
}