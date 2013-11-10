<?php
	if($this->form_submit()) {
		$servicefees = core::gpc('servicefees', 'P');
		$pmmessage = core::gpc('pmmessage', 'P');
		$cleardata = core::gpc('cleardata', 'P');

		$rename['servicefees'] = $servicefees;
		$rename['pmmessage'] = $pmmessage;
		$rename['cleardata'] = $cleardata;
		
		$this->kv->set('rename_setting', $rename);
		$this->view->assign('rename_setting', $rename);
		
		$this->message('设置成功！', 1, $this->url('plugin-setting-dir-bj_rename.htm'));
	}else if(core::gpc('type') == 'pending'){
		$this->_checked['pending'] = 'class="checked"';
		$rid = core::gpc('rid');
		$status = core::gpc('status');
		if($rid && $status){
			$config = $this->kv->get('rename_setting');
			!isset($config['pmmessage']) && $config['pmmessage'] = 1;

			$rename = $this->rename->read($rid);
			$rename['status'] = $status;
			$this->rename->update($rename);
			$pmmessage = '';
			$nowname = '';
			if($status == '1'){
				$this->user->index_update(array('uid'=>$rename['uid']), array('username'=>$rename['newname']), TRUE);
				$this->online->index_update(array('uid'=>$rename['uid']), array('username'=>$rename['newname']), TRUE);
				$this->modlog->index_update(array('uid'=>$rename['uid']), array('username'=>$rename['newname']), TRUE);
				$this->rate->index_update(array('uid'=>$rename['uid']), array('username'=>$rename['newname']), TRUE);
				$this->pm->index_update(array('uid1'=>$rename['uid']), array('username1'=>$rename['newname']), TRUE);
				$this->pm->index_update(array('uid2'=>$rename['uid']), array('username2'=>$rename['newname']), TRUE);
				if($user['posts'] > 0) {
					$this->post->index_update(array('uid'=>$rename['uid']), array('username'=>$rename['newname']), TRUE);
				}
				if($user['threads'] > 0) {
					$this->thread->index_update(array('uid'=>$rename['uid']), array('username'=>$rename['newname']), TRUE);
					$this->thread->index_update(array('lastusername'=>$rename['username']), array('lastusername'=>$rename['newname']), TRUE);
				}
				$nowname = $rename['newname'];
	            $pmmessage = '恭喜，您申请从 '.$rename['username'].' 改名为 '.$rename['newname'].' 的服务已经通过。';
			}else{
				$nowname = $rename['username'];
	            $pmmessage = '对不起，您申请从 '.$rename['username'].' 改名为 '.$rename['newname'].' 的服务已被拒绝。';
			}
	        if($config['pmmessage']) {
		    	$this->pm->system_send($rename['uid'], $nowname, $pmmessage);
			}
		}

		$page = misc::page();
		$pagesize = 20;
		$renamelist = $this->rename->get_list_by_status(true, $page, $pagesize);
		$pages = misc::simple_pages("?plugin-setting-dir-bj_rename.htm?type=pending", count($renamelist), $page, $pagesize);

		$this->view->assign('pages', $pages);
		$this->view->assign('renamelist', $renamelist);

		$this->view->display('plugin_rename_pending.htm');
	}else if(core::gpc('type') == 'data'){
		$this->_checked['data'] = 'class="checked"';

		$page = misc::page();
		$pagesize = 15;
		$renamelist = $this->rename->get_all_list($page, $pagesize);
		$pages = misc::simple_pages("?plugin-setting-dir-bj_rename.htm?type=data", count($renamelist), $page, $pagesize);

		$this->view->assign('pages', $pages);
		$this->view->assign('renamelist', $renamelist);

		$this->view->display('plugin_rename_data.htm');
	}else{
		$this->_checked['base'] = 'class="checked"';
		$rename = $this->kv->get('rename_setting');
		
		!isset($rename['servicefees']) && $rename['servicefees'] = 10;
		!isset($rename['pmmessage']) && $rename['pmmessage'] = 1;
		!isset($rename['cleardata']) && $rename['cleardata'] = 0;

		$input['servicefees'] = form::get_text('servicefees', $rename['servicefees'], 50);
		$input['pmmessage'] = form::get_radio_yes_no('pmmessage', $rename['pmmessage']);
		$input['cleardata'] = form::get_radio_yes_no('cleardata', $rename['cleardata']);

		$this->view->assign('dir', $dir);
		$this->view->assign('input', $input);

		$this->view->display('plugin_rename_setting.htm');
	}

?> 