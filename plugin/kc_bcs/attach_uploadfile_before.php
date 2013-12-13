
		if(!empty($_FILES['Filedata']['tmp_name'])) {
			// 对付一些变态的 iis 环境， is_file() 无法检测无权限的目录。
			$tmpfile = FRAMEWORK_TMP_TMP_PATH.md5(rand(0, 1000000000).$_SERVER['time'].$_SERVER['ip']).'.tmp';
			$succeed = IN_SAE ? copy($_FILES['Filedata']['tmp_name'], $tmpfile) : move_uploaded_file($_FILES['Filedata']['tmp_name'], $tmpfile);
			if(!$succeed) {
				$this->message('移动临时文件错误，请检查临时目录的可写权限。', 0);
			}
			
			$file = $_FILES['Filedata'];
			$file['tmp_name'] = $tmpfile;
			$file['name'] = htmlspecialchars($file['name']);
			$filetype = $this->attach->get_filetype($file['name']);
			// 多后缀名以最后一个 . 为准。文件名舍弃，避免非法文件名。
			$ext = strrchr($file['name'], '.');
			if($filetype == 'unknown') {
				$ext = $this->attach->safe_ext($ext);
			}
			
			$arr = array (
				'fid'=>$fid,
				'tid'=>0,
				'pid'=>$pid,
				'filesize'=>0,
				'width'=>0,
				'height'=>0,
				'filename'=>'',
				'orgfilename'=>$file['name'],
				'filetype'=>$filetype,
				'dateline'=>$_SERVER['time'],
				'comment'=>'',
				'downloads'=>0,
				'isimage'=>0,
				'golds'=>0,
				'uid'=>$uid,
			);
			$aid = $this->attach->create($arr);
			
			// $aid 保存到临时文件，每个用户一个文件，里面记录 aid。在读取后删除该文件。
			// 如果tmp为内存，则在用户未完成期间，可能会导致垃圾数据产生。可以通过 uid=123 and pid=0，来判断附件归属，不过这个查询未建立索引，可以定期清理，一般不需要。
			//$this->attach->save_aid_to_tmp($fid, $aid, $uid);
			
			
			// 处理文件
			$pathadd = image::get_dir($aid);
			$filename = md5($aid.'_'.$this->conf['auth_key']).$ext;
			$destfile = '/attach/'.$pathadd.'/'.$filename;

			$arr['fid'] = $fid;
			$arr['aid'] = $aid;
			$arr['filename'] = $pathadd.'/'.$filename;
			$arr['filesize'] = filesize($file['tmp_name']);
			//$r['filesize'] = $file['size'];
			$this->attach->update($arr);

			$response = $this->attach->bcs_upload($destfile, $file['tmp_name'], array('filename' => $file['name']));
			if($response->isOK()) {
				
				// hook attach_uploadfile_after.php
				$arr['desturl'] = $_SERVER['_kc_bcs_conf']['remotepath'].$pathadd.'/'.$filename;
				
				is_file($file['tmp_name']) && unlink($file['tmp_name']);
				
				$this->message($arr);
			} else {
				// 回滚
				$this->attach->delete($fid, $aid);
				$this->message('保存失败！', 0);
			}
			
		} else {
			$this->message('上传文件失败，可能文件太大。', 0);
		}