<?php

/*
 * Copyright (C) xiuno.com
 * $arr = $this->user->db->fetch_first("SELECT SUM(golds) FROM {$tablepre}user");
 */

!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');

include BBS_PATH.'control/common_control.class.php';

class bank_control extends common_control {
	
	function __construct(&$conf) {
		parent::__construct($conf);
		$this->check_login();
		
		// 初始化用户信息
		$uid = $this->_user['uid'];
		$user = $this->user->read($uid);
		$this->check_user_exists($user);
		$this->user->format($user);
		$this->_user = $user;
	}
	
	public function on_index() {
		$this->on_profile();
	}

	public function on_profile() {
		$this->_checked['profile'] = 'class="checked"';
		
		$this->_title[] = '营业大厅';
		$this->_nav[] = '营业大厅';
		
		$_user = $this->_user;
		$uid = $_user['uid'];

		if($this->form_submit()) {
		    $bank = $this->kv->get('bank_config');
			!isset($bank['poundage']) && $bank['poundage'] = 0;
			
			$cash = $_user['golds'];
			$poundage = $bank['poundage'];
			$user = $this->user->read($uid);
			$message = '';
			if($user['bank_status']){
				$message = '您的帐户已开通，请勿重复操作！';
			}else if($cash < $poundage){	//现金不够
				$message = '您的金币不足以支付开户费用！';
			}else{
				$user['golds'] -= $poundage;
				$user['bank_status'] = 1;
				$user['bank_opentime'] = $_SERVER['time'];
				$user['bank_begintime'] = $_SERVER['time'];
				$this->user->update($user);
				$message = '恭喜您开户成功，您可以进行相关业务操作了。';

		        $logsObj = array (
		            'uid'=>$user['uid'],
		            'golds'=>$poundage,
		            'type'=>1,
		            'message'=>$user['username'].'开户成功，收取开户手续费'.$poundage.'枚金币。',
		            'dateline'=>$_SERVER['time']
		        );
		        $this->bank_logs->create($logsObj);
			}
			$this->message($message, 1, $this->url('bank-profile.htm'));
		}

		$config = $this->kv->get('bank_config');

		$this->view->assign('config', $config);
		$this->view->assign('bank_status', $_user['bank_status']);
		
		$this->view->display('bank_profile.htm');
	}
	
