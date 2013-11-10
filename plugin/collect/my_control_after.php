public function on_addcollect(){
	$uid = $this->_user['uid'];
	$tid=intval(core::gpc('tid','G'));
	$fid=intval(core::gpc('fid','G'));
	
	$this->mypost->table='mycollect';
	$this->mypost->primarykey = array('uid', 'fid', 'tid');
	
	$rs=$this->mypost->read_by_tid($uid, $fid, $tid);
	if($rs){
		$this->message('该贴已收藏',0);
	}else{
		$id=$this->mypost->create(array('uid'=>$uid,'fid'=>$fid,'tid'=>$tid));
		if($id){
			$this->message('已收藏');
		}else{
			$this->message('收藏失败',0);
		}
	}

}
public function on_collect(){
    $this->_checked['my_collect'] = 'class="checked"';
		
    $this->_title[] = '我的收藏';
    $this->_nav[] = '我的收藏';
    
    // hook my_post_before.php
    
    // 翻页：上一页，下一页
    $page = misc::page();
    $uid = $this->_user['uid'];
    $user = $this->_user;
    
    $page = misc::page();
    $pagesize = 40;

    $this->mypost->table='mycollect';
	$this->mypost->primarykey = array('uid', 'fid', 'tid');
    $mycollectlist = $this->mypost->index_fetch(array('uid'=>$uid), array('id'=>-1), ($page - 1) * $pagesize, $pagesize);
    
    $pages = misc::simple_pages("?my-post.htm", count($mycollectlist), $page, $pagesize);
		
    foreach($mycollectlist as &$post) {
        $post=$this->thread->read($post['fid'],$post['tid']);
        $post['forumname'] = isset($this->conf['forumarr'][$post['fid']]) ? $this->conf['forumarr'][$post['fid']] : '';
        $this->thread->format($post);
    }
    
    $this->view->assign('pages', $pages);
    $this->view->assign('mycollectlist', $mycollectlist);
    
    $this->view->display('my_collect.htm');
}
public function on_delcollect(){
    $uid = $this->_user['uid'];
	$tid=intval(core::gpc('tid','G'));
	$fid=intval(core::gpc('fid','G'));
	
	$this->mypost->table='mycollect';
	$this->mypost->primarykey = array('uid', 'fid', 'tid');
	
	$this->mypost->delete($uid, $fid, $tid);
    $this->location('?my-collect.htm');
}