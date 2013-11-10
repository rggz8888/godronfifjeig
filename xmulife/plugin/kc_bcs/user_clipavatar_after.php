
			if(empty($_SERVER['_baiduBCS'])) {
				include $this->conf['plugin_path'].'kc_bcs/bcs/bcs.class.php';
				$_SERVER['_kc_bcs_conf'] = $this->kv->get('kc_bcs_conf');
				$_SERVER['_baiduBCS'] = new BaiduBCS ($_SERVER['_kc_bcs_conf']['ak'], $_SERVER['_kc_bcs_conf']['sk'], 'bcs.duapp.com');
			}

			try{
				$obj_smallfile = "/avatar/$dir/$user[uid]_small.gif";
				$obj_middlefile = "/avatar/$dir/$user[uid]_middle.gif";
				$obj_bigfile = "/avatar/$dir/$user[uid]_big.gif";
				$obj_hugefile = "/avatar/$dir/$user[uid]_huge.gif";

				$opt = array (
					'acl' => BaiduBCS::BCS_SDK_ACL_TYPE_PUBLIC_READ_WRITE,
				);
				$_SERVER['_baiduBCS']->create_object($_SERVER['_kc_bcs_conf']['bucket'], $obj_smallfile, $smallfile, $opt);
				$_SERVER['_baiduBCS']->create_object($_SERVER['_kc_bcs_conf']['bucket'], $obj_middlefile, $middlefile, $opt);
				$_SERVER['_baiduBCS']->create_object($_SERVER['_kc_bcs_conf']['bucket'], $obj_bigfile, $bigfile, $opt);
				$_SERVER['_baiduBCS']->create_object($_SERVER['_kc_bcs_conf']['bucket'], $obj_hugefile, $hugefile, $opt);

				// 如果不想删除自己服务器头像，删除下面四行代码即可
				is_file($smallfile) && unlink($smallfile);
				is_file($middlefile) && unlink($middlefile);
				is_file($bigfile) && unlink($bigfile);
				is_file($hugefile) && unlink($hugefile);
			}catch(Exception $e) {}