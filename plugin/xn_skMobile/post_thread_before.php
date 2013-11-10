<?php
		if($this->qh_mobile) {
			$qh_title = array('高级发帖');
			$this->view->assign('_title', $qh_title);
			
			$this->view->display('mobile_post_thread.htm');
			
			return;
		}
?>