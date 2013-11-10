<?php
		if($this->qh_mobile) {
			$_title = array('登录');
			$this->view->assign('_title', $_title);
			if(!$this->form_submit()) {
				$this->view->display('mobile_user_login.htm');
			} else {
				$userdb = $error = array();
				$email = core::gpc('email', 'P');
				$password = core::gpc('password', 'P');
				$clienttime = core::gpc('clienttime', 'P');
			
				if(empty($email)) {
					$error['email'] = '请填写用户名或Email.<a href="/?user-login.htm">返回</a>';
					$this->view->assign('message', $error['email']);
					$this->view->display('mobile_user_login_res.htm');
					return;
				}
			
				$userdb = $this->user->get_user_by_email($email);
				if(empty($userdb)) {
					$userdb = $this->user->get_user_by_username($email);
					if(empty($userdb)) {
						$error['email'] = '用户名/Email 不存在.<a href="/?user-login.htm">返回</a>';
						log::write('EMAIL不存在:'.$email, 'login.php');
						$this->view->assign('message', $error['email']);
						$this->view->display('mobile_user_login_res.htm'); 
						return;
					}
				}
				$uid = $userdb['uid'];
			
				if(!$this->user->verify_password($password, $userdb['password'], $userdb['salt'])) {
					$error['password'] = '密码错误!<a href="/?user-login.htm">返回</a>';
					$log_password = '******'.substr($password, 6);
					log::write("密码错误：$email - $log_password", 'login.php');
					$this->view->assign('message', $error['password']);
					$this->view->display('mobile_user_login_res.htm');
					return;
				}
				
				if(!array_filter($error)) {
					$error = array();
					$error['user']['username'] =  $userdb['username'];
					$error['user']['auth'] =  $this->user->get_xn_auth($userdb);
					$error['user']['groupid'] =  $userdb['groupid'];

					$this->user->set_login_cookie($userdb, time() + 86400 * 30);
				
					$this->update_online();
				}
				$message_result = '登录成功.<a href="/">回首页</a>';
				$this->view->assign('message', $message_result);
				$this->view->display('mobile_user_login_res.htm'); 
			}
			return;
		}
?>