
	$last_arr = $this->thread->index_fetch_id(array('fid' => $fid, 'tid'=>array('<'=> $tid)), array('tid'=>-1), 0, 1);
	if(!empty($last_arr[0])) {
		$lastpage = '?'.str_replace('thread', 'thread-index', $last_arr[0]).'.htm';
	}else{
		$lastpage = 'javascript:alert(\'没有了\');';
	}
	$this->view->assign('lastpage', $lastpage);	//上一主题

	$next_arr = $this->thread->index_fetch_id(array('fid' => $fid, 'tid'=>array('>'=> $tid)), array('tid'=>1), 0, 1);
	if(!empty($next_arr[0])) {
		$nextpage = '?'.str_replace('thread', 'thread-index', $next_arr[0]).'.htm';
	}else{
		$nextpage = 'javascript:alert(\'没有了\');';
	}
	$this->view->assign('nextpage', $nextpage);	//下一主题