	public function on_current() {
		$this->_checked['current'] = 'class="checked"';

		$this->_title[] = '活期储蓄';
		$this->_nav[] = '活期储蓄';

		if(!$this->_user['bank_status']){
			$this->message('您还没有在本银行开户，请返回开户后再操作。', 1, $this->url('bank-profile.htm'));
		}

		$uid = $this->_user['uid'];
		$user = $this->user->read($uid);
		$config = $this->kv->get('bank_config');

		$buttonval = core::gpc('button', 'P');
		if($this->form_submit() && $buttonval == 'operate') {
			$money = core::gpc('money', 'P');
			$curorfix = core::gpc('curorfix', 'P');
			if(!ereg("^[0-9]*[1-9][0-9]*$", $money)){
				$this->message('您输入的金额有误，请返回修改。');
			}
			if($curorfix == "cur"){
				if($user['golds'] >= $money){
					$tmpcur = $this->hack_showMyCur($user, $config);
					$user['golds'] -= $money;
					$user['bank_deposit'] += $money;
					$user['bank_deposit'] += $tmpcur['currate'];
					$user['bank_begintime'] = $_SERVER['time'];
					
					$this->user->update($user);

			        $logsObj = array (
			            'uid'=>$user['uid'],
			            'golds'=>$money,
			            'type'=>2,
			            'message'=>$user['username'].'存入活期'.$money.'枚金币，结息'.$tmpcur['currate'].'枚金币。',
			            'dateline'=>$_SERVER['time']
			        );
			        $this->bank_logs->create($logsObj);
					$this->message('操作成功，存入活期'.$money.'枚金币，结息'.$tmpcur['currate'].'枚金币。', 1, $this->url('bank-current.htm'));
				}else{
					$this->message('您的金币不足'.$money.'枚，请修改。');
				}
			}else if($curorfix == "fix"){
				if($user['bank_deposit'] >= $money){
					$tmpcur = $this->hack_showMyCur($user, $config);
					$user['golds'] += $money;
					$user['bank_deposit'] -= $money;
					$user['bank_deposit'] += $tmpcur['currate'];
					$user['bank_begintime'] = $_SERVER['time'];
					
					$this->user->update($user);

			        $logsObj = array (
			            'uid'=>$user['uid'],
			            'golds'=>$money,
			            'type'=>2,
			            'message'=>$user['username'].'取出活期'.$money.'枚金币，结息'.$tmpcur['currate'].'枚金币。',
			            'dateline'=>$_SERVER['time']
			        );
			        $this->bank_logs->create($logsObj);
					$this->message('操作成功，取出活期'.$money.'枚金币，结息'.$tmpcur['currate'].'枚金币。', 1, $this->url('bank-current.htm'));
				}else{
					$this->message('您的存款不足'.$money.'枚，请修改。');
				}
			}
		}else if($this->form_submit() && $buttonval == 'settle'){
			$tmpcur = $this->hack_showMyCur($user, $config);
			if($tmpcur['currate'] != 0){
				$user['bank_deposit'] += $tmpcur['currate'];
				$user['bank_begintime'] = $_SERVER['time'];
					
				$this->user->update($user);

		        $logsObj = array (
		            'uid'=>$user['uid'],
		            'golds'=>$tmpcur['currate'],
		            'type'=>2,
		            'message'=>$user['username'].'手动结息'.$tmpcur['currate'].'枚金币。',
		            'dateline'=>$_SERVER['time']
		        );
		        $this->bank_logs->create($logsObj);
				$this->message('操作成功，手动结息'.$tmpcur['currate'].'枚金币。', 1, $this->url('bank-current.htm'));
			}
		}

		$this->_user['bank_mycur'] = $this->hack_showMyCur($user, $config);
		$this->_user['bank_begintime_str'] = date("Y-m-d H:i", $this->_user['bank_begintime']);

		$input['money'] = form::get_text('money', '');
		$input['curorfix'] = form::get_radio('curorfix', array('cur'=>'存款', 'fix'=>'取款'), 'cur');

		$this->view->assign('input', $input);
		$this->view->assign('config', $config);
		
		$this->view->display('bank_current.htm');
	}
	
