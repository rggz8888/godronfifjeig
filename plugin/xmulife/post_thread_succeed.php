//以下同步至新浪微博代码
$post2weibo = core::gpc('post2weibo','P');
if($post2weibo){
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
	$link = 'http://www.xmulife.com/?thread-index-fid-'.$thread['fid'].'-tid-'.$thread['tid'].'.htm';//帖子地址。
	//$len_sub = strlen($thread['subject'])/2;
	//$len_mes = strlen($post['message'])/2;
	//$len_limite = 125 - $len_sub - $len_mes;
	//if($len_limite < 0) $len_limite = 0;
	$title = str_replace("\t", " ", str_replace("\n", " ", str_replace("&nbsp;", " ", $thread['subject'])));
	$message = str_replace("\t", " ", str_replace("\n", " ", str_replace("&nbsp;", " ", $post['message'])));
	$status = '【'.mb_strimwidth(strip_tags($title),0,60,'...').'】'. mb_strimwidth(strip_tags( $message),0, 140,'...').' |原文'.$link;// . ' 全文地址:' . get_permalink($post_ID);
   	$data = array( 'status' => $status, 'source'=>'2453695664' );
	$data_query = http_build_query($data,"","&");
    $json_data = postData($url, $data_query);}