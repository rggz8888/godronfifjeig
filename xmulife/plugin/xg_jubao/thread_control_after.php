public function on_jubao(){
      $fid = intval(core::gpc('fid'));
      $pid = intval(core::gpc('pid'));
      $floor = intval(core::gpc('floor'));
      $uid = $this->_user['uid'];
      
      
      // 权限检测
      $forum = $this->mcache->read('forum', $fid);
	  $this->check_forum_exists($forum);
      
      $post = $this->post->read($fid, $pid);
      $this->check_post_exists($post);
      
      $thread = $this->thread->read($fid, $post['tid']);
      $this->check_thread_exists($thread);
      
      $tid = $thread['tid'];
        
      if($this->form_submit()){
            $message=core::gpc('message','P');
            $this->check_message($message);
            $this->mypost->table='thread_jubao';
	        $this->mypost->primarykey = array('fid', 'pid');
            if($rs=$this->mypost->read($fid,$pid)) $this->message('您已经举报过该贴');
            $arr=array('fid'=>$fid,'pid'=>$pid,'subject'=>$thread['subject'].'('.$floor.'楼)','message'=>$message,'url'=>"?thread-index-fid-$fid-tid-$thread[tid]-page-$post[page]."."htm",'dateline'=>$_SERVER['time']);
            $this->mypost->create($arr);
            $this->message('举报成功');
      }
      
      $this->view->assign('pid',$pid);
      $this->view->assign('fid',$fid);
      $this->view->assign('floor',$floor);
      $this->view->assign('thread',$thread);
      $this->view->display('thread_jubao_ajax.htm');
}
private function check_message(&$message) {
		core::htmlspecialchars($message);
		if(utf8::strlen($message) > 64) {
			$this->message('留言不能超过64个字符！', 0);
		}
	}