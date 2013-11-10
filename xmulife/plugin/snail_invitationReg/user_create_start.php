if($this->form_submit()) {
	$invitationCode = core::gpc('invitationCode', 'P');
	if($invitationCode == '') {
		$this->message('请填写邀请码',0);
		exit();
	}
	$codeArr = $this->invitationcode->getCodeArr($invitationCode);
	if(!$codeArr) {
		$this->message('您输入的邀请码无效',0);
		eixt();
	}
	if($codeArr['c_isValid'] == 0) {
		$this->message('该邀请码已经被使用过了',0);
		exit();
	}
}