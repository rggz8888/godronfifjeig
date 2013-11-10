<?php
class bank_data extends base_model{
	function __construct(&$conf) {
		parent::__construct($conf);
		$this->table = 'bank_data';
		$this->primarykey = array('did');
		$this->maxcol = 'did';
	}

    public function get_list_by_all($conn, $page = 1, $pagesize = 20) {
        $start = ($page - 1) * $pagesize;
        $datalist = $this->index_fetch($conn, array('begintime'=>0), $start, $pagesize);
        foreach($datalist as &$data) {
            $this->format($data);
        }
        misc::arrlist_multisort($datalist, 'begintime', FALSE);
        return $datalist;
    }

    public function get_fixed_list_by_all($conn, $page = 1, $pagesize = 20) {
        $conn['type'] = 0;
        return $this->get_list_by_all($conn, $page, $pagesize);
    }

    public function get_fixed_list_by_uid($uid, $page = 1, $pagesize = 20) {
        return $this->get_fixed_list_by_all(array('uid'=>$uid), $page, $pagesize);
    }

    public function get_loan_list_by_all($conn, $page = 1, $pagesize = 20) {
        $conn['type'] = 1;
        return $this->get_list_by_all($conn, $page, $pagesize);
    }

    public function get_loan_list_by_uid($uid, $page = 1, $pagesize = 20) {
        return $this->get_loan_list_by_all(array('uid'=>$uid), $page, $pagesize);
    }
    
    // 用来显示给用户
    public function format(&$data) {
        $data['user'] = $this->user->read($data['uid']);
        $data['begintime_fmt'] = misc::humandate($data['begintime']);
        $data['endtime_fmt'] = misc::humandate($data['endtime']);
        $data['begintime_str'] = $data['begintime'] ? date("Y-m-d H:i", $data['begintime']) : '';
        $data['endtime_str'] = $data['endtime'] ? date("Y-m-d H:i", $data['endtime']) : '';
        $data['rate_str'] = floatval($data['rate']);
        switch ($data['type']) {
            case 0:
                $data['type_str'] = '定期';
              break;
            case 1:
                $data['type_str'] = '贷款';
              break;
            default:
                $data['type_str'] = '系统';
              break;
        }
        switch ($data['status']) {
            case 0:
                $data['status_str'] = '待审核';
                $data['status_src'] = '<a href="bank-loan-did-'.$data['did'].'-type-cancel.htm" class="cancel">取消</a>';
              break;
            case 1:
                if($_SERVER['time'] - $data['endtime'] < 0){
                    $data['status_str'] = '<strong style="color:green">已通过</strong>';
                }else{
                    $data['status_str'] = '<strong style="color:red">已超期</strong>';
                }
                $data['status_src'] = '<a href="bank-loan-did-'.$data['did'].'-type-repay.htm" class="repay">还贷</a>';
              break;
            default:
                $data['status_str'] = '错误';
              break;
        }

        if($data['type']){
            if($data['status']){
                $data['interest_str'] = $this->rates($data);
            }else{
                $data['interest_str'] = '';
            }
        }else{
            if($data['begintime_str'] != "" && $data['endtime_str'] != ""){
                if($_SERVER['time'] - $data['endtime'] >= 0){
                    $data['interest_str'] = floor($data['money'] * $data['rate'] / 100);
                }else{
                    $data['interest_str'] = '0';
                }
            }else{
                $data['interest_str'] = '';
            }
        }
    }

    public function rates($data){
        $oneday = $data['money'] * $data['rate'] / 100; //一天利息
        $day = floor(($_SERVER['time'] - $data['begintime']) / 86400);
        if($_SERVER['time'] - $data['endtime'] < 0){ //归还期内
            return $oneday * $day;
        }else{  //超期，双倍计算
            return $oneday * $day * 2;
        }

    }
}
?>