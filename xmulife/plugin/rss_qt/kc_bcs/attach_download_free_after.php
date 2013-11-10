			if($this->attach->bcs_is_object_exist('/attach/'.$attach['filename'])) {
				header('Location: '.$_SERVER['_kc_bcs_conf']['remotepath'].'/attach/'.$attach['filename']);
				exit;
			}