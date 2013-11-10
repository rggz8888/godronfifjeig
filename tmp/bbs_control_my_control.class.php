<?php

/*
 * Copyright (C) xiuno.com
 */

!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');
	include '/home/xmulifec/domains/xmulife.com/public_html/tmp/control_common_control.class.php';

class my_control extends common_control {
	
	function __construct(&$conf) {
		parent::__construct($conf);
		$this->check_login();
		
		// 初始化用户信息
		$uid = $this->_user['uid'];
		$user = $this->user->read($uid);
		$this->check_user_exists($user);
		$this->user->format($user);
		
		$user['groupname'] = $this->conf['grouparr'][$user['groupid']];
		
		$this->_user = $user;
	}
	
	public function on_index() {
		

		$this->on_profile();
	}
	
	// ------------------> 个人资料
	
	public function on_profile() {
		$this->_checked['my_profile'] = 'class="checked"';
		$this->_checked['profile'] = 'class="checked"';
		
		$this->_title[] = '基本资料';
		$this->_nav[] = '基本资料';
		
		$_user = $this->_user;
		$uid = $_user['uid'];
			

		$this->view->display('my_profile.htm');
	}
	
	public function on_homepage() {
		$this->_checked['my_profile'] = 'class="checked"';
		$this->_checked['homepage'] = 'class="checked"';
		
		$this->_title[] = '修改个人信息';
		$this->_nav[] = '修改个人信息';
		
		$_user = $this->_user;
		$uid = $_user['uid'];
		$user = $this->user->read($uid);
		
		$error = array();
		if($this->form_submit()) {
			$homepage = core::gpc('homepage', 'P');
			
			$error['homepage'] = $this->user->check_homepage($homepage);
			
			$user['homepage'] = $homepage;
			

			if(!array_filter($error)) {
				$user = $this->user->read($uid);
				$user['homepage'] = $homepage;
				$this->user->update($user);
				$error = array();

			}
		}
		$this->user->format($user);
		
		$this->view->assign('user', $user);
		$this->view->assign('error', $error);
		

		$this->view->display('my_homepage.htm');
	}
	
	public function on_password() {
		$this->_checked['my_profile'] = 'class="checked"';
		$this->_checked['password'] = 'class="checked"';
		
		$this->_title[] = '修改密码';
		$this->_nav[] = '修改密码';
		
		$_user = $this->_user;
		$uid = $_user['uid'];
		
		$error = array();
		if($this->form_submit()) {
			$password = core::gpc('password', 'P');
			$newpassword = core::gpc('newpassword', 'P');
			$newpassword2 = core::gpc('newpassword2', 'P');
			
			// 检查原密码是否正确
			$_user['password'] && $error['password'] = $this->user->verify_password($password, $_user['password'], $_user['salt']) ? '' : '旧密码错误';
			$error['newpassword'] = $this->user->check_password($newpassword);
			$error['newpassword2'] = $this->user->check_password2($newpassword, $newpassword2);

			
			if(!array_filter($error)) {
				$user = $this->user->read($uid);
				$user['password'] = $this->user->md5_md5($newpassword, $user['salt']);
				$this->user->update($user);
				$error = array();
				
				// 重新设置 cookie
				$this->user->set_login_cookie($user);
				

			}
		}
		
		$this->view->assign('error', $error);

		$this->view->display('my_password.htm');
	}
	
	public function on_avatar() {
		$this->_checked['my_profile'] = 'class="checked"';
		$this->_checked['avatar'] = 'class="checked"';
		
		$this->_title[] = '修改头像';
		$this->_nav[] = '修改头像';
		
		$_user = $this->_user;
		$uid = $_user['uid'];
		

		$this->view->display('my_avatar.htm');
	}
	
	// -----------------> 我的发帖
	public function on_post() {
		$this->_checked['my_post'] = 'class="checked"';
		
		$this->_title[] = '我的帖子';
		$this->_nav[] = '我的帖子';
		

		
		// 翻页：上一页，下一页
		$page = misc::page();
		$uid = $this->_user['uid'];
		$user = $this->_user;
		
		$page = misc::page();
		$pagesize = 40;
		$mypostlist = $this->mypost->get_list_by_uid($uid, $page, $pagesize);
		$pages = misc::simple_pages("http://www.xmulife.com/my-post.htm", count($mypostlist), $page, $pagesize);
		
		foreach($mypostlist as &$post) {
			$post['forumname'] = isset($this->conf['forumarr'][$post['fid']]) ? $this->conf['forumarr'][$post['fid']] : '';
			$this->mypost->format($post);
		}
		
		$this->view->assign('pages', $pages);
		$this->view->assign('mypostlist', $mypostlist);
		

		$this->view->display('my_post.htm');
	}
	
	// -----------------------> 我的联系人
	
