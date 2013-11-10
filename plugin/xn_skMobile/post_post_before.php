<?php
		if($this->qh_mobile) {
			$_title = array('回帖');
			$this->view->assign('_title', $_title);
			$this->view->display('mobile_post_post.htm');
			return;
		}
?>