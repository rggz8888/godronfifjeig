<?php

if(!$this->form_submit()) {

	$allCount = $this->invitationcode->getCount();
	$usedCount = $this->invitationcode->getCount(array('c_isValid'=>0));
	$input['creatNum'] = form::get_text('creatNum',50);
	$this->view->assign('input',$input);
	$this->view->assign('allCount',$allCount);
	$this->view->assign('usedCount',$usedCount);
	/* 条件输出邀请码 */
	$input['outCount'] = form::get_select('outCount',array('all'=>'全部未使用','noOut'=>'未导出过的'));
	$this->view->display('plugin_snail_invitationReg.htm');
}
if($this->form_submit()) {
	if(core::gpc('do','G') == 'creatOut') {
		$num = core::gpc('creatNum','P');
		$date = time();
		for($i = 0;$i < $num;$i++) {
			$this->invitationcode->createCode(sha1(uniqid(rand(),ture)),$date);
		}
		$regionArr = $this->invitationcode->getCodeByDate($date,$num); //试试批量读取
		foreach($regionArr as $key=>$value) {
			$content .= $value['c_code']."\n";
		
		}
		$title = date(Ymd_h_i).'邀请码输出.txt';
		header("Content-Type: application/force-download"); //强制下载保存
		header("Content-Disposition:attachment;filename=".$title);
		echo $content;
	} elseif(core::gpc('do','G') == 'out') {
		$regionArr = $this->invitationcode->getValidCode();
		$date = date('Y-m-d h:i:s');
		foreach($regionArr as $key=>$value) {
			$content .= $value['c_code'].' 生成时间【'.date('Y-m-d H:i:s',$value['c_date'])."】\n";
		
		}
		$title = date(Ymd_h_i).'邀请码输出.txt';
		header("Content-Type: application/force-download"); //强制下载保存
		header("Content-Disposition:attachment;filename=".$title);
		echo $content;
	}
}


?> 