	// 我的关注，一次全部取出。最多100个。
	public function on_follow() {
		$this->_checked['my_follow'] = 'class="checked"';
		$this->_checked['follow'] = 'class="checked"';
		
		$_user = $this->_user;
		$uid = $_user['uid'];
		
		$this->_title[] = '我的关注';
		$this->_nav[] = '我的关注';
		
		$page = misc::page();
		$pagesize = 64;
		$followlist = $this->follow->get_list_by_uid($uid, $page, $pagesize);
		$pages = misc::simple_pages("http://www.xmulife.com/my-follow.htm", count($followlist), $page, $pagesize);
		$this->view->assign('pages', $pages);
		$this->view->assign('userlist', $followlist);
		

		$this->view->display('my_follow.htm');
		
	}
	
	// 我的粉丝，100个
	public function on_followed() {
		$this->_checked['my_follow'] = 'class="checked"';
		$this->_checked['followed'] = 'class="checked"';
		
		$_user = $this->_user;
		$uid = $_user['uid'];
		
		$this->_title[] = '我的粉丝';
		$this->_nav[] = '我的粉丝';
		
		$page = misc::page();
		$pagesize = 64;
		$followedlist = $this->follow->get_followedlist_by_uid($uid, $page, $pagesize);
		$pages = misc::simple_pages("http://www.xmulife.com/my-followed.htm", count($followedlist), $page, $pagesize);
		$this->view->assign('pages', $pages);
		$this->view->assign('userlist', $followedlist);
		

		$this->view->display('my_followed.htm');
	}
	
	
	// 最近联系人 40 个
	public function on_pm() {
		$this->_checked['my_follow'] = 'class="checked"';
		$this->_checked['pm'] = 'class="checked"';
		
		$user = $this->_user;
		$uid = $user['uid'];
		
		$this->_title[] = '最近联系人';
		$this->_nav[] = '最近联系人';
		
		$newlist = $this->pmnew->get_list_by_uid($uid);
		

		$userlist = $this->pmnew->get_recent_userlist($uid);
		
		// 清理掉新短消息标志
		$user = $this->user->read($uid);
		if($user['newpms'] > 0) {
			$user['newpms'] = 0;
			$this->user->update($user);
		}
		
		$this->view->assign('newlist', $newlist);
		$this->view->assign('userlist', $userlist);

		$this->view->display('my_pm.htm');
	}
	
	
	// ----------------------------> 我的财富
	
	// 收入记录
	public function on_income() {
		$this->_checked['my_wealth'] = 'class="checked"';
		$this->_checked['income'] = 'class="checked"';
		
		$this->_title[] = '收入记录';
		$this->_nav[] = '收入记录';
		
		$_user = $this->_user;
		$uid = $_user['uid'];
		

		
		// 简单分页
		$page = misc::page();
		$pagesize = 20;
		$incomelist = $this->attach_download->get_list_by_uploaduid($uid, $page, $pagesize);
		$pages = misc::simple_pages("http://www.xmulife.com/my-income.htm", count($incomelist), $page, $pagesize);
		$this->view->assign('pages', $pages);
		$this->view->assign('incomelist', $incomelist);
		

		$this->view->display('my_income.htm');
	}
	
	// -------------------------> 我的文件
	
	// 下载记录
	public function on_download() {
		$this->_checked['my_file'] = 'class="checked"';
		$this->_checked['download'] = 'class="checked"';
		
		$_user = $this->_user;
		$uid = $_user['uid'];
		
		$this->_title[] = '下载文件';
		$this->_nav[] = '下载文件';
		

		$page = misc::page();
		$pagesize = 20;
		$downlist = $this->attach_download->get_list_by_uid($uid, $page, $pagesize);
		$pages = misc::simple_pages("http://www.xmulife.com/my-download.htm", count($downlist), $page, $pagesize);
		$this->view->assign('pages', $pages);
		$this->view->assign('downlist', $downlist);
		

		$this->view->display('my_download.htm');
	}
	

	// 我的附件
	public function on_upload() {
		$this->_checked['my_file'] = 'class="checked"';
		$this->_checked['upload'] = 'class="checked"';
		
		$_user = $this->_user;
		$uid = $_user['uid'];
		
		$this->_title[] = '上传文件';
		$this->_nav[] = '上传文件';
		

		
		$page = misc::page();
		$pagesize = 20;
		$attachlist = $this->attach->get_list_by_uid($uid, $page, $pagesize);
		$pages = misc::simple_pages("http://www.xmulife.com/my-upload.htm", count($attachlist), $page, $pagesize);
		$this->view->assign('pages', $pages);
		$this->view->assign('attachlist', $attachlist);
		

		$this->view->display('my_upload.htm');
	}
	
	// 我的图片
	public function on_image() {
		$this->_checked['my_file'] = 'class="checked"';
		$this->_checked['image'] = 'class="checked"';
		
		$_user = $this->_user;
		$uid = $_user['uid'];
		
		$this->_title[] = '上传图片';
		$this->_nav[] = '上传图片';
		

		
		$page = misc::page();
		$pagesize = 20;
		$attachlist = $this->attach->get_imagelist_by_uid($uid, $page, $pagesize);
		$pages = misc::simple_pages("http://www.xmulife.com/my-image.htm", count($attachlist), $page, $pagesize);
		$this->view->assign('pages', $pages);
		$this->view->assign('attachlist', $attachlist);
		

		$this->view->display('my_image.htm');
	}
	
