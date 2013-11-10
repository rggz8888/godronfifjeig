<?php
class rename extends base_model{
	function __construct(&$conf) {
		parent::__construct($conf);
		$this->table = 'rename';
		$this->primarykey = array('rid');
    $this->maxcol = 'rid';
	}

    public function get_all_list($page = 1, $pagesize = 20) {
        return $this->get_list_by_status(false, $page, $pagesize);
    }

    public function get_list_by_status($status = false, $page = 1, $pagesize = 20) {
        $start = ($page -1) * $pagesize;
        if($status){
            $renamelist = $this->index_fetch(array('status'=>'0'), array('dateline'=>0), $start, $pagesize);
        }else{
            $renamelist = $this->index_fetch(array(), array('dateline'=>0), $start, $pagesize);
        }
        foreach($renamelist as &$rename) {
            $this->format($rename);
        }
        misc::arrlist_multisort($renamelist, 'dateline', FALSE);
        return $renamelist;
    }

    public function get_rename_by_uid($uid) {
        $renamelist = $this->index_fetch(array('uid'=>$uid), array('dateline'=>0), 0, 1);
        foreach($renamelist as &$rename) {
            $this->format($rename);
        }
        misc::arrlist_multisort($renamelist, 'dateline', FALSE);
        return $renamelist;
    }
    
    public function format(&$rename) {
        $rename['dateline_fmt'] = misc::humandate($rename['dateline']);
        switch ($rename['status'])
        {
        case 0:
          $rename['status_str'] = '<font>待审核</font>';
          break;  
        case 1:
          $rename['status_str'] = '<font color="blue">已通过</font>';
          break;
        case 2:
          $rename['status_str'] = '<font color="red">未通过</font>';
          break;
        case 3:
          $rename['status_str'] = '<font color="green">已修改</font>';
          break;
        default:
        }
    }
}
?>