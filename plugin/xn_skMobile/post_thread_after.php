<?php

		if($this->qh_mobile) {
			$_title = array('注册');
			$this->view->assign('_title', $_title);

			$error['subject'] = $this->thread->check_subject($thread['subject']);
			$error['message'] = $this->post->check_message($message);
			
			$qh_result_message = (empty($error['subject']))?'':$error['subject'];
			$qh_result_message = (empty($error['message']))?$qh_result_message:$error['message'];
			
			if(!array_filter($error)) {
				$error = array();

				$tid = $thread['tid'] = $this->thread->create($thread);
				if(!$thread['tid']) {
					$error_message = '发帖过程中保存数据错误，请联系管理员。';
					$this->view->assign('message',$error_message);
					$this->view->display('mobile_user_login_res.htm');
					return;
				}
				$this->thread_views->create(array('tid'=>$tid, 'views'=>0));
				$this->thread_new->create(array('fid'=>$fid, 'tid'=>$tid, 'dateline'=>$_SERVER['time'], 'lastpost'=>$_SERVER['time']));
				
				// -----------> 添加到 post
				
				$page = 1;
				$post = array (
					'fid'=>$fid,
					'tid'=>$thread['tid'],
					'uid'=>$uid,
					'dateline'=>$_SERVER['time'],
					'userip'=>ip2long($_SERVER['ip']),
					'attachnum'=>0,
					'imagenum'=>0,
					'rates'=>0,
					'page'=>$page,
					'username'=>$username,
					'subject'=>'',
					'message'=>$message,
				);
				
				$pid = $post['pid'] = $this->post->create($post);
				
				// 更新 $attach 上传文件的pid
				$attachnum = $imagenum = 0;
				list($attachnum, $imagenum) = $this->process_attach($fid, $tid, $pid, $uid);
				
				// 加入到 thread_type
				$this->thread_type_data->xcreate($fid, $tid, $typeid1, $typeid2, $typeid3, $typeid4);
				
				// 更新 $thread firstpid
				$thread['firstpid'] = $post['pid'];
				$thread['imagenum'] = $imagenum;
				$thread['attachnum'] = $attachnum;
				$this->thread->update($thread);
				
				// 更新 $post
				$post['imagenum'] = $imagenum;
				$post['attachnum'] = $attachnum;
				$this->post->update($post);
				
				// 更新 $user 用户发帖数，积分
				//$user = $this->user->read($uid);
				$user['threads']++;
				$user['posts']++;
				$user['credits'] += $this->conf['credits_policy_thread'];
				$user['golds'] += $this->conf['golds_policy_thread'];
				$groupid = $user['groupid'];
				$user['groupid'] = $this->group->get_groupid_by_credits($user['groupid'], $user['credits']);
				
				// 更新 cookie 如果用户组发生改变，更新用户的 cookie
				if($groupid != $user['groupid']) {
					$this->user->set_login_cookie($user);
				}
				
				// 加入 $mypost，可能导致隐私泄露，需要在我的帖子那里进行过滤。
				$this->mypost->create(array('uid'=>$uid, 'fid'=>$fid, 'tid'=>$tid, 'pid'=>$pid));
				$user['myposts']++;
				
				// 更新 user
				$this->user->update($user);
				
				// 更新 $forum 版块的总帖数
				$forum = $this->forum->read($fid);
				$forum['threads']++;
				$forum['posts']++;
				$forum['todayposts']++;
				$forum['lasttid'] = $tid;
				$this->forum->xupdate($forum);
				$this->runtime->xset('posts', '+1');
				$this->runtime->xset('threads', '+1');
				$this->runtime->xset('todayposts', '+1');
				
				$error['thread'] = $thread;
				$qh_result_message = '发帖成功';
			}
			$this->view->assign('message',$qh_result_message);
			$this->view->display('mobile_user_login_res.htm');
			return;
		}
?>