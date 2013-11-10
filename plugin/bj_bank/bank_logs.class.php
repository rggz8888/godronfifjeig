<?php
class bank_logs extends base_model{
	function __construct(&$conf) {
		parent::__construct($conf);
		$this->table = 'bank_logs';
		$this->primarykey = array('lid');
		$this->maxcol = 'lid';
	}

    public function get_list_by_all($conn, $page = 1, $pagesize = 20) {
        $start = ($page - 1) * $pagesize;
        $logslist = $this->index_fetch($conn, array('dateline'=>0), $start, $pagesize);
        foreach($logslist as &$logs) {
            $this->format($logs);
        }
        misc::arrlist_multisort($logslist, 'dateline', FALSE);
        return $logslist;
    }

    public function get_list_by_uid($uid, $page = 1, $pagesize = 20) {
        return $this->get_list_by_all(array('uid'=>$uid), $page, $pagesize);
    }
    
    // 用来显示给用户
    public function format(&$logs) {
        $logs['user'] = $this->user->read($logs['uid']);
        $logs['dateline_fmt'] = misc::humandate($logs['dateline']);
        switch ($logs['type']) {
            case 1:
                $logs['type_str'] = '开户';
              break;
            case 2:
                $logs['type_str'] = '活期';
              break;
            case 3:
                $logs['type_str'] = '定期';
              break;
            case 4:
                $logs['type_str'] = '转账';
              break;
            case 5:
                $logs['type_str'] = '贷款';
              break;
            default:
                $logs['type_str'] = '系统';
              break;
        }
    }
}
?>