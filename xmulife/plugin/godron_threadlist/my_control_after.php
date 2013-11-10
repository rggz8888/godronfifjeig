	public function on_thread() {
		$this->_checked['my_thread'] = 'class="checked"';
		
		$this->_title[] = '我的主题';
		$this->_nav[] = '我的主题';
		

		
		// 翻页：上一页，下一页
		$page = misc::page();
		$uid = $this->_user['uid'];
		$user = $this->_user;
		
		$page = misc::page();
		$pagesize = 40;
		
		$mythreadlist = $this->thread->index_fetch(array('uid'=>$uid),array('tid'=>-1),($page-1)*$pagesize, $pagesize);
		$pages = misc::simple_pages("?my-thread.htm", count($mythreadlist), $page, $pagesize);
		
		
		foreach($mythreadlist as $k=>&$post) {
		$this->thread->format($post);
		}
		
		$this->view->assign('pages', $pages);
		$this->view->assign('mythreadlist', $mythreadlist);
		

		$this->view->display('my_thread.htm');
	}