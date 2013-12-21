		$this->_checked['index'] = ' class="checked"';		
		$pagesize = 30;
		$start = 0;
		$threadlist = array();
		$groupid = $this->_user['groupid'];
		$threadlist = $this->runtime->get('index_threadlist');
		if(empty($threadlist)) {
			$threadlist = $this->thread->get_newlist($start, $pagesize);
			$unset1 = 0;
			foreach($threadlist as $k=>&$thread) {
				$this->thread->format($thread);
				
				// 去掉没有权限访问的版块数据
				
				$fid = $thread['fid'];
				if(!isset($this->conf['forumarr'][$fid])) {
					unset($threadlist[$k]);
					$unset1++;
					continue;
				}
				
				$thread['subject_fmt'] = $this->cutstr_cn($thread['subject'], 29);
				$thread['username_fmt'] = $this->cutstr_cn($thread['username'], 10);

			}

			//查询用户个人信息
				
			$uids = misc::arrlist_key_values($threadlist, '', 'uid');
		    $uids = array_unique($uids);
		    $userlist_lq = $this->user->mget($uids);
		    foreach($userlist_lq as &$user) {
			   $this->user->format($user);
			   $userlist_lq[$user['uid']] = $user;
		    }
				
			
			if($unset1 > 0) {
				$threadlist += (array)$this->thread->get_newlist_lastpost($start + $pagesize, $pagesize * 2);
				foreach($threadlist as $k=>&$thread) {
					$this->thread->format($thread);
					// 去掉没有权限访问的版块数据
					
					$fid = $thread['fid'];
					if(!isset($this->conf['forumarr'][$fid])) {
						unset($threadlist[$k]);
						$unset1++;
						continue;
					}
					
					$thread['subject_fmt'] = $this->cutstr_cn($thread['subject'], 29);
					$thread['username_fmt'] = $this->cutstr_cn($thread['username'], 10);

				}
				$threadlist = array_slice($threadlist, 0, $pagesize);

				//查询用户个人信息
				
			    $uids = misc::arrlist_key_values($threadlist, '', 'uid');
		        $uids = array_unique($uids);
		        $userlist_lq = $this->user->mget($uids);
		        foreach($userlist_lq as &$user) {
			       $this->user->format($user);
			       $userlist_lq[$user['uid']] = $user;
		        }
			}
			$this->runtime->set('index_threadlist', $threadlist,60);
		} else {

		    //查询用户个人信息
				
			$uids = misc::arrlist_key_values($threadlist, '', 'uid');
		    $uids = array_unique($uids);
		    $userlist_lq = $this->user->mget($uids);
		    foreach($userlist_lq as &$user) {
			   $this->user->format($user);
			   $userlist_lq[$user['uid']] = $user;
		    }
		}
		
		// 在线会员
		$ismod = ($this->_user['groupid'] > 0 && $this->_user['groupid'] <= 4);
		
		
		$this->view->assign('threadlist', $threadlist);
		$this->view->assign('userlist_lq', $userlist_lq);
		$this->view->assign('pages', $pages);
		
		// hook index_bbs_after.php
		$dipagesize = 12;
		$digestlist = array();
		$digestlist = $this->runtime->get('index_digestlist');
		if(empty($digestlist)) {
			$unset2 = 0;
			$digestlist = $this->thread_digest->get_newlist($start, $dipagesize);
			foreach($digestlist as $k=>&$thread) {
				$this->thread->format($thread);
				
				// 去掉没有权限访问的版块数据
				
				$fid = $thread['fid'];
				if(!isset($this->conf['forumarr'][$fid])) {
					unset($digestlist[$k]);
					$unset2++;
					continue;
				}
				
				$thread['subject_fmt'] = $this->cutstr_cn($thread['subject'], 29);
				$thread['username_fmt'] = $this->cutstr_cn($thread['username'], 10);
			    
			}

			//查询用户个人信息
				
			$diuids = misc::arrlist_key_values($digestlist, '', 'uid');
			$diuids = array_unique($diuids);
		    $diuserlist_lq = $this->user->mget($diuids);
		    foreach($diuserlist_lq as &$user) {
			   $this->user->format($user);
			   $diuserlist_lq[$user['uid']] = $user;
		    }
			
			if($unset2 > 0) {
				$digestlist += (array)$this->thread_digest->get_newlist($start + $dipagesize, $dipagesize * 2);
				foreach($digestlist as $k=>&$thread) {
					$this->thread->format($thread);
					// 去掉没有权限访问的版块数据
					
					$fid = $thread['fid'];
					if(!isset($this->conf['forumarr'][$fid])) {
						unset($digestlist[$k]);
						$unset2++;
						continue;
					}
					
					$thread['subject_fmt'] = $this->cutstr_cn($thread['subject'], 29);
					$thread['username_fmt'] = $this->cutstr_cn($thread['username'], 10);
				}
				$digestlist = array_slice($digestlist, 0, $dipagesize);

				//查询用户个人信息
				
			    $diuids = misc::arrlist_key_values($digestlist, '', 'uid');
			    $diuids = array_unique($diuids);
		        $diuserlist_lq = $this->user->mget($diuids);
		        foreach($diuserlist_lq as &$user) {
			       $this->user->format($user);
			       $diuserlist_lq[$user['uid']] = $user;
		        }

			}
			$this->runtime->set('index_digestlist', $digestlist, 60);
		} else {
		   //查询用户个人信息
				
		    $diuids = misc::arrlist_key_values($digestlist, '', 'uid');
		    $diuids = array_unique($diuids);
		    $diuserlist_lq = $this->user->mget($diuids);
		    foreach($diuserlist_lq as &$user) {
			   $this->user->format($user);
			   $diuserlist_lq[$user['uid']] = $user;
		    }
		}
		
		
		$fid = 0;
		$this->view->assign('ismod', $ismod);
		$this->view->assign('fid', $fid);
		$this->view->assign('digestlist', $digestlist);
		$this->view->assign('diuserlist_lq', $diuserlist_lq);
		//$this->view->display('plugin_index_two_column.htm');

        //查询最新注册用户
		 $cond = array();
		 $k = 0;
		 $userlist = $this->user->get_list_lastactive(0,12);
		 foreach($userlist as &$user) {
		     $k++;
			 $this->user->format($user);
			 $user['username_fmt'] = utf8::substr($user['username'], 0, 6);
			 if($k<7)$userlist1[] = $user; else $userlist2[] = $user;
			
		 }

		//解析帖子内图片
		$postlist = $this->post->index_fetch(array('coverimg'=>array('>' => '0')), array('pid'=>-1), 0, 18);
		$postlist = array_filter($postlist);
		$k = 0;
		foreach($postlist as &$post){
		    $k++;
			$this->post->format($post);
			if(substr($post['coverimg'],0,4)=="http") {$img_path = $post['coverimg'];}
			else 
			{$img_path = $this->conf['static_url'].$post['coverimg'];}
			$imglist[$post['pid']] = $img_path;
			$post['message_fmt'] = utf8::substr(htmlspecialchars(strip_tags($post['message'])), 0, 50);
			$post['message_fmt'] = str_replace ( '&quot;', "'", $post['message_fmt'] );
			$post['message_fmt'] = str_replace ( '&nbsp;', '', $post['message_fmt'] );
			$post['message_fmt'] = str_replace ( '&amp;', '', $post['message_fmt'] );
			$post['message_fmt'] = str_replace ( 'nbsp;', '', $post['message_fmt'] );
			$post['message_fmt'] = str_replace ( '&', '', $post['message_fmt'] );
			if($k<7) $postlist1[] = $post;
			elseif($k<13) $postlist2[] = $post;
			else $postlist3[] = $post;
		}
		
		$this->view->assign('imglist', $imglist);
		$this->view->assign('postlist1', $postlist1);
		$this->view->assign('postlist2', $postlist2);
		$this->view->assign('postlist3', $postlist3);
		$this->view->assign('userlist1', $userlist1);
		$this->view->assign('userlist2', $userlist2);
		$this->view->display('plugin_index_two_column.htm');
		exit;		