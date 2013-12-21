<?php

/*
 * Copyright (C) xiuno.com
 */

!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');

include BBS_PATH.'control/common_control.class.php';

class comment_control extends common_control {
	
	function __construct(&$conf) {
		parent::__construct($conf);
		$this->_checked['bbs'] = ' class="checked"';
	}
	
	// 列表
	public function on_index() {
		
		// hook thread_index_before.php
		
		$fid = intval(core::gpc('fid'));
		$tid = intval(core::gpc('tid'));
		$uid = $this->_user['uid'];
		$page = misc::page();
		$thread_com = $this->thread->read($fid, $tid);
		$this->check_thread_exists($thread_com);
		$fpage = intval(core::gpc($this->conf['cookie_pre'].'page', 'C'));
		
		// 版块权限检查
		$forum = $this->mcache->read('forum', $fid);
		$this->check_forum_exists($forum);
		$this->check_access($forum, 'read');
		
		$this->thread->format($thread_com, $forum);
		$thread_com['subject_fmt'] = utf8::substr($thread_com['subject'], 0, 30);
		// SEO 优化
		$this->_title[] = $thread_com['subject'];
		
		// 只缓存了 第一页20个pid，超出则查询 db
		$totalpage = ceil($thread_com['posts'] / $this->conf['pagesize']);
		$page > $totalpage && $page = $totalpage;
		$comment = $this->post->index_fetch(array('fid'=>$fid, 'tid'=>$tid, 'page'=>$page), array(), 1, $this->conf['pagesize']);
		
		$comment = array_filter($comment);
		
		// php order by pid，一般情况下不用排序，但是偶尔数据库返回的数据为乱序。这里排序有问题！
		//ksort($comment);	// key 为字符串，排序不稳定。 fid-2-pid-999 fid-2-pid-1000 这种情况
		misc::arrlist_multisort($comment, 'dateline', TRUE); 	// 这里为兼顾 dx, pw 等升级过来的数据，他们的pid不是递增的，是 mysql_insert_id() 产生的。
		//misc::arrlist_multisort($comment, 'pid', TRUE);	// 这个为 xiuno 的理想模式
		
		// 附件，用户
		$uids = $uid ? array($uid) : array();
		$i = ($page - 1) * $this->conf['pagesize'] + 1;
		$firstcom = array();
		foreach($comment as &$com) {
			$this->post->format($com);
			
			if($com['attachnum'] > 0) {
				$com['attachlist'] = $this->attach->get_list_by_fid_pid($fid, $com['pid'], 0);
			}
			$com['floor'] = $i++;
			$uids[] = $com['uid'];
			
			if($com['rates'] > 0) {
				$com['ratelist'] = $this->rate->get_list_by_fid_pid($fid, $com['pid']);
			}
			empty($firstcom) && $firstcom = $com;
			$com['message_text']=strip_tags($com['message'],'<img>');
			$com['message_text']=utf8::substr($com['message_text'],0,200);
		}
		
		$uids = array_unique($uids);
		$userlist_com = $this->user->mget($uids);
		foreach($userlist_com as &$user) {
			if(empty($user)) continue;
			$this->user->format($user);
			$this->user->format_follow($user,$this->_user['uid'],$user['uid']);//帖子页面调用是否关注参数。
			$userlist_com[$user['uid']] = $user;
		}
		$uid && !empty($userlist_com[$uid]) && $this->_user = $userlist_com[$uid];
		$this->view->assign('userlist_com', $userlist_com);
		
		// 判断权限
		foreach($comment as &$com) {
			if(isset($userlist_com[$com['uid']]) && $userlist_com[$com['uid']]['groupid'] == 7) $com['message'] = '<span class="grey">用户被禁言，帖子被屏蔽。</span>';
		}
		
		// 分页
		$pages = misc::pages("?thread-index-fid-$fid-tid-$tid.htm", $thread_com['posts'], $page, $this->conf['pagesize']);
		
		// 点击数服务器 seo notfollow
		$click_server = $this->conf['click_server']."?db=tid&w=$tid&r=$tid";
		$scrollbottom = core::gpc('scrollbottom');
		
		// 版主
		$ismod = $this->is_mod($forum, $this->_user);
		
		// userlist_com
		$referer = core::gpc('HTTP_REFERER', 'S');
		$referer_other = '';
		if(strpos($referer, 'forum-index') === FALSE) {
			$referer_other = check::is_url($referer) ? $referer : ''; // 自己玩自己？
		}
		$this->view->assign('referer_other', $referer_other);
		
		$this->view->assign('click_server', $click_server);
		$this->view->assign('scrollbottom', $scrollbottom);
		$this->view->assign('fid', $fid);
		$this->view->assign('tid', $tid);
		$this->view->assign('page', $page);
		$this->view->assign('fpage', $fpage);
		$this->view->assign('pages', $pages);
		$this->view->assign('thread_com', $thread_com);
		$this->view->assign('forum', $forum);
		$this->view->assign('comment', $comment);
		$this->view->assign('ismod', $ismod);
		// hook thread_index_after.php
		$this->view->display('comment_index_ajax.htm');
	}

	
	
}

?>