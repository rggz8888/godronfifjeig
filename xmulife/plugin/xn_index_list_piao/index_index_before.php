
		$this->_checked['index'] = ' class="checked"';
				
		$pagesize = 20;
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
				$thread['subject_fmt'] = utf8::substr($thread['subject'], 0, 32);
			}
			
			if($unset1 > 0) {
				$threadlist += (array)$this->thread->get_newlist($start + $pagesize, $pagesize * 2);
				foreach($threadlist as $k=>&$thread) {
					$this->thread->format($thread);
					// 去掉没有权限访问的版块数据
					$fid = $thread['fid'];
					if(!isset($this->conf['forumarr'][$fid])) {
						unset($threadlist[$k]);
						$unset1++;
						continue;
					}
					$thread['subject_fmt'] = utf8::substr($thread['subject'], 0, 32);
				}
				$threadlist = array_slice($threadlist, 0, $pagesize);
			}
			$this->runtime->set('index_threadlist', $threadlist, 60);
		}
		
		// 在线会员
		$ismod = ($this->_user['groupid'] > 0 && $this->_user['groupid'] <= 4);
		$fid = 0;
		$this->view->assign('ismod', $ismod);
		$this->view->assign('fid', $fid);
		$this->view->assign('threadlist', $threadlist);
		$this->view->assign('pages', $pages);
		
		// hook index_bbs_after.php
		
		$digestlist = array();
		$digestlist = $this->runtime->get('index_digestlist');
		if(empty($digestlist)) {
			$unset2 = 0;
			$digestlist = $this->thread_digest->get_newlist($start, $pagesize);
			foreach($digestlist as $k=>&$thread) {
				$this->thread->format($thread);
				
				// 去掉没有权限访问的版块数据
				$fid = $thread['fid'];
				if(!isset($this->conf['forumarr'][$fid])) {
					unset($digestlist[$k]);
					$unset2++;
					continue;
				}
				$thread['subject_fmt'] = utf8::substr($thread['subject'], 0, 32);
			}
			
			if($unset2 > 0) {
				$digestlist += (array)$this->thread_digest->get_newlist($start + $pagesize, $pagesize * 2);
				foreach($digestlist as $k=>&$thread) {
					$this->thread->format($thread);
					// 去掉没有权限访问的版块数据
					$fid = $thread['fid'];
					if(!isset($this->conf['forumarr'][$fid])) {
						unset($digestlist[$k]);
						$unset2++;
						continue;
					}
					$thread['subject_fmt'] = utf8::substr($thread['subject'], 0, 32);
				}
				$digestlist = array_slice($digestlist, 0, $pagesize);
			}
			$this->runtime->set('index_digestlist', $digestlist, 60);
		}
		
		
		$this->_checked['forum_list'] = ' class="checked"';
		
		$forumarr = $this->conf['forumarr'];
		$threadlists = $this->runtime->get('threadlists');
		if(empty($threadlists)) {
			foreach($forumarr as $fid=>$name) {
				if(!empty($forumarr[$fid])) {
					$access = $this->forum_access->read($fid, $this->_user['groupid']);
					if(!empty($access) && !$access['allowread']) {
						unset($forumarr[$fid]);
						continue;
					}
				}
				$threadlist = $this->thread->get_threadlist_by_fid($fid, 0, 0, 10, 0);
				foreach($threadlist as &$thread) {
					$thread['dateline_fmt'] = misc::minidate($thread['dateline']);
					$thread['subject_fmt'] = utf8::substr($thread['subject'], 0, 24);
				}
				$threadlists[$fid] = $threadlist;
			}
			$this->runtime->set('threadlists', $threadlists, 60); // todo:一分钟的缓存时间！这里可以根据负载进行调节。
		}
		$this->view->assign('forumarr', $forumarr);
		$this->view->assign('threadlists', $threadlists);
		$this->view->assign('digestlist', $digestlist);
		$this->view->display('plugin_index_two_column.htm');
		exit;
		
		