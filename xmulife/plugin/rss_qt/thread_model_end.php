	public function get_newlist_rss($start = 0, $limit = 15, $threadlist = array()) {
		$newlist = array();
		$newlist = $this->thread_new->index_fetch(array(), array('tid'=>-1), $start, $limit);
		foreach($newlist as $new) {
			$thread = $this->read($new['fid'], $new['tid']);
			$post = $this->post->read($thread['fid'],$thread['firstpid']);
			$thread['message'] = $post['message'];
			$threadlist[] = $thread;
		}
		return $threadlist;
	}
	