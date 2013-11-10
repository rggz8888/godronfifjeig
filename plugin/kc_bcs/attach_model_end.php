
	// 上传 object （上传到百度云储存）
	public function bcs_upload($object, $file, $opt = array()) {
		$this->bcs_load();

		$opt_old = array (
			'acl' => BaiduBCS::BCS_SDK_ACL_TYPE_PUBLIC_READ_WRITE,
		);
		$opt = array_merge($opt_old, $opt);
		return $_SERVER['_baiduBCS']->create_object($_SERVER['_kc_bcs_conf']['bucket'], $object, $file, $opt);
	}

	// 删除 object
	public function bcs_delete($object) {
		$this->bcs_load();

		return $_SERVER['_baiduBCS']->delete_object($_SERVER['_kc_bcs_conf']['bucket'], $object);
	}

	// 判断 object 是否存在
	public function bcs_is_object_exist($object) {
		$this->bcs_load();

		return $_SERVER['_baiduBCS']->is_object_exist($_SERVER['_kc_bcs_conf']['bucket'], $object);
	}

	// 加载
	public function bcs_load() {
		if(empty($_SERVER['_baiduBCS'])) {
			include $this->conf['plugin_path'].'kc_bcs/bcs/bcs.class.php';
			$_SERVER['_kc_bcs_conf'] = $this->kv->get('kc_bcs_conf');
			$_SERVER['_baiduBCS'] = new BaiduBCS ($_SERVER['_kc_bcs_conf']['ak'], $_SERVER['_kc_bcs_conf']['sk'], 'bcs.duapp.com');
		}
	}