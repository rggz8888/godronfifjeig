	// 按照 lastactive 倒序，获取最新顶贴的列表
	public function get_list_lastactive($start = 0, $limit = 12) {
		$arrlist = $this->index_fetch(array('uid'=>array('<>' => '2')), array('lastactive'=>-1), $start, $limit);
		return $arrlist;
	}
	