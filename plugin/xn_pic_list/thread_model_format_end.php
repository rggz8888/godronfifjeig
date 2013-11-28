if(empty($_SERVER['_baiduBCS'])) {
			include $this->conf['plugin_path'].'kc_bcs/bcs/bcs.class.php';
			$_SERVER['_kc_bcs_conf'] = $this->kv->get('kc_bcs_conf');
			$_SERVER['_baiduBCS'] = new BaiduBCS ($_SERVER['_kc_bcs_conf']['ak'], $_SERVER['_kc_bcs_conf']['sk'], 'bcs.duapp.com');
		}
if(substr($thread['coverimg'],0,4) != 'http')
$thread['coverimg'] && $thread['coverimg'] = $_SERVER['_kc_bcs_conf']['remotepath'].'/attach/'.$thread['coverimg'];
else $thread['coverimg'] && $thread['coverimg'] = $thread['coverimg'];