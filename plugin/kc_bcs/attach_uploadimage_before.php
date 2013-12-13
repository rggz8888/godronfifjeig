		//  && is_file($_FILES['Filedata']['tmp_name'])
		if(!empty($_FILES['Filedata']['tmp_name'])) {
			
			// 对付一些变态的 iis 环境， is_file() 无法检测无权限的目录。
			$tmpfile = FRAMEWORK_TMP_TMP_PATH.md5(rand(0, 1000000000).$_SERVER['time'].$_SERVER['ip']).'.tmp';
			$succeed = IN_SAE ? copy($_FILES['Filedata']['tmp_name'], $tmpfile) : move_uploaded_file($_FILES['Filedata']['tmp_name'], $tmpfile);
			if(!$succeed) {
				$this->message('移动临时文件错误，请检查临时目录的可写权限。', 0);
			}
			
			$file = $_FILES['Filedata'];
			$file['tmp_name'] = $tmpfile;
			core::htmlspecialchars($file['name']);
			$filetype = $this->attach->get_filetype($file['name']);
			if($filetype != 'image') {
				$allowtypes = $this->attach->get_allow_filetypes();
				$this->message('请选择图片格式的文件，后缀名为：.gif, .jpg, .png, .bmp！', 0);
			}
			
			if(!$this->attach->is_safe_image($file['tmp_name'])) {
				$this->message('系统检测到图片('.$file['name'].')不是安全的，请更换其他图片试试。', 0);
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
				'isimage'=>1,
				'golds'=>0,
				'uid'=>$this->_user['uid'],
			);
			$aid = $this->attach->create($arr);
			//$this->attach->save_aid_to_tmp($fid, $aid, $uid);
			
			// 处理文件
			$imginfo = getimagesize($file['tmp_name']);
			
			// 如果为 GIF, 直接 copy
			// 判断文件类型，如果为图片文件，缩略，否则直接保存。
			switch ($imginfo[2]){
				case 3:
				$imgtype='.png';
				break;
				case 6:
				$imgtype='.bmp';
				break;
				default:
				$imgtype='.jpg';
				}
			if($imginfo[2] == 1) {
				$md5name = md5($aid.'_'.$this->conf['auth_key']);
				$fileurl = image::get_dir($aid).'/'.$md5name.'.gif';
				$destfile = '/attach/'.$fileurl;
				$response = $this->attach->bcs_upload($destfile, $file['tmp_name']);
				if($response->isOK()) {
					$r = array();
					$r['filesize'] = filesize($file['tmp_name']);
					//$r['filesize'] = $file['size'];
					$r['width'] = $imginfo[0];
					$r['height'] = $imginfo[1];
					$r['fileurl'] = $fileurl;
				} else {
					// 回滚
					$this->attach->delete($fid, $aid);
					$this->message('保存失败！', 0);
				}
			} else {
				
		
				$r = image::thumb($file['tmp_name'], $file['tmp_name'].$imgtype, $this->conf['upload_image_max_width'], 240000);
				image::clip_thumb($file['tmp_name'], $file['tmp_name'].'_thumb'.$imgtype, $this->conf['thread_icon_middle'], $this->conf['thread_icon_middle']);

				$md5name = md5($aid.'_'.$this->conf['auth_key']);
				$fileurl = image::get_dir($aid).'/'.$md5name.$imgtype;
				$destfile = '/attach/'.$fileurl;
				$thumbfile = image::thumb_name($destfile);

				$response = $this->attach->bcs_upload($destfile, $file['tmp_name'].$imgtype);
				$response2 = $this->attach->bcs_upload($thumbfile, $file['tmp_name'].'_thumb'.$imgtype);
				if(!$response->isOK() || !$response2->isOK()) {
					// 回滚
					$this->attach->delete($fid, $aid);
					$this->message('保存失败！', 0);
				}
				$r['fileurl'] = $fileurl;
			}
			
			$arr['aid'] = $aid;
			$arr['fid'] = $fid;
			$arr['filesize'] = $r['filesize'];
			$arr['width'] = $r['width'];
			$arr['height'] = $r['height'];
			$arr['filename'] = $r['fileurl'];
			$this->attach->update($arr);
			if($fid > 0 && $pid > 0) {
				$post = $this->post->read($fid, $pid);
				$this->check_post_exists($post);
				$ismod = $this->is_mod($forum, $this->_user);
				$post['uid'] != $uid && !$ismod && $this->message('您无权编辑此帖附件。');
				$post['imagenum']++;
				$this->post->update($post);
				
				$thread = $this->thread->read($fid, $post['tid']);
				$this->check_thread_exists($thread);
				if($thread['firstpid'] == $pid) {
					$thread['uid'] != $uid && !$ismod && $this->message('您无权编辑此帖附件。');
					$thread['imagenum']++;
					$this->thread->update($thread);
				}
				
				$arr['tid'] = $thread['tid'];
			}
			is_file($file['tmp_name']) && unlink($file['tmp_name']);
			is_file($file['tmp_name'].$imgtype) && unlink($file['tmp_name'].$imgtype);
			is_file($file['tmp_name'].'_thumb'.$imgtype) && unlink($file['tmp_name'].'_thumb'.$imgtype);
			
			$this->message('<img src="'.$_SERVER['_kc_bcs_conf']['remotepath'].'/attach/'.$r['fileurl'].'" width="'.$arr['width'].'" height="'.$arr['height'].'"/>');
			
		} else {
			if($_FILES['Filedata']['error'] == 1) {
				$this->message('上传文件( '.htmlspecialchars($_FILES['Filedata']['name']).' )太大，超出了 php.ini 的设置：'.ini_get('upload_max_filesize'), 0);
			} else {
				$this->message('上传文件失败，错误编码：'.$_FILES['Filedata']['error'].', FILES: '.print_r($_FILES, 1).', is_file: '.is_file($_FILES['Filedata']['tmp_name']).', file_exists: '.file_exists($_FILES['Filedata']['tmp_name']), 0); // .print_r($_FILES, 1)
			}
		}