<?php

!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');
$error = $input = array();
$start = intval(core::gpc('start', 'R'));
$fid = intval(core::gpc('fid', 'R'));

if(!$this->form_submit() && empty($start)) {
	
	$input = array();
	$forumoptions = $this->forum->get_options($this->_user['uid'], $this->_user['groupid'], $fid, $defaultfid);
	$this->view->assign('forumoptions', $forumoptions);
	
	$this->view->assign('dir', $dir);
	$this->view->assign('input', $input);
	$this->view->display('xn_postlist_thumb.htm');
} else {
	
	$limit = DEBUG ? 1 : 200;
	$postlist = $this->post->index_fetch(array('message'=>array('LIKE'=>'%<img%'),'pid'=>array('>'=>$start)), array('pid'=>-1), 0, $limit);
	$postlist = array_filter($postlist);
	if(!empty($postlist)){
		foreach($postlist as $post) {
			$k++;
			$fid = $post['fid'];
			$pid = $post['pid'];
			$tid = $post['tid'];
			if(preg_match_all('/<img.*?>/im' , $post['message'],$match )){
			$img = $match[0][0]; //把图片的img整个都获取出来了 
			preg_match_all ('|src="(.*)"|isU', $img, $img1); 
			$img_path = $img1[1][0];//获取第一张图片路径 
			$img_path = str_replace($this->conf['static_url'],'',$img_path);
			if(strstr($img_path,'img.baidu.com/hi')||strstr($img_path,'js/editor'))
			$post['coverimg'] = 0;else $post['coverimg']=$img_path;
			$this->post->update($post);}
			
		}
			$start = $post['pid'];
			$this->message("正在建立数据,大概5分钟，请稍后, 当前pid: $start ...", 1, $this->url("plugin-setting-dir-$dir-fid-$fid-start-$start.htm"));
	} else {
		$this->message('恭喜，建立数据成功。', 1, $this->url("plugin-setting-dir-$dir.htm"));
	}
}

?>