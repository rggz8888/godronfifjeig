<?php
class event extends base_model{
	function __construct(&$conf) {
		parent::__construct($conf);
		$this->table = 'event';
		$this->primarykey = array('eid');
		$this->maxcol = 'eid';
	}

    public function get_list_by_uid($uid, $page = 1, $pagesize = 20) {
        $start = ($page -1) * $pagesize;
        $eventlist = $this->index_fetch(array('uid'=>$uid), array('dateline'=>0), $start, $pagesize);
        foreach($eventlist as &$event) {
            $this->format($event);
        }
        misc::arrlist_multisort($eventlist, 'dateline', FALSE);
        return $eventlist;
    }
    
    // 用来显示给用户
    public function format(&$event) {
        $event['attach'] = $this->thread->read($event['pid']);
        $event['user'] = $this->user->read($event['uid']);
        $event['dateline_fmt'] = misc::humandate($event['dateline']);
        $event['type'] = $event['type'] ? '获得' : '失去';
    }
}
?>