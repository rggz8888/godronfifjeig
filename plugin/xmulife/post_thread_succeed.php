//合并pic_list插件中update_succeed文件

$fid = $thread['fid'];
$tid = $thread['tid'];
$pid = $thread['firstpid'];
$firstpost = $this->post->read($thread['fid'], $thread['firstpid']);
$message = $firstpost['message'];
$thread['coverimg'] = '';
if($thread['imagenum'] > 0) {
	$attachlist = $this->attach->index_fetch(array('fid'=>$fid, 'pid'=>$pid), array(), 0, 20);
	foreach($attachlist as $k=>$attach) {
		if($attach['isimage'] == 1) {
			$thread['coverimg'] = $attach['filename'];
			break;
		}
	}
}elseif(preg_match ("<[img|IMG].*[src|SRC]=[\"](.*?)[\"].*?>",$message,$match)){
	if(strstr($match[1],"img.baidu.com/hi")||strstr($match[1],"xn_editor/editor/")) $thread['coverimg']='';
	else $thread['coverimg'] = $match[1];
	}

//$message = htmlspecialchars(strip_tags($firstpost['message'],'<br> <p> <i> <b> <span> <a>'));
//$message = str_replace(array('&nbsp;', '&amp;', '&quot;', '&#039;', ' &lt;', '&gt;'), array(' ', '&', '\"', '\'', '<','>'), $message);
//$message = $firstpost['message'];
//$thread['brief'] = utf8::cutstr_cn($message, 200);
$thread['brief'] = utf8::cutstr_cn($message, 1200);
$this->thread->update($thread);

//以下同步至新浪微博代码

$post2weibo = core::gpc('post2weibo','P');
if($post2weibo){

//有图片时调用sinaweiboapi oauthutil类
//include $this->conf['plugin_path'].'xmulife/weibopic.php';
if(preg_match ("<img.*src=[\"](.*?)[\"].*?>",$message,$match)){
$pic_path = "$match[1]";
//用update.json接口发送新浪微博，2.0接口。好像appid必须是自己的微博账号创建的才能用。
$boundary = uniqid('------------------');
$MPboundary = '--'.$boundary;
$endMPboundary = $MPboundary. '--';

// 需要上传的图片所在路径
$filename_pic = $pic_path;
$file = file_get_contents($filename_pic);

$multipartbody = $MPboundary . "\r\n";
$multipartbody .= 'Content-Disposition: form-data; name="pic"; filename="xmulife.png"'. "\r\n";
$multipartbody .= 'Content-Type: image/png'. "\r\n\r\n";
$multipartbody .= $file. "\r\n";

$k = "source";
// 这里改成 appkey
$v = "2453695664";
$multipartbody .= $MPboundary . "\r\n";
$multipartbody.='content-disposition: form-data; name="'.$k."\"\r\n\r\n";
$multipartbody.=$v."\r\n";

$link = 'http://www.xmulife.com/thread-index-fid-'.$thread['fid'].'-tid-'.$thread['tid'].'.htm';//帖子地址。
$title = str_replace("\t", " ", str_replace("\n", " ", str_replace("&nbsp;", " ", $thread['subject'])));
$len_sub = strlen($title);
$message = str_replace("\t", " ", str_replace("\n", " ", str_replace("&nbsp;", " ", $post['message'])));
$len_mes = 250-$len_sub;
$status = '【'.mb_strimwidth(strip_tags($title),0,60,'...').'】'. mb_strimwidth(strip_tags( $message),0, $len_mes,'...').' |详情'.$link;// . ' 全文地址:' . get_permalink($post_ID);

$k = "status";
$v = $status;
$multipartbody .= $MPboundary . "\r\n";
$multipartbody.='content-disposition: form-data; name="'.$k."\"\r\n\r\n";
$multipartbody.=$v."\r\n";
$multipartbody .= "\r\n". $endMPboundary;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.weibo.com/2/statuses/upload.json' );
curl_setopt($ch , CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$multipartbody );
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: multipart/form-data; boundary=$boundary","Authorization: Basic ' . 'YWRtaW5AeG11bGlmZS5jb206MjAxM3htdWxpZmV3ZWlibw=='" ));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 修改成当前用户名及密码
//curl_setopt($ch, CURLOPT_USERPWD, "username:password");
$msg = curl_exec($ch);
//echo $pic_path.$msg;	
	

}else{
		function postData($url, $data){  
				$headers = array( "Authorization: Basic ' . 'YWRtaW5AeG11bGlmZS5jb206MjAxM3htdWxpZmV3ZWlibw=='" ); 
				$ch = curl_init();      
				$timeout = 300;       
				curl_setopt($ch, CURLOPT_URL, $url);     
				curl_setopt($ch, CURLOPT_REFERER, "http://www.xmulife.com");   //构造来路    
				curl_setopt($ch, CURLOPT_POST, true);      
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);      
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				//curl_setopt($ch, CURLOPT_USERPWD, "username:password");//header请求
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);      
				$handles = curl_exec($ch);      
				curl_close($ch);      
				return $handles;      
			}
			$url = 'https://api.weibo.com/2/statuses/update.json';//POST指向的链接   
			$link = 'http://www.xmulife.com/thread-index-fid-'.$thread['fid'].'-tid-'.$thread['tid'].'.htm';//帖子地址。
			//$len_sub = strlen($thread['subject'])/2;
			//$len_mes = strlen($post['message'])/2;
			//$len_limite = 125 - $len_sub - $len_mes;
			//if($len_limite < 0) $len_limite = 0;
			$title = str_replace("\t", " ", str_replace("\n", " ", str_replace("&nbsp;", " ", $thread['subject'])));
			$len_sub = strlen($title);
			$message = str_replace("\t", " ", str_replace("\n", " ", str_replace("&nbsp;", " ", $post['message'])));
			$len_mes = 250-$len_sub;
			$status = '【'.mb_strimwidth(strip_tags($title),0,60,'...').'】'. mb_strimwidth(strip_tags( $message),0, $len_mes,'...').' |详情'.$link;// . ' 全文地址:' . get_permalink($post_ID);
			$data = array( 'status' => $status, 'source'=>'2453695664' );
			$data_query = http_build_query($data,"","&");
			$json_data = postData($url, $data_query);
		}
}