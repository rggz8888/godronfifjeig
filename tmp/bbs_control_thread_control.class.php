<?php

/*
 * Copyright (C) xiuno.com
 */

!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');
	include 'D:/Program Files (x86)/phpnow/htdocs/tmp/control_common_control.class.php';

class thread_control extends common_control {
	
	function __construct(&$conf) {
		parent::__construct($conf);
		$this->_checked['bbs'] = ' class="checked"';
	}
	
	// 列表
	public function on_index() {
		

		$custom_url = core::gpc('custom_url');
		if($custom_url) {
			if(!preg_match('#^[\w\-]+$#', $custom_url)) {
				$this->message('您请求的 URL 传递的参数不合法，自定义 URL 中只能包含英文、数字、下划线、横线。');
			}
			$arrlist = $this->thread->index_fetch(array('custom_url'=>$custom_url), array(), 0, 1);
			if(empty($arrlist)) {
				$this->message('您请求的 URL 不存在。');
			}
			$thread = array_pop($arrlist);
			$_GET['fid'] = $thread['fid'];
			$_GET['tid'] = $thread['tid'];
		}
		
		
		$fid = intval(core::gpc('fid'));
		$tid = intval(core::gpc('tid'));
		$uid = $this->_user['uid'];
		$page = misc::page();
		$thread = $this->thread->read($fid, $tid);
		$this->check_thread_exists($thread);
		$fpage = intval(core::gpc($this->conf['cookie_pre'].'page', 'C'));
		
		// 版块权限检查
		$forum = $this->mcache->read('forum', $fid);
		$this->check_forum_exists($forum);
		$this->check_access($forum, 'read');
		
		$this->thread->format($thread, $forum);
		
		// SEO 优化
		$this->_title[] = $thread['subject'];
		$this->_title[] = $forum['name'];
		foreach($forum['types'] as $cateid=>$types) {
			if($cateid == 1 && $thread['typeid1']) $this->_title[] = $thread['typename1'];
			if($cateid == 2 && $thread['typeid2']) $this->_title[] = $thread['typename2'];
			if($cateid == 3 && $thread['typeid3']) $this->_title[] = $thread['typename3'];
			if($cateid == 4 && $thread['typeid4']) $this->_title[] = $thread['typename4'];
		}
		

		
		// 只缓存了 第一页20个pid，超出则查询 db
		$totalpage = ceil($thread['posts'] / $this->conf['pagesize']);
		$page > $totalpage && $page = $totalpage;
		$postlist = $this->post->index_fetch(array('fid'=>$fid, 'tid'=>$tid, 'page'=>$page), array(), 0, $this->conf['pagesize']);
		
		$postlist = array_filter($postlist);
		
		// php order by pid，一般情况下不用排序，但是偶尔数据库返回的数据为乱序。这里排序有问题！
		//ksort($postlist);	// key 为字符串，排序不稳定。 fid-2-pid-999 fid-2-pid-1000 这种情况
		misc::arrlist_multisort($postlist, 'dateline', TRUE); 	// 这里为兼顾 dx, pw 等升级过来的数据，他们的pid不是递增的，是 mysql_insert_id() 产生的。
		//misc::arrlist_multisort($postlist, 'pid', TRUE);	// 这个为 xiuno 的理想模式
		
		// 附件，用户
		$uids = $uid ? array($uid) : array();
		$i = ($page - 1) * $this->conf['pagesize'] + 1;
		$firstpost = array();
		foreach($postlist as &$post) {
			$this->post->format($post);
			if($post['attachnum'] > 0) {
				$post['attachlist'] = $this->attach->get_list_by_fid_pid($fid, $post['pid'], 0);
			}
			$post['floor'] = $i++;
			$uids[] = $post['uid'];
			
			if($post['rates'] > 0) {
				$post['ratelist'] = $this->rate->get_list_by_fid_pid($fid, $post['pid']);
			}
			empty($firstpost) && $firstpost = $post;
		}
		
		// 此处浪费一点点性能，为了迎合搜索引擎，现代搜索引擎应该无视这两个标签的。
		$this->_seo_keywords = htmlspecialchars($thread['subject']);
		$this->_seo_description = htmlspecialchars(utf8::substr(strip_tags($firstpost['message']), 0, 64));
		
		$uids = array_unique($uids);
		$userlist = $this->user->mget($uids);
		foreach($userlist as &$user) {
			if(empty($user)) continue;
			$this->user->format($user);
			$userlist[$user['uid']] = $user;
		}
		$uid && !empty($userlist[$uid]) && $this->_user = $userlist[$uid];
		$this->view->assign('userlist', $userlist);
		
		// 判断权限
		foreach($postlist as &$post) {
			if(isset($userlist[$post['uid']]) && $userlist[$post['uid']]['groupid'] == 7) $post['message'] = '<span class="grey">用户被禁言，帖子被屏蔽。</span>';
		}
		
		// 版主管理日志，包含评分列表
		if($thread['modnum'] > 0) {
			$modlist = $this->modlog->get_list_by_fid_tid($fid, $tid);
			foreach($modlist as &$modlog) {
				$this->modlog->format($modlog);
				$modlog['user'] = $this->user->read($modlog['uid']);
				$this->user->format($modlog['user']);	
			}
			$this->view->assign('modlist', $modlist);
		}
		
		// 分页
		$pages = misc::pages("http://127.0.0.1/xmulife/thread-index-fid-$fid-tid-$tid.htm", $thread['posts'], $page, $this->conf['pagesize']);
		
		// 点击数服务器 seo notfollow
		$click_server = $this->conf['click_server']."?db=tid&w=$tid&r=$tid";
		$scrollbottom = core::gpc('scrollbottom');
		
		// 版主
		$ismod = $this->is_mod($forum, $this->_user);
		
		// userlist
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
		$this->view->assign('thread', $thread);
		$this->view->assign('forum', $forum);
		$this->view->assign('postlist', $postlist);
		$this->view->assign('ismod', $ismod);

		if($this->qh_mobile) {
			$this->view->display('mobile_thread_index.htm');
			return;
		}

		$this->view->display('thread_index.htm');
	}
	
public function on_jubao(){
      $fid = intval(core::gpc('fid'));
      $pid = intval(core::gpc('pid'));
      $floor = intval(core::gpc('floor'));
      $uid = $this->_user['uid'];
      
      
      // 权限检测
      $forum = $this->mcache->read('forum', $fid);
	  $this->check_forum_exists($forum);
      
      $post = $this->post->read($fid, $pid);
      $this->check_post_exists($post);
      
      $thread = $this->thread->read($fid, $post['tid']);
      $this->check_thread_exists($thread);
      
      $tid = $thread['tid'];
        
      if($this->form_submit()){
            $message=core::gpc('message','P');
            $this->check_message($message);
            $this->mypost->table='thread_jubao';
	        $this->mypost->primarykey = array('fid', 'pid');
            if($rs=$this->mypost->read($fid,$pid)) $this->message('您已经举报过该贴');
            $arr=array('fid'=>$fid,'pid'=>$pid,'subject'=>$thread['subject'].'('.$floor.'楼)','message'=>$message,'url'=>"?thread-index-fid-$fid-tid-$thread[tid]-page-$post[page]."."htm",'dateline'=>$_SERVER['time']);
            $this->mypost->create($arr);
            $this->message('举报成功');
      }
      
      $this->view->assign('pid',$pid);
      $this->view->assign('fid',$fid);
      $this->view->assign('floor',$floor);
      $this->view->assign('thread',$thread);
      $this->view->display('thread_jubao_ajax.htm');
}
private function check_message(&$message) {
		core::htmlspecialchars($message);
		if(utf8::strlen($message) > 64) {
			$this->message('留言不能超过64个字符！', 0);
		}
	}
}

?>