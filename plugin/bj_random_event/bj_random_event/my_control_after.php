<?php
	public function on_event() {
		$this->_checked['my_wealth'] = 'class="checked"';
		$this->_checked['event'] = 'class="checked"';
		
		$this->_title[] = '事件记录';
		$this->_nav[] = '事件记录';
		
		$_user = $this->_user;
		$uid = $_user['uid'];
		
		// 简单分页
		$page = misc::page();
		$pagesize = 20;
		$eventlist = $this->event->get_list_by_uid($uid, $page, $pagesize);
		$pages = misc::simple_pages("?my-event.htm", count($eventlist), $page, $pagesize);

		$this->view->assign('pages', $pages);
		$this->view->assign('eventlist', $eventlist);

		$this->view->display('plugin_my_event.htm');
	}
?>