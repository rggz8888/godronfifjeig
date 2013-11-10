<?php
		if($this->qh_mobile) {
			$_title = array('消息');
			$this->view->assign('_title', $_title);

			
			$pmcount = $this->pmcount->read($uid1, $uid2);
			$count = $pmcount['count'];
			$pagesize = 20;
			$totalpage = max(1, ceil($count / $pagesize));
			$page = intval(core::gpc('page'));
			$page = ($page <1)?1:$page;
			$pages = misc::pages("?pm-ajaxlist-uid-$uid1.htm", $count, $page, $pagesize);
		
			$uid1a = min($uid1,$uid2);
			$uid2b = max($uid1,$uid2);
			$pmlist = $this->pm->index_fetch(array('uid1'=>$uid1a, 'uid2'=>$uid2b, 'page'=>$page), array('pmid'=>'-1'), 0, 100);
			foreach($pmlist as &$pm) {
				if(!empty($pm)) $this->pm->format($pm);
			}

			$this->pm->markread($this->conf['system_uid'],$this->_user['uid']);

			$this->view->assign('touser', $touser);
			$this->view->assign('page', $page);
			$this->view->assign('totalpage', $totalpage);
			$this->view->assign('pages', $pages);
			$this->view->assign('pmlist', $pmlist);
			$this->view->display('mobile_pm_list.htm');
			return;
		}
?>