	public function on_fixed() {
		$this->_checked['fixed'] = 'class="checked"';
		
		$this->_title[] = '定期储蓄';
		$this->_nav[] = '定期储蓄';

		if(!$this->_user['bank_status']){
			$this->message('您还没有在本银行开户，请返回开户后再操作。', 1, $this->url('bank-profile.htm'));
		}

		$uid = $this->_user['uid'];
		$user = $this->user->read($uid);
		$config = $this->kv->get('bank_config');
		$money = core::gpc('money', 'P');
		$day = core::gpc('day', 'P');

		if($this->form_submit()) {
			if(!ereg("^[0-9]*[1-9][0-9]*$", $money)){
				$this->message('您输入的金额有误，请返回修改。');
			}if($user['golds'] < $money){
				$this->message('您的金币不足 '.$money.' 枚，请返回修改。');
			}else if(!ereg("^[0-9]*[1-9][0-9]*$", $day) || $day < $config['minfixed']){
				$this->message('定期存款的天数不得小于 '.$config['minfixed'].' 天，请返回。');
			}

			$user['golds'] -= $money;
			$this->user->update($user);

			$time = $_SERVER['time'];
	        $dataObj = array (
	            'uid'=>$user['uid'],
	            'money'=>$money,
	            'rate'=>$config['fixed'],
	            'day'=>$day,
	            'begintime'=>$time,
	            'endtime'=>$time + (60 * 60 * 24 * $day)
	        );
	        $this->bank_data->create($dataObj);

	        $logsObj = array (
	            'uid'=>$user['uid'],
	            'golds'=>$money,
	            'type'=>3,
	            'message'=>$user['username'].'存入定期 '.$money.' 枚金币，时间为 '.$day.' 天。',
	            'dateline'=>$_SERVER['time']
	        );
	        $this->bank_logs->create($logsObj);

			$this->message('操作成功，存入定期'.$money.'枚金币。', 1, $this->url('bank-fixed.htm'));
		}else if (core::gpc('did')) {
			$data = $this->bank_data->read(core::gpc('did'));

			if(!$data || $data['uid'] != $user['uid']){
				$this->message('参数传递错误，请返回。', 1, $this->url('bank-fixed.htm'));
			}

	        if($_SERVER['time'] - $data['endtime'] >= 0){
	            $data['interest_str'] = floor($data['money'] * $data['rate'] / 100);
	        }else{
	            $data['interest_str'] = '0';
	        }

			$user['golds'] += $data['money'];
			$user['golds'] += $data['interest_str'];
				
			$this->user->update($user);
			$this->bank_data->delete($data['did']);

	        $logsObj = array (
	            'uid'=>$user['uid'],
	            'golds'=>$data['money'],
	            'type'=>3,
	            'message'=>$user['username'].'取出定期'.$money.'枚金币，结息'.$data['interest_str'].'枚金币。',
	            'dateline'=>$_SERVER['time']
	        );
	        $this->bank_logs->create($logsObj);

			$this->message('操作成功，取出定期'.$data['money'].'枚金币，结息'.$data['interest_str'].'枚金币。', 1, $this->url('bank-fixed.htm'));
		}

		$input['money'] = form::get_text('money', '');
		$input['day'] = form::get_text('day', '', 60);
		$input['conf_fixed'] = form::get_hidden('conf_fixed', $config['fixed']);

		// 简单分页
		$page = misc::page();
		$pagesize = 10;
		$datalist = $this->bank_data->get_fixed_list_by_uid($uid, $page, $pagesize);
		$pages = misc::simple_pages("?bank-fixed.htm", count($datalist), $page, $pagesize);

		$this->view->assign('input', $input);
		$this->view->assign('config', $config);
		$this->view->assign('pages', $pages);
		$this->view->assign('datalist', $datalist);
		
		$this->view->display('bank_fixed.htm');
	}
	
