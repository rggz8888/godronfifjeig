<?php
		if($this->qh_mobile) {
			$_title = array('退出');
			$this->view->assign('_title', $_title);
			misc::setcookie($this->conf['cookie_pre'].'auth', '', 0, $this->conf['cookie_path'], $this->conf['cookie_domain']);
			
			$message_logout = '成功退出登录';
			$this->view->assign('message', $message_logout);
			$this->view->display('mobile_user_login_res.htm');
			return;
		}
?>