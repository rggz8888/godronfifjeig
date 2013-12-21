$fid = $post['fid'];
$tid = $post['tid'];
$pid = $post['pid'];
$message = $post['message'];
$post['coverimg'] = '0';
if($post['imagenum'] > 0) {
	$post_attachlist = $this->attach->index_fetch(array('fid'=>$fid, 'pid'=>$pid), array(), 0, 20);
	foreach($post_attachlist as $k=>$post_attach) {
		if($post_attach['isimage'] == 1) {
			$post['coverimg'] = $post_attach['filename'];
			break;
		}
	}
}elseif(preg_match ("<img.*src=[\"](.*?)[\"].*?>",$message,$match)){
	if(strstr($match[1],"img.baidu.com/hi")||strstr($match[1],"js/editor/")) $post['coverimg']=0;
	else $post['coverimg'] = $match[1];
	}
$this->post->update($post);