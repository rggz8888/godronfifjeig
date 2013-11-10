public function on_thread() {
		$this->_checked['you_thread'] = 'class="checked"';
		
		$user = $this->you;
		//$uid = core::gpc('uid');
		$uid = $user['uid'];
		$this->_title[] = 'Ta的主题';
		$this->_nav[] = 'Ta的主题';
				
		$page = misc::page();
		$pagesize = 40;
		$youthreadlist = $this->thread->index_fetch(array('uid'=>$uid),array('tid'=>-1),($page-1)*$pagesize, $pagesize);
		$pages = misc::simple_pages("?you-thread-uid-$uid.htm", count($youthreadlist), $page, $pagesize);
		
		
		foreach($youthreadlist as $k=>&$post) {
			
			// 权限判断
			$fid = $post['fid'];
			if(!empty($this->conf['forumaccesson'][$fid])) {
				$access = $this->forum_access->read($fid, $this->_user['groupid']);
				if(empty($access['allowread'])) {
					$post = array();
					continue;
				}
			}
						
			$this->thread->format($post);
		}
		
		$this->view->assign('pages', $pages);
		$this->view->assign('youthreadlist', $youthreadlist);
		
		$this->view->display('you_thread.htm');
	}