public function on_jubao(){
    $this->mypost->table='thread_jubao';
	$this->mypost->primarykey = array('fid', 'pid');
    $page=misc::page();
    $start=($page-1)*20;
    $list=$this->mypost->index_fetch(array(),array('dateline'=>-1),$start,20);
    foreach($list as &$v){
       $v['dateline_fmt']=date('Y-m-d H:i',$v['dateline']);
       $v['forumname'] = isset($this->conf['forumarr'][$v['fid']]) ? $this->conf['forumarr'][$v['fid']] : '';
    }
    $pages=misc::simple_pages('?thread-jubao.htm',count($list),$page,20);
    
    $this->view->assign('pages',$pages);
    $this->view->assign('list',$list);
    $this->view->display('admin_thread_jubao.htm');
}