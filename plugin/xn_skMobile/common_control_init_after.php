<?php

		$this->qh_mobile = $this->qh_ismobile();
		if($this->qh_mobile==1) {
			$qh_mobile_islogined = $this->qh_mobile_islogin();
			$this->view->assign('mobile_islogined',$qh_mobile_islogined);
			$this->view->assign('mobile_username',$this->_user['username']);
			
			$uid1 = $this->conf['system_uid'];
			$uid2 = $this->_user['uid'];
			$pmcount = $this->pmnew->read($uid2, $uid1);

			$this->view->assign('mobile_news_num',$pmcount['count']);
		}
?>