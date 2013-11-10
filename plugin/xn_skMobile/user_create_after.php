<?php
		if($this->qh_mobile) {
			$_title = array('注册');
			$this->view->assign('_title', $_title);

			$error['emailsend'] = '';

			$error['emailsend'] = (!empty($error['email']))?$error['email']:$error['emailsend'];
			$error['emailsend'] = (!empty($error['email_exists']))?$error['email_exists']:$error['emailsend'];
			$error['emailsend'] = (!empty($error['username']))?$error['username']:$error['emailsend'];
			$error['emailsend'] = (!empty($error['username_exists']))?$error['username_exists']:$error['emailsend'];
			$error['emailsend'] = (!empty($error['password']))?$error['password']:$error['emailsend'];
			$error['emailsend'] = (!empty($error['password2']))?$error['password2']:$error['emailsend'];
			
			// 判断结果
			if(!array_filter($error)) {
				//$error = array();
				$uid = $this->user->xcreate($user);
				if($uid) {
					// 发送激活邮件
					if($this->conf['reg_email_on']) {
						try {
							$this->send_active_mail($uid, $username, $email, $error);	// $error['email_smtp_url']
						} catch(Exception $e) {
							$error['emailsend'] = '激活邮件发送失败！';
						}
					}
					
					// 此处由 $error 携带部分用户信息返回。
					$userdb = $this->user->read($uid);
					
					$this->user->set_login_cookie($userdb, time() + 86400 * 30);
					$this->runtime->xset('users', '+1');
					$this->runtime->xset('todayusers', '+1');
					$this->runtime->xset('newuid', $uid);
					$this->runtime->xset('newusername', $userdb['username']);
					// $this->runtime->xsave();
					$error['emailsend'] = '注册成功';
					if($this->conf['reg_email_on']) {
						$error['emailsend'] .= '，请前往注册邮箱查收验证邮件以激活用户';
					}
				}else{
					$error['emailsend'] = '注册失败,<a href="/?user-create.htm">返回注册</a>';
				}
			}

			$this->view->assign('message', $error['emailsend']);
			$this->view->display('mobile_user_login_res.htm');
			return;
		}
?>