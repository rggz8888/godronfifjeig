<?php
		if($this->qh_mobile) {
			$_title = array('激活用户');
			$this->view->assign('_title', $_title);
			
			$this->user->set_login_cookie($user);
			$message_active = $user['username'].'，您好！您的账号激活成功！';
		
			$this->view->assign('message', $message_active);
			$this->view->display('mobile_user_login_res.htm');
			return;
		}
?>