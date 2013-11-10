<?php
$type = core::gpc('type');

if($type == "logs"){
	$this->_checked['logs'] = 'class="checked"';

	// 简单分页
	$page = misc::page();
	$pagesize = 20;
	$logslist = $this->bank_logs->get_list_by_all(array(), $page, $pagesize);
	$pages = misc::simple_pages("?type=logs", count($logslist), $page, $pagesize);

	$this->view->assign('pages', $pages);
	$this->view->assign('logslist', $logslist);

	$this->view->display('plugin_config_logs.htm');
}else if($type == "loan"){
	$this->_checked['loan'] = 'class="checked"';
	$did = core::gpc('did');
	$act = core::gpc('act');

	if($did && $act == 1){
		$data = $this->bank_data->read($did);
		if(!$data){
			$this->message('参数传递错误，请返回。', 1, $this->url('?plugin-setting-dir-bj_bank-type-loan.htm'));
		}
		$time = $_SERVER['time'];
		$data['status'] = '1';
		$data['begintime'] = $time;
	    $data['endtime'] = $time + (60 * 60 * 24 * $data['day']);
	    $this->bank_data->update($data);

	    $user = $this->user->read($data['uid']);
	    $user['bank_deposit'] += $data['money'];
	    $this->user->update($user);

        $pmmessage = '恭喜您，您申请的抵押贷款已经通过，'.$data['money'].' 枚金币到您的中央银行账户上，请在规定期限内归还本金及利息，否则最少将没收抵押 '.$data['credit'].' 点积分。';
        $this->pm->system_send($data['uid'], $data['username'], $pmmessage);
	}else if($did && $act == 0){
		$data = $this->bank_data->read($did);
		if(!$data){
			$this->message('参数传递错误，请返回。', 1, $this->url('?plugin-setting-dir-bj_bank-type-loan.htm'));
		}
		$this->bank_data->delete($did);
        $pmmessage = '对不起，您申请的抵押贷款已被拒绝。';
        $this->pm->system_send($data['uid'], $data['username'], $pmmessage);
	}


	// 简单分页
	$page = misc::page();
	$pagesize = 20;
	$loanlist = $this->bank_data->get_loan_list_by_all(array('status'=>0), $page, $pagesize);
	$pages = misc::simple_pages("?type=loan", count($loanlist), $page, $pagesize);

	$this->view->assign('pages', $pages);
	$this->view->assign('loanlist', $loanlist);

	$this->view->display('plugin_config_loan.htm');
}else if($type == "overdue"){
	$this->_checked['overdue'] = 'class="checked"';
	$did = core::gpc('did');
	$act = core::gpc('act');

	if($did && $act == 1){
		$data = $this->bank_data->read($did);
		if(!$data){
			$this->message('参数传递错误，请返回。', 1, $this->url('?plugin-setting-dir-bj_bank-type-overdue.htm'));
		}
		$time = $_SERVER['time'];
		$data['status'] = '1';
		$data['begintime'] = $time;
	    $data['endtime'] = $time + (60 * 60 * 24 * $data['day']);
	    //$this->bank_data->update($data);

	    $user = $this->user->read($data['uid']);
	    $user['bank_deposit'] += $data['money'];
	    //$this->user->update($user);

        $pmmessage = '恭喜您，您申请的抵押贷款已经通过，'.$data['money'].' 枚金币到您的中央银行账户上，请在规定期限内归还本金及利息，否则最少将没收抵押 '.$data['credit'].' 点积分。';
        //$this->pm->system_send($data['uid'], $data['username'], $pmmessage);
	}else if($did && $act == 0){
		$data = $this->bank_data->read($did);
		if(!$data){
			$this->message('参数传递错误，请返回。', 1, $this->url('?plugin-setting-dir-bj_bank-type-overdue.htm'));
		}

	    $user = $this->user->read($data['uid']);
	    $user['credits'] -= $data['credit'];
	    $this->user->update($user);

		$this->bank_data->delete($did);
        $pmmessage = '对不起，由于您在规定的期限内没有归还贷款的本金和利息，中央银行已没收约定的扣押积分'.$data['credit'].'点。';
        $this->pm->system_send($data['uid'], $data['username'], $pmmessage);
	}

	// 简单分页
	$page = misc::page();
	$pagesize = 20;
	$overduelist = $this->bank_data->get_loan_list_by_all(array('status'=>1, 'endtime'=>array('<'=>$_SERVER['time'])), $page, $pagesize);
	$pages = misc::simple_pages("?type=overdue", count($overduelist), $page, $pagesize);

	$this->view->assign('pages', $pages);
	$this->view->assign('overduelist', $overduelist);

	$this->view->display('plugin_config_overdue.htm');
}else if($this->form_submit() && $type == "base") {
	$close = core::gpc('close', 'P');
	$closemessage = core::gpc('closemessage', 'P');
	$poundage = core::gpc('poundage', 'P');
	$current = core::gpc('current', 'P');
	$fixed = core::gpc('fixed', 'P');
	$minfixed = core::gpc('minfixed', 'P');
	$loan = core::gpc('loan', 'P');
	$transfer = core::gpc('transfer', 'P');
	$mintransfer = core::gpc('mintransfer', 'P');
	$pmtransfer = core::gpc('pmtransfer', 'P');
	$notice = core::gpc('notice', 'P');
	$cleardata = core::gpc('cleardata', 'P');

	$bank['close'] = $close;
	$bank['closemessage'] = $closemessage;
	$bank['poundage'] = $poundage;
	$bank['current'] = $current;
	$bank['fixed'] = $fixed;
	$bank['minfixed'] = $minfixed;
	$bank['loan'] = $loan;
	$bank['transfer'] = $transfer;
	$bank['mintransfer'] = $mintransfer;
	$bank['pmtransfer'] = $pmtransfer;
	$bank['notice'] = $notice;
	$bank['cleardata'] = $cleardata;
	
	$this->kv->set('bank_config', $bank);
	$this->view->assign('bank_config', $bank);
	
	$this->message('设置成功！', 1, $this->url('plugin-setting-dir-bj_bank.htm?type=base'));
}else{
	$this->_checked['base'] = 'class="checked"';
	$bank = $this->kv->get('bank_config');
	
	!isset($bank['close']) && $bank['close'] = 0;
	!isset($bank['closemessage']) && $bank['closemessage'] = '站长贪污，关门调查中...';
	!isset($bank['notice']) && $bank['notice'] = '中央银行正式开业，目前正在营业中...';
	!isset($bank['poundage']) && $bank['poundage'] = 10;
	!isset($bank['current']) && $bank['current'] = 0.3;
	!isset($bank['fixed']) && $bank['fixed'] = 0.5;
	!isset($bank['minfixed']) && $bank['minfixed'] = 30;
	!isset($bank['loan']) && $bank['loan'] = 1;
	!isset($bank['transfer']) && $bank['transfer'] = 0.8;
	!isset($bank['mintransfer']) && $bank['mintransfer'] = 100;
	!isset($bank['pmtransfer']) && $bank['pmtransfer'] = 10;
	!isset($bank['cleardata']) && $bank['cleardata'] = 0;

	$input['close'] = form::get_radio_yes_no('close', $bank['close']);
	$input['closemessage'] = form::get_textarea('closemessage', $bank['closemessage'], 300, 60);
	$input['notice'] = form::get_textarea('notice', $bank['notice'], 300, 60);
	$input['poundage'] = form::get_text('poundage', $bank['poundage'], 50);
	$input['current'] = form::get_text('current', $bank['current'], 80);
	$input['fixed'] = form::get_text('fixed', $bank['fixed'], 80);
	$input['minfixed'] = form::get_text('minfixed', $bank['minfixed'], 80);
	$input['loan'] = form::get_text('loan', $bank['loan'], 80);
	$input['transfer'] = form::get_text('transfer', $bank['transfer'], 80);
	$input['mintransfer'] = form::get_text('mintransfer', $bank['mintransfer'], 80);
	$input['pmtransfer'] = form::get_text('pmtransfer', $bank['pmtransfer'], 80);
	$input['cleardata'] = form::get_radio_yes_no('cleardata', $bank['cleardata']);
	
	$this->view->assign('dir', $dir);
	$this->view->assign('input', $input);
	$this->view->display('plugin_config_base.htm');
}

?> 