	// 附件所在的主题，按照 aid 倒序。
	public function on_attachthread() {
		$fid = intval(core::gpc('fid'));
		$pid = intval(core::gpc('pid'));
		$post = $this->post->read($fid, $pid);
		$this->location("http://www.xmulife.com/thread-index-fid-$fid-tid-$post[tid].htm");
	}
	
	// 附件下载历史，翻页显示。?my-upload.htm
	public function on_downlog() {
		$fid = intval(core::gpc('fid'));
		$aid = intval(core::gpc('aid'));
		
		$this->_checked['my_file'] = 'class="checked"';
		
		$attach = $this->attach->read($fid, $aid);
		$this->attach->format($attach);
		

		
		$page = misc::page();
		$pagesize = 20;
		$downlist = $this->attach_download->get_list_by_fid_aid($fid, $aid, $page, $pagesize);
		$pages = misc::simple_pages("http://www.xmulife.com/my-downlog-fid-$fid-aid-$aid.htm", count($downlist), $page, $pagesize);
		$this->view->assign('pages', $pages);
		$this->view->assign('downlist', $downlist);
		$this->view->assign('aid', $aid);
		$this->view->assign('attach', $attach);
		

		
		$this->view->display('my_downlog.htm');
	}
	
	// --------------------> 版主管理日志
	
public function on_addcollect(){
	$uid = $this->_user['uid'];
	$tid=intval(core::gpc('tid','G'));
	$fid=intval(core::gpc('fid','G'));
	
	$this->mypost->table='mycollect';
	$this->mypost->primarykey = array('uid', 'fid', 'tid');
	
	$rs=$this->mypost->read_by_tid($uid, $fid, $tid);
	if($rs){
		$this->message('该贴已收藏',0);
	}else{
		$id=$this->mypost->create(array('uid'=>$uid,'fid'=>$fid,'tid'=>$tid));
		if($id){
			$this->message('已收藏');
		}else{
			$this->message('收藏失败',0);
		}
	}

}
public function on_collect(){
    $this->_checked['my_collect'] = 'class="checked"';
		
    $this->_title[] = '我的收藏';
    $this->_nav[] = '我的收藏';
    
    // hook my_post_before.php
    
    // 翻页：上一页，下一页
    $page = misc::page();
    $uid = $this->_user['uid'];
    $user = $this->_user;
    
    $page = misc::page();
    $pagesize = 40;

    $this->mypost->table='mycollect';
	$this->mypost->primarykey = array('uid', 'fid', 'tid');
    $mycollectlist = $this->mypost->index_fetch(array('uid'=>$uid), array('id'=>-1), ($page - 1) * $pagesize, $pagesize);
    
    $pages = misc::simple_pages("http://www.xmulife.com/my-post.htm", count($mycollectlist), $page, $pagesize);
		
    foreach($mycollectlist as &$post) {
        $post=$this->thread->read($post['fid'],$post['tid']);
        $post['forumname'] = isset($this->conf['forumarr'][$post['fid']]) ? $this->conf['forumarr'][$post['fid']] : '';
        $this->thread->format($post);
    }
    
    $this->view->assign('pages', $pages);
    $this->view->assign('mycollectlist', $mycollectlist);
    
    $this->view->display('my_collect.htm');
}
public function on_delcollect(){
    $uid = $this->_user['uid'];
	$tid=intval(core::gpc('tid','G'));
	$fid=intval(core::gpc('fid','G'));
	
	$this->mypost->table='mycollect';
	$this->mypost->primarykey = array('uid', 'fid', 'tid');
	
	$this->mypost->delete($uid, $fid, $tid);
    $this->location('http://www.xmulife.com/my-collect.htm');
}	public function on_thread() {
		$this->_checked['my_thread'] = 'class="checked"';
		
		$this->_title[] = '我的主题';
		$this->_nav[] = '我的主题';
		

		
		// 翻页：上一页，下一页
		$page = misc::page();
		$uid = $this->_user['uid'];
		$user = $this->_user;
		
		$page = misc::page();
		$pagesize = 40;
		
		$mythreadlist = $this->thread->index_fetch(array('uid'=>$uid),array('tid'=>-1),($page-1)*$pagesize, $pagesize);
		$pages = misc::simple_pages("http://www.xmulife.com/my-thread.htm", count($mythreadlist), $page, $pagesize);
		
		
		foreach($mythreadlist as $k=>&$post) {
		$this->thread->format($post);
		}
		
		$this->view->assign('pages', $pages);
		$this->view->assign('mythreadlist', $mythreadlist);
		

		$this->view->display('my_thread.htm');
	}
}

?>