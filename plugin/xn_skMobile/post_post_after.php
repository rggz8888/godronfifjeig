<?php
		if($this->qh_mobile) {
			$_title = array('回帖');
			$this->view->assign('_title', $_title);

			if(!array_filter($error)) {
				$error = array();
				//$error['page'] = $page;
				$error['post'] = $post;
				$error['post']['posts'] = $thread['posts'] + 1;
				
				$pid = $post['pid'] = $this->post->create($post);
				
				// 更新 $attach 上传文件的pid
				$aidarr = $this->attach->get_aid_from_tmp($uid);
				foreach($aidarr as $fid_aid) {
					$arr = explode('_', $fid_aid);
					$fid = intval($arr[0]);
					$aid = intval($arr[1]);
					$attach = $this->attach->read($fid, $aid);
					if(empty($attach)) continue;
					if($attach['uid'] != $uid) continue;
					$attach['fid'] = $post['fid'];
					$attach['pid'] = $post['pid'];
					$attach['tid'] = $post['tid'];
					if($attach['isimage'] == 1) {
						$imagenum++;
					} else {
						$attachnum++;
					}
					$this->attach->db_cache_update("attach-fid-$fid-aid-$aid", $attach);
				}
				$this->attach->clear_aid_from_tmp($uid);
				
				// 更新 $post
				$post['attachnum'] = $attachnum;
				$post['imagenum'] = $imagenum;
				$this->post->update($post);
				
				// 更新 $user 用户发帖数，积分
				$user = $this->user->read($uid);
				$user['posts']++;
				$user['credits'] += $this->conf['credits_policy_post'];
				$user['golds'] += $this->conf['golds_policy_post'];
				$groupid = $user['groupid'];
				$user['groupid'] = $this->group->get_groupid_by_credits($user['groupid'], $user['credits']);
				
				// 更新 cookie 如果用户组发生改变，更新用户的 cookie
				if($groupid != $user['groupid']) {
					$this->user->set_login_cookie($user);
				}
				
				// 加入 $mypost
				if(!$this->mypost->have_tid($uid, $fid, $tid)) {
					$this->mypost->create(array('uid'=>$uid, 'fid'=>$fid, 'tid'=>$tid, 'pid'=>$pid));
					$user['myposts']++;
				}
				
				// 更新 $user 
				$this->user->update($user);
					
				// 更新 $forum 版块的总帖数
				$forum = $this->forum->read($fid);
				$forum['posts']++;
				$forum['todayposts']++;
				$forum['lasttid'] = $thread['tid'];
				$this->forum->xupdate($forum);
				
				// 今日总的发帖数
				$this->runtime->xset('posts', '+1');
				$this->runtime->xset('todayposts', '+1');
				
				// 更新 $thread
				$thread['posts']++;
				$thread['lastuid'] = $uid;
				$thread['lastpost'] = $_SERVER['time'];
				$thread['lastusername'] = $username;
				$this->thread->update($thread);
				// 引用或者斑竹回复，短信通知楼主
				if($quote && $quote['uid'] != $this->_user['uid']) {
					$pmsubject = utf8::substr(htmlspecialchars(strip_tags($quote['message'])), 0, 16);
					$pmmessage = "【{$this->_user['username']}】引用了您的帖子：<a href=\"?thread-index-fid-$fid-tid-$tid-page-$page.htm\" target=\"_blank\">【{$pmsubject}】</a>。";
					$this->pm->system_send($quote['uid'], $quote['username'], $pmmessage);
				} elseif($this->_user['groupid'] <= 5 && $this->_user['uid'] != $thread['uid']) {
					$pmsubject = utf8::substr($thread['subject'], 0, 16);
					$pmmessage = "【{$this->_user['username']}】回复了您的主题：<a href=\"?thread-index-fid-$fid-tid-$tid.htm\" target=\"_blank\">【{$pmsubject}】</a>。";
					$this->pm->system_send($thread['uid'], $thread['username'], $pmmessage);
				}
				$error['message'] = '回帖成功，<a href="?thread-index-fid-'.$fid.'-tid-'.$tid.'.htm">返回帖子</a>';
			}
			
			
			$this->view->assign('message', $error['message']);
			$this->view->display('mobile_user_login_res.htm');
			return;
		}
?>