	public function on_transfer() {
		$this->_checked['transfer'] = 'class="checked"';
		
		$this->_title[] = '转账汇款';
		$this->_nav[] = '转账汇款';

		if(!$this->_user['bank_status']){
			$this->message('您还没有在本银行开户，请返回开户后再操作。', 1, $this->url('bank-profile.htm'));
		}

		$uid = $this->_user['uid'];
		$user = $this->user->read($uid);
		$config = $this->kv->get('bank_config');

		if($this->form_submit()){
			$money = core::gpc('money', 'P');
			$tousername = core::gpc('tousername', 'P');

			$touser = $this->user->get_user_by_username($tousername);
			if(trim($tousername) == ""){
				$this->message('对不起，对方帐号不能为空，请修改。');
			}else if(!$touser){
				$this->message('对不起，'.$tousername.' 不存在，请修改。');
			}else if(!$touser['bank_status']){
				$this->message('对不起，'.$tousername.' 未在本银行开户，请通知对方开户后再转账。');
			}

			if(!ereg("^[0-9]*[1-9][0-9]*$", $money)){
				$this->message('您输入的金额有误，请返回修改。');
			}else if($money < $config['mintransfer']){
				$this->message('转账汇款的金额不能小于'.$config['mintransfer'].'枚金币，请重新输入。');
			}

			$moneyfee = floor($money * ($config['transfer'] / 100));
			$moneyall = $money + $moneyfee + $config['pmtransfer'];	//转账费、服务费、短消息费

			if($user['golds'] >= $moneyall){
				$user['golds'] -= $money;
				$user['golds'] -= $config['pmtransfer'];
				$touser['bank_deposit'] += $money;
				$touser['bank_begintime'] = $_SERVER['time'];
				
				$this->user->update($user);
				$this->user->update($touser);

		        $logsObj = array (
		            'uid'=>$user['uid'],
		            'golds'=>$money,
		            'type'=>4,
		            'message'=>$user['username'].'转账'.$money.'枚金币至'.$tousername.'，支付手续费'.$moneyfee.'枚金币'.($config['pmtransfer'] ? '，短消息服务费'.$config['pmtransfer'].'枚金币。' : '。'),
		            'dateline'=>$_SERVER['time']
		        );
		        $this->bank_logs->create($logsObj);

		        if($config['pmtransfer']){
		            $pmmessage = '用户 '.$user['username'].' 汇款 '.$money.' 枚金币到您的中央银行账户上，请注意查收。';
		            $this->pm->system_send($touser['uid'], $touser['username'], $pmmessage);
		        }
				$this->message('操作成功，转账'.$money.'枚金币至'.$tousername.'，支付手续费'.$moneyfee.'枚金币'.($config['pmtransfer'] ? '，短消息服务费'.$config['pmtransfer'].'枚金币。' : '。'), 1, $this->url('bank-transfer.htm'));
			}else{
				$this->message('您的金币不足'.$moneyall.'枚，请修改。');
			}
		}

		$input['money'] = form::get_text('money', '');
		$input['tousername'] = form::get_text('tousername', '');
		$input['pmmsg'] = form::get_checkbox_yes_no('pmmsg', '');
		$input['conf_transfer'] = form::get_hidden('conf_transfer', $config['transfer']);

		//$input['pm'] = form::get_text('pm', '');短消息服务费

		$this->view->assign('config', $config);
		$this->view->assign('input', $input);
		
		$this->view->display('bank_transfer.htm');
	}
	
