<?php

$error = $input = array();

if(!$this->form_submit()) {
	$kc_bcs_conf = $this->kv->get('kc_bcs_conf');

	$input['ak'] = form::get_text('ak', $kc_bcs_conf['ak'], 300);
	$input['sk'] = form::get_text('sk', $kc_bcs_conf['sk'], 300);
	$input['bucket'] = form::get_text('bucket', $kc_bcs_conf['bucket'], 300);
	$input['remotepath'] = form::get_text('remotepath', $kc_bcs_conf['remotepath'], 300);
	$this->view->assign('dir', $dir);
	$this->view->assign('input', $input);
	$this->view->display('plugin_kc_bcs_setting.htm');
} else {
	$ak = core::gpc('ak', 'R');
	$sk = core::gpc('sk', 'R');
	$bucket = core::gpc('bucket', 'R');
	$remotepath = core::gpc('remotepath', 'R');

	$this->kv->set('kc_bcs_conf', array('ak'=>$ak, 'sk'=>$sk, 'bucket'=>$bucket, 'remotepath'=>rtrim($remotepath, '/')));

	$this->message('设置成功！', 1, '?plugin-setting-dir-'.$dir.'.htm');
}

?>