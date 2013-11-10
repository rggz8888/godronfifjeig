<?php !defined('FRAMEWORK_PATH') && exit('Access Denied');?><!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="keywords" content="<?php echo isset($_seo_keywords) ? $_seo_keywords : '';?>" />
	<meta name="description" content="<?php echo isset($_seo_description) ? $_seo_description : '';?> " />
	<meta name="generator" content="Xiuno BBS" />
	<meta name="author" content="Xiuno Team" />
	<meta name="copyright" content="2008-2012 xiuno.com" />
	<meta name="MSSmartTagsPreventParsing" content="True" />
	<meta http-equiv="MSThemeCompatible" content="Yes" />
	<!--<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />-->
	<link href="<?php echo isset($conf['plugin_url']) ? $conf['plugin_url'] : '';?>xmulife/mycommon.css" type="text/css" rel="stylesheet" />
	<link href="http://xmulife.u.qiniudn.com/view/common.css" type="text/css" rel="stylesheet" />
	<link rel="shortcut icon" href="favicon.ico" />
	<link href="<?php echo isset($conf['plugin_url']) ? $conf['plugin_url'] : '';?>xmulife/mycommon.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="http://xmulife.u.qiniudn.com/jquery.min.js"></script>
<script>
	(function($){
		//方案二
		$(window).bind("scroll",function() {
		 	var temp = '0';
		 	//判断往下滚
		 	if ($(document).scrollTop() > temp) {   //如果大于这个高度，就置顶
		 		flag = false;
		 		$('#menu').css({'position':'fixed', 'top':'0px', 'z-index':'999','margin-top':'0px','opacity':'0.8','filter':'alpha(opacity=80)'});
		 	}
			
			if ($(document).scrollTop() <= temp) {  //如果小于这个高度，则恢复原来状态
		 		flag = true;
		 		$('#menu').css({'position':'','opacity':'1','filter':'alpha(opacity=100)'});
		 	}
		 });
	})(jQuery);
	</script>
	<script type="text/javascript">
	var cookie_pre = '<?php echo isset($conf['cookie_pre']) ? $conf['cookie_pre'] : '';?>';
	var g_uid = <?php echo isset($_user['uid']) ? $_user['uid'] : '';?>;
	</script>
	<title><?php if(!empty($_title)) { foreach($_title as &$title) {?><?php echo isset($title) ? $title : '';?> <?php }} ?></title>
</head>
<body>

<div id="wrapper1">
	
	<div id="wrapper2">
		
		<div id="menu" role="navigation">
			<div class="width">
				<table cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
					<tr>
						<td class="left"></td>
						<td class="logo"></td>
						<td class="center">
							
							<span class="sep"></span>
							<a href="./" <?php echo isset($_checked['index']) ? $_checked['index'] : '';?>>首页</a>
							
							<?php if(!empty($conf['forumarr'])) { foreach($conf['forumarr'] as $_fid=>&$_name) {?>
							<span class="sep"></span>
							<a href="http://127.0.0.1/forum-index-fid-<?php echo isset($_fid) ? $_fid : '';?>.htm" <?php echo isset($_checked["forum_$_fid"]) ? $_checked["forum_$_fid"] : '';?>><?php echo isset($_name) ? $_name : '';?></a>	
							<?php }}?>
							<span class="sep"></span>
<a href="http://127.0.0.1/index-yyct.htm" target="_blank" <?php echo isset($_checked['forum_yyct']) ? $_checked['forum_yyct'] : '';?>  id="menu_forum_list">音乐畅听</a>	
						</td>
						<td class="center2">

							
							<?php if($conf['search_type']) { ?>
							<form action="http://127.0.0.1/search-index.htm" target="_blank" id="search_form" method="post">
								<div id="search"><input type="text" id="search_keyword" name="keyword" x-webkit-speech lang="zh-CN" placeholder="输入标题关键字"/></div>
								
							</form>
							<?php } ?>
						
							
							
							
							
						</td>
						<td class="right"></td>
					</tr>
				</table>
			</div>
		</div>
							
		
		
		<div id="body" role="main">
		
		