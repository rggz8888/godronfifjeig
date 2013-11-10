	
	$quickreply = $this->_user['quickreply'];
    if($quickreply == ""){
        $quickreply = json_encode(array("支持一下~", "楼主太厉害啦，感谢分享，好人平安。", "看帖不回者，木有小JJ。", "哥顶的不是帖子，是寂寞！", "声明一下：本人看贴和回贴的规则，好贴必看，精华贴必回。"));
    }
	$qrArray = json_decode($quickreply, true);
	$this->view->assign('quickreply', $qrArray);