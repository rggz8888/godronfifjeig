
	public function on_quickreply() {
		$this->_checked['quick_reply'] = 'class="checked"';
		
		$this->_title[] = '快捷回复';
		$this->_nav[] = '快捷回复';

		if($this->form_submit()) {
			$quickreply = core::gpc('quickreply', 'P');

			$qrJson = json_encode($quickreply);

			$uid = $this->_user['uid'];
			$user = $this->user->read($uid);
			$user['quickreply'] = $qrJson;

			$this->user->update($user);
			$this->user->format($user);
			$this->_user = $user;
		}

		$quickreply = $this->_user['quickreply'];

		if($quickreply == ""){
			$quickreply = json_encode(array("XIUNO有你，更精彩！", "楼主太厉害啦，感觉分享，好人平安。", "看帖不回者，木有小JJ。", "哥顶的不是帖子，是寂寞！", "声明一下：本人看贴和回贴的规则，好贴必看，精华贴必回。"));
		}
		
		$qrArray = json_decode($quickreply, true);

		$this->view->assign('quickreply', $qrArray);

		$this->view->display('plugin_my_quick_reply.htm');
	}