<?php



class invitationcode extends base_model{
	
	function __construct(&$conf) {
		parent::__construct($conf);
		$this->table = 'invitationcode';
		$this->primarykey = array('c_id');
	}
	public function getCodeArr($code) {
		$arr = $this->index_fetch(array('c_code'=>$code));
		return $arr?array_pop($arr):array(); //返回常规数组
	}
	public function getCodeByDate($date,$num) {
		$arr = $this->index_fetch(array('c_date'=>$date),array(),0,$num);
		return $arr;
	
	}
	public function getValidCode() {
		$num = $this->getCount(array('c_isValid'=>1));
		$arr = $this->index_fetch(array('c_isValid'=>1),array(),0,$num);
		return $arr;
	}
	public function getCount($con=array()) {
		return $this->index_count($con);
	}
	public function unValid($arr) {
		return $this->update($arr);
	}
	public function createCode($code,$date) {
		return $this->create(array('c_code'=>$code,'c_date'=>$date,'c_isValid'=>1));
	}
}






?>