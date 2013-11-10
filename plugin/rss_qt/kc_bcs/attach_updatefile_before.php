
		// 这些功能目前是根据官方功能开发，其实有些问题没考虑，暂时先这样吧 2013.07.25
		if(!empty($_FILES['Filedata']['tmp_name'])) {
			// 对付一些变态的 iis 环境， is_file() 无法检测无权限的目录。
			$tmpfile = FRAMEWORK_TMP_TMP_PATH.md5(rand(0, 1000000000).$_SERVER['time'].$_SERVER['ip']).'.tmp';
			$succeed = IN_SAE ? copy($_FILES['Filedata']['tmp_name'], $tmpfile) : move_uploaded_file($_FILES['Filedata']['tmp_name'], $tmpfile);
			if(!$succeed) {
				$this->message('移动临时文件错误，请检查临时目录的可写权限。', 0);
			}

			$destfile = '/attach/'.$attach['filename'];
			$file = $_FILES['Filedata'];	
			$file['tmp_name'] = $tmpfile;		
			$response = $this->attach->bcs_upload($destfile, $file['tmp_name']);
			if($response->isOK()) {
				$attach['filesize'] = filesize($file['tmp_name']);
				$this->attach->update($attach);
				
				is_file($file['tmp_name']) && unlink($file['tmp_name']);
				
				$this->message($attach);
			} else {
				// 回滚
				$this->attach->delete($fid, $aid);
				$this->message('保存失败！', 0);
			}
		} else {
			$this->message('上传文件失败，可能文件太大。', 0);
		}