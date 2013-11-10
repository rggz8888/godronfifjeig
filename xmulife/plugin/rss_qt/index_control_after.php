	public function on_rss() {
		$threadlist = $this->thread->get_newlist_rss();
		foreach($threadlist as $k=>&$thread) {
			$thread['lastpost_rss'] = date(DATE_RSS,$thread['lastpost']);
			// 去掉没有权限访问的版块数据
			$fid = $thread['fid'];
			if(!isset($this->conf['forumarr'][$fid])) {
				unset($threadlist[$k]);
				continue;
			}
		}
		$lastbuilddate = date(DATE_RSS);
		$pubdate = date(DATE_RSS);
		$this->view->assign('lastbuilddate',$lastbuilddate);
		$this->view->assign('pubdate',$pubdate);
		$this->view->assign('threadlist', $threadlist);
		$this->view->display('rss.htm');
	}
