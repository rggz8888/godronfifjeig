<?php
		if($this->qh_mobile) {
			$_title = array('注册');
			$this->view->assign('_title', $_title);
			$this->view->display('mobile_user_create.htm');
			return;
		}
?>