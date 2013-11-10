<?php

if($this->form_submit()) {
	$postshow = core::gpc('postshow', 'P');
	$pmshow = core::gpc('pmshow', 'P');
	$trigger = core::gpc('trigger', 'P');
	$probability = core::gpc('probability', 'P');
	$getevent = core::gpc('getevent', 'P');
	$loseevent = core::gpc('loseevent', 'P');
	$cleardata = core::gpc('cleardata', 'P');
	if($postshow){
		$this->message('meta标签格式不正确！');
	}
	$event['postshow'] = $postshow;
	$event['pmshow'] = $pmshow;
	$event['trigger'] = $trigger;
	$event['probability'] = $probability;
	$event['cleardata'] = $cleardata;
	
	$event['getevent'] = explode("\n",$getevent);
	$event['loseevent'] = explode("\n",$loseevent);
	
	$this->kv->set('event_setting', $event);
	$this->view->assign('event_setting', $event);
	
	$this->message('设置成功！', 1, $this->url('plugin-setting-dir-bj_random_event.htm'));
}else{
	$event = $this->kv->get('event_setting');
	
	!isset($event['postshow']) && $event['postshow'] = 0;
	!isset($event['pmshow']) && $event['pmshow'] = 0;
	!isset($event['trigger']) && $event['trigger'] = 100;
	!isset($event['probability']) && $event['probability'] = 50;
	!isset($event['getevent']) && $event['getevent'] = '1,5|#username#走在路上，捡到了#golds#个金币。';
	!isset($event['loseevent']) && $event['loseevent'] = '1,5|#username#走在路上，丢失了#golds#个金币。';
	!isset($event['cleardata']) && $event['cleardata'] = 0;
	
	$input['postshow'] = form::get_radio_yes_no('postshow', $event['postshow']);
	$input['pmshow'] = form::get_radio_yes_no('pmshow', $event['pmshow']);
	$input['trigger'] = form::get_text('trigger', $event['trigger'], 50);
	$input['probability'] = form::get_text('probability', $event['probability'], 50);
	$input['getevent'] = form::get_textarea('getevent', $event['getevent'] == "" ? "" : implode("\n", $event['getevent']), 400, 80);
	$input['loseevent'] = form::get_textarea('loseevent', $event['loseevent'] == "" ? "" : implode("\n", $event['loseevent']), 400, 80);
	$input['cleardata'] = form::get_radio_yes_no('cleardata', $event['cleardata']);
	
	$this->view->assign('dir', $dir);
	$this->view->assign('input', $input);
	$this->view->display('plugin_event_setting.htm');
}

?> 