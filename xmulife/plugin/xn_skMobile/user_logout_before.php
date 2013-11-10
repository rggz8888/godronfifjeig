<?php
		if($this->qh_mobile) {
			$_title = array('退出');
			$this->view->assign('_title', $_title);
			$this->view->display('mobile_user_logout.htm');
			return;
		}
?>