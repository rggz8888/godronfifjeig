	public function on_tuwen() {
		$this->_checked['forum_tuwen'] = ' class="checked"';

		$this->_title[] = '图文帖子';

		$page = misc::page();
		$pagesize = 45;
		$start = ($page-1) * $pagesize;
        //解析帖子内图片
		
		$postlist_tw = $this->post->index_fetch(array('coverimg'=>array('<>' => '0')), array('pid'=>-1), $start, $pagesize);
		$postlist_tw = array_filter($postlist_tw);
		foreach($postlist_tw as &$post) {
			$this->post->format($post);
			$uids_tuwen[] = $post['uid'];
			if(substr($post['coverimg'],0,4)=="http") {$img_path = $post['coverimg'];}
			else 
			{$img_path = $this->conf['static_url'].$post['coverimg'];}
			$imglist_tuwen[$post['pid']] = $img_path;
			$post['message_fmt'] = utf8::substr(htmlspecialchars(strip_tags($post['message'])), 0, 50);
			$post['message_fmt'] = str_replace ( '&quot;', "'", $post['message_fmt'] );
			$post['message_fmt'] = str_replace ( '&nbsp;', '', $post['message_fmt'] );
			$post['message_fmt'] = str_replace ( '&amp;', '', $post['message_fmt'] );
			$post['message_fmt'] = str_replace ( 'nbsp;', '', $post['message_fmt'] );
			$post['message_fmt'] = str_replace ( '&', '', $post['message_fmt'] );
			$postlist_tuwen[] = $post;
		}

		$pages = misc::simple_pages("?index-tuwen.htm", count($postlist_tuwen), $page, $pagesize);

		
        //解析图片帖子作者
        $uids_tuwen = array_unique($uids_tuwen);
		$userlist_tuwen = $this->user->mget($uids_tuwen);
		foreach($userlist_tuwen as &$user) {
			$this->user->format($user);
			$userlist_tuwen[$user['uid']] = $user;
		}
        

        
		$this->view->assign('pages', $pages);
		$this->view->assign('userlist_tuwen', $userlist_tuwen);
		$this->view->assign('imglist_tuwen', $imglist_tuwen);
        $this->view->assign('postlist_tuwen', $postlist_tuwen);
		$this->view->display('plugin_tuwen.htm');
	}
