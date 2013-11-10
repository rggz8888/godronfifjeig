
		if(empty($_SERVER['_baiduBCS'])) {
			include $this->conf['plugin_path'].'kc_bcs/bcs/bcs.class.php';
			$_SERVER['_kc_bcs_conf'] = $this->kv->get('kc_bcs_conf');
			$_SERVER['_baiduBCS'] = new BaiduBCS ($_SERVER['_kc_bcs_conf']['ak'], $_SERVER['_kc_bcs_conf']['sk'], 'bcs.duapp.com');
		}

		$object = '/avatar/'.$dir.'/'.$user['uid'].'_huge.gif';
		if($_SERVER['_baiduBCS']->is_object_exist($_SERVER['_kc_bcs_conf']['bucket'], $object)) {
			$user['avatar_small'] = str_replace($this->conf['upload_url'], $_SERVER['_kc_bcs_conf']['remotepath'].'/', $user['avatar_small']);
			$user['avatar_middle'] = str_replace($this->conf['upload_url'], $_SERVER['_kc_bcs_conf']['remotepath'].'/', $user['avatar_middle']);
			$user['avatar_big'] = str_replace($this->conf['upload_url'], $_SERVER['_kc_bcs_conf']['remotepath'].'/', $user['avatar_big']);
			$user['avatar_huge'] = str_replace($this->conf['upload_url'], $_SERVER['_kc_bcs_conf']['remotepath'].'/', $user['avatar_huge']);
		}