	public function on_loan() {
		$this->_checked['loan'] = 'class="checked"';
		
		$this->_title[] = '抵押贷款';
		$this->_nav[] = '抵押贷款';

		if(!$this->_user['bank_status']){
			$this->message('您还没有在本银行开户，请返回开户后再操作。', 1, $this->url('bank-profile.htm'));
		}

		$uid = $this->_user['uid'];
		$user = $this->user->read($uid);
		$config = $this->kv->get('bank_config');
		$credit = core::gpc('credit', 'P');
		$money = core::gpc('money', 'P');
		$day = core::gpc('day', 'P');
		$type = core::gpc('type');
		$did = core::gpc('did');

		if($this->form_submit()){
			if(!ereg("^[0-9]*[1-9][0-9]*$", $credit)){
				$this->message('您输入的积分有误，请返回修改。');
			}else if($user['credits'] < $credit){
				$this->message('您并没有足够的积分，请返回修改。');
			}else if(!ereg("^[0-9]*[1-9][0-9]*$", $money)){
				$this->message('您输入的金额有误，请返回修改。');
			}else if(!ereg("^[0-9]*[1-9][0-9]*$", $day)){
				$this->message('您输入的天数有误，请返回修改。');
			}

			$time = $_SERVER['time'];
	        $dataObj = array (
	            'uid'=>$user['uid'],
	            'type'=>1,
	            'money'=>$money,
	            'credit'=>$credit,
	            'rate'=>$config['loan'],
	            'day'=>$day,
	            'begintime'=>0,
	            'endtime'=>0
	        );
	        $this->bank_data->create($dataObj);

	        $logsObj = array (
	            'uid'=>$user['uid'],
	            'golds'=>$money,
	            'type'=>5,
	            'message'=>$user['username'].'用'.$credit.'点积分作为抵押，贷款'.$money.'枚金币，'.$day.'天之内归还。',
	            'dateline'=>$_SERVER['time']
	        );
	        $this->bank_logs->create($logsObj);
			$this->message('操作成功，请等待审核。', 1, $this->url('bank-loan.htm'));
		}else if($type == "cancel"){
			$data = $this->bank_data->read(core::gpc('did'));

			if(!$data || $data['uid'] != $user['uid']){
				$this->message('参数传递错误，请返回。', 1, $this->url('bank-loan.htm'));
			}

	        $logsObj = array (
	            'uid'=>$user['uid'],
	            'golds'=>$money,
	            'type'=>5,
	            'message'=>$user['username'].'取消了'.$credit.'点积分、'.$money.'枚金币的贷款业务。',
	            'dateline'=>$_SERVER['time']
	        );
	        $this->bank_logs->create($logsObj);
			$this->bank_data->delete($data['did']);
			$this->message('操作成功，已经取消了您的贷款。', 1, $this->url('bank-loan.htm'));
		}else if($type == "repay"){
			echo "xxxxxxxxx";
			$data = $this->bank_data->read(core::gpc('did'));

			if(!$data || $data['uid'] != $user['uid']){
				$this->message('参数传递错误，请返回。', 1, $this->url('bank-loan.htm'));
			}

			$remoney = $this->bank_data->rates($data);
			$allmoney = $data['money'] + $remoney;

			if($user['golds'] < $allmoney){
				$this->message('对不起，您的金币不足 '.$allmoney.' ，不能归还全部贷款。');
			}

            $user['golds'] -= $allmoney;
            $this->user->update($user);

            $this->bank_data->delete($data['did']);

	        $logsObj = array (
	            'uid'=>$user['uid'],
	            'golds'=>$money,
	            'type'=>5,
	            'message'=>$user['username'].'归还了本金'.$data['money'].'枚金币，利息'.$remoney.'枚金币。',
	            'dateline'=>$_SERVER['time']
	        );
	        $this->bank_logs->create($logsObj);
			$this->message('操作成功，您的贷款已归还。', 1, $this->url('bank-loan.htm'));
		}

		$input['money'] = form::get_text('money', '');
		$input['credit'] = form::get_text('credit', '');
		$input['day'] = form::get_text('day', '', 60);

		// 简单分页
		$page = misc::page();
		$pagesize = 10;
		$datalist = $this->bank_data->get_loan_list_by_uid($uid, $page, $pagesize);
		$pages = misc::simple_pages("?bank-loan.htm", count($datalist), $page, $pagesize);

		$this->view->assign('pages', $pages);
		$this->view->assign('datalist', $datalist);

		$this->view->assign('config', $config);
		$this->view->assign('input', $input);
		
		$this->view->display('bank_loan.htm');
	}
	
	public function on_logs() {
		$this->_checked['logs'] = 'class="checked"';
		
		$this->_title[] = '日志记录';
		$this->_nav[] = '日志记录';

		if(!$this->_user['bank_status']){
			$this->message('您还没有在本银行开户，请返回开户后再操作。', 1, $this->url('bank-profile.htm'));
		}
		$uid = $this->_user['uid'];

		// 简单分页
		$page = misc::page();
		$pagesize = 10;
		$logslist = $this->bank_logs->get_list_by_uid($uid, $page, $pagesize);
		$pages = misc::simple_pages("?bank-logs.htm", count($logslist), $page, $pagesize);

		$this->view->assign('pages', $pages);
		$this->view->assign('logslist', $logslist);
		
		$this->view->display('bank_logs.htm');
	}

	public function hack_showMyCur($user, $config){
		$returninfo = array(
			'currate'=>0,
			'daynum'=>0
		);
		$returninfo['daynum'] = floor(($_SERVER['time'] - $user['bank_begintime']) / 86400);
		if($user['bank_deposit'] != 0 && $returninfo['daynum'] != 0){
			$returninfo['currate'] = floor($returninfo['daynum'] * ($user['bank_deposit'] * ($config['current'] / 100)));
		}
		return $returninfo;
	}
}

?>