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
							<a href="http://www.xmulife.com/forum-index-fid-<?php echo isset($_fid) ? $_fid : '';?>.htm" <?php echo isset($_checked["forum_$_fid"]) ? $_checked["forum_$_fid"] : '';?>><?php echo isset($_name) ? $_name : '';?></a>	
							<?php }}?>
							<span class="sep"></span>
<a href="http://www.xmulife.com/index-yyct.htm" target="_blank" <?php echo isset($_checked['forum_yyct']) ? $_checked['forum_yyct'] : '';?>  id="menu_forum_list">音乐畅听</a>	
						</td>
						<td class="center2">

							
							<?php if($conf['search_type']) { ?>
							<form action="http://www.xmulife.com/search-index.htm" target="_blank" id="search_form" method="post">
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
		
		

<link href="http://xmulife.u.qiniudn.com/view/my.css" type="text/css" rel="stylesheet" />

<div class="width">

		<table id="nav" cellpadding="0" cellspacing="0" style="margin-bottom: 4px; clear: both;">
		<tr>
			<td class="left"></td>
			<td class="center">
				<a href="./" class="icon icon-home"></a>
				<span class="sep"></span>
				
				<a href="http://www.xmulife.com/my-profile.htm">我的空间</a>
				<?php if(!empty($_nav)) { foreach($_nav as &$nav) {?>
				<span class="sep"></span>
				<span><?php echo isset($nav) ? $nav : '';?></span>
				<?php }} ?>
			</td>
			<td class="center2">				<span id="user">
					
				<?php if($_user['groupid'] == 0) { ?>
					<a href="http://www.xmulife.com/user-login.htm" class="ajaxdialog" onclick="return false" rel="nofollow"><span class="icon icon-user-user"></span> 登录</a>
					<a href="http://www.xmulife.com/user-create.htm" class="ajaxdialog" onclick="return false" rel="nofollow"><span class="icon icon-user-create"></span> 注册</a>
				<?php } else { ?>
					
					<a href="http://www.xmulife.com/my-profile.htm" title="<?php echo isset($_user['groupname']) ? $_user['groupname'] : '';?>"><span class="icon icon-user-user"></span> <?php echo isset($_user['username']) ? $_user['username'] : '';?></a>
					
					<?php if($_user['groupid'] == 6) { ?>
					<a href="http://www.xmulife.com/user-reactive.htm">邮箱激活</a>
					<?php } ?>
					
					<span id="pm">
						<a href="http://www.xmulife.com/my-pm.htm" class="pm"><span class="icon icon-pm"></span> 消息</a><a href="http://www.xmulife.com/my-pm.htm" style="display: none;" aria-label="消息" class="newpm"><span class="icon icon-newpm"></span> 消息</a>
					</span>
				
					<?php if($_user['groupid'] > 0 && $_user['groupid'] < 6) { ?>
					<a href="admin/" target="_blank"><span class="icon icon-setting"></span> 管理</a>
					<?php } ?>
				
					<a href="http://www.xmulife.com/user-logout.htm" class="ajaxdialog" onclick="return false"><span class="icon icon-user-logout"></span> 退出</a>
				<?php } ?>
					
				</span></td>
			<td class="right"></td>
		</tr>
	</table>


	<div class="left border shadow bg2">
		<div style="margin-top: 4px; text-align: center;">
	<span class="avatar_big border" id="avatar_menu" style="<?php if($_user['avatar_big']) { ?>background-image: url(<?php echo isset($_user['avatar_big']) ? $_user['avatar_big'] : '';?>)<?php } ?>"></span>
</div>

<div style="text-align: center; margin-bottom: 8px;" class="grey">
	<?php echo isset($_user['username']) ? $_user['username'] : '';?>
</div>

<ul class="left_menu">
	
	<li <?php echo isset($_checked['my_profile']) ? $_checked['my_profile'] : '';?>><a href="http://www.xmulife.com/my-profile.htm">我的资料</a></li>
	<li <?php echo isset($_checked['my_post']) ? $_checked['my_post'] : '';?>><a href="http://www.xmulife.com/my-post.htm">我的发帖</a></li>
	<li <?php echo isset($_checked['my_follow']) ? $_checked['my_follow'] : '';?>><a href="http://www.xmulife.com/my-follow.htm">我的联系人</a></li>
	<li <?php echo isset($_checked['my_wealth']) ? $_checked['my_wealth'] : '';?>><a href="http://www.xmulife.com/my-income.htm">我的财富</a></li>
	<li <?php echo isset($_checked['my_file']) ? $_checked['my_file'] : '';?>><a href="http://www.xmulife.com/my-upload.htm">我的文件</a></li>
	<li <?php echo isset($_checked['my_collect']) ? $_checked['my_collect'] : '';?>><a href="http://www.xmulife.com/my-collect.htm">我的收藏</a></li><li <?php echo isset($_checked['my_thread']) ? $_checked['my_thread'] : '';?>><a href="http://www.xmulife.com/my-thread.htm">我的主题</a></li>
</ul>
	</div>
	
	<div class="right">
		<div class="page tab" style="margin-bottom: 4px;">
						<a href="http://www.xmulife.com/my-upload.htm" <?php echo isset($_checked['upload']) ? $_checked['upload'] : '';?>>上传文件</a>
			<a href="http://www.xmulife.com/my-image.htm" <?php echo isset($_checked['image']) ? $_checked['image'] : '';?>>上传图片</a>
			<a href="http://www.xmulife.com/my-download.htm" <?php echo isset($_checked['download']) ? $_checked['download'] : '';?>>下载附件</a>
			
		</div>
		<div class="list">
			<table class="table">
				<tr class="header">
					<td align="left">附件名</td>
					<td width="80">上传时间</td>
					<td width="30">售价</td>
					<td width="52">下载次数</td>
					<td width="30">收入</td>
					<td width="80">版块</td>
					<td width="52">所在主题</td>
					<td width="80">查看下载历史</td>
				</tr>
				<?php if($attachlist) { ?>
				<?php if(!empty($attachlist)) { foreach($attachlist as &$attach) {?>
				<tr>
					<td><a href="<?php echo isset($conf['cloud_url']) ? $conf['cloud_url'] : '';?>attach/<?php echo isset($attach['filename']) ? $attach['filename'] : '';?>" target="_blank"><?php echo isset($attach['orgfilename']) ? $attach['orgfilename'] : '';?></a></td>
					<td><?php echo isset($attach['dateline_fmt']) ? $attach['dateline_fmt'] : '';?></td>
					<td><?php echo isset($attach['golds']) ? $attach['golds'] : '';?></td>
					<td><?php echo isset($attach['downloads']) ? $attach['downloads'] : '';?></td>
					<td><?php echo isset($attach['incomes']) ? $attach['incomes'] : '';?></td>
					<td><a href="http://www.xmulife.com/forum-index-fid-<?php echo isset($attach['fid']) ? $attach['fid'] : '';?>.htm" target="_blank"><?php echo isset($attach['forumname']) ? $attach['forumname'] : '';?></a></td>
					<td><a href="http://www.xmulife.com/my-attachthread-fid-<?php echo isset($attach['fid']) ? $attach['fid'] : '';?>-pid-<?php echo isset($attach['pid']) ? $attach['pid'] : '';?>.htm" target="_blank">点击查看</a></td>
					<td><a href="http://www.xmulife.com/my-downlog-fid-<?php echo isset($attach['fid']) ? $attach['fid'] : '';?>-aid-<?php echo isset($attach['aid']) ? $attach['aid'] : '';?>.htm">查看下载历史</a></td>
				</tr>
				<?php }} ?>
				<?php } else { ?>
				<tr>
					<td colspan="8">无</td>
				</tr>
				<?php } ?>
			</table>
		</div>
		<div class="page" style="text-align: center;"><?php echo isset($pages) ? $pages : '';?></div>
	</div>
</div>	

		
		</div>
		
	</div>
	
</div>




<div id="footer" role="contentinfo">
	
	<table class="width">
		<tr>
			<td class="left">
				<?php echo isset($conf['app_copyright']) ? $conf['app_copyright'] : '';?><a target="_blank" href="http://sighttp.qq.com/authd?IDKEY=a42910c890c06e93dea1b01d3d344461f658a367e80e9e4f"><img border="0"  src="http://wpa.qq.com/imgd?IDKEY=a42910c890c06e93dea1b01d3d344461f658a367e80e9e4f&pic=41" alt="和团队交流" title="和团队交流"/></a><br />
				Powered by  <a href="http://bbs.xiuno.com" target="_blank" class="grey">Xiuno BBS <b><?php echo isset($conf['version']) ? $conf['version'] : '';?></b></a>
				
			</td>
			<td class="right">
				<?php echo isset($conf['china_icp']) ? $conf['china_icp'] : '';?><br />
				<?php echo isset($_SERVER['time_fmt']) ? $_SERVER['time_fmt'] : '';?>, 耗时:<?php echo number_format(microtime(1) - $_SERVER['starttime'], 4);?>s
				<script language="javascript" type="text/javascript" src="http://xmulife.u.qiniudn.com/myjs/16432044.js"></script>
<noscript><img alt="&#x6211;&#x8981;&#x5566;&#x514D;&#x8D39;&#x7EDF;&#x8BA1;" src="http://img.users.51.la/16432044.asp" style="border:none" /></noscript>
			</td>
		</tr>
	</table>
	
</div>

<?php if(DEBUG == 1 && $_user['groupid'] == 1 || DEBUG == 2) { ?>

<div class="box">
<h3>Debug Information: </h3>
<pre>

<b>Memory</b> = <?php echo memory_get_usage();?>

<b>Processtime</b> = <?php echo number_format(microtime(1) - $_SERVER['starttime'], 4);?>

<b>REQUEST_URI:</b> = <a href="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';?>" target="_blank" style="color: #888888"><?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';?></a>

<b>_GET</b> = <?php echo htmlspecialchars(print_r($_GET, 1));?>

<b>_POST</b> = <?php echo htmlspecialchars(print_r($_POST, 1));?>

<b>_COOKIE</b> = <?php echo htmlspecialchars(print_r($_COOKIE, 1));?>

<b>SQL:</b> = <?php isset($_SERVER['sqls']) && print_r($_SERVER['sqls']);?>

<?php if(DEBUG == 2) { ?>
<b>time:</b> = <?php echo isset($_SERVER['time']) ? $_SERVER['time'] : '';?><br />
<b>_user</b> = <?php print_r($_user);?>
<b>conf</b> = <?php unset($conf['db'], $conf['cache']);print_r($conf);?>
<?php } ?>

<b>include:</b> = <?php print_r(get_included_files());?>

</pre>
	
</div>

<?php } ?>

<?php if(DEBUG) { ?>
<script src="http://xmulife.u.qiniudn.com/view/js/jquery-1.4.full.js" type="text/javascript" ></script>
<?php } else { ?>
<script src="http://xmulife.u.qiniudn.com/view/js/jquery-1.4.min.js" type="text/javascript" ></script>
<?php } ?>

<script src="http://xmulife.u.qiniudn.com/view/js/common.js" type="text/javascript"></script>

<script src="http://xmulife.u.qiniudn.com/view/js/dialog.js" type="text/javascript"></script>

<script type="text/javascript">

$('#search input').focus(function() {$('#search').addClass('hover');});
$('#search input').blur(function() {$('#search').removeClass('hover');});
$('#search input').keyup(function(e) {
	if(e.which == 13 || e.which == 10) {
		var val = encodeURIComponent($(this).val());
		$('#search_form').attr('action', 'http://www.xmulife.com/search-index-keyword-'+val+'.htm');
		$('#search_form').submit();
		return false;
	}
});

// 登陆后才能发帖
$('#create_thread').click(function() {
	if(g_uid == 0) {
		ajaxdialog_request('http://www.xmulife.com/user-login.htm', function() {
			$('#create_thread').unbind('click');
			ajaxdialog_request($('#create_thread').attr('href'));
			$('#create_thread').click(function() {
				ajaxdialog_request($('#create_thread').attr('href'));
			});
		}, {fullicon: 1});
		return false;
	} else {
		ajaxdialog_request($('#create_thread').attr('href'), null);
		return false;
	}
});

$('a.ajaxdialog, input.ajaxdialog').die('click').live('click', ajaxdialog_click);
$('a.ajaxtoggle').die('click').live('click', ajaxtoggle_event);

//$('div.list .table tr:odd').not('tr.header').addClass('odd');	/* 奇数行的背景色 */
//$('div.list .table tr:last').addClass('last');	/* 奇数行的背景色 */

<?php if($_user['uid']) { ?>
// ------------------------> 短消息 start
	
	function userlist_to_html(userlist) {
		var s = '<div id="pm_userlist">';
		for(k in userlist) {
			var user = userlist[k];
			s += '<a href="http://www.xmulife.com/pm-ajaxlist-uid-'+user.uid+'-ajax-1.htm" uid="'+user.uid+'" class="ajaxdialog" ajaxdialog="{position: \'center\', modal: false, cache: false}"><span class="avatar_small" style="'+(user.avatar_small ? 'background-image: url('+user.avatar_small+')' : '')+'"></span> '+user.username+' (<b class="red">'+user.newpms+'</b>)</a>';
		}
		s += '</div>';
		return s;
	}
	
	// 如果有新短消息，除了全局提示以外，再做一个全局标记，实现模拟即时聊天。
	var g_newpm_userlist = null;	// 全局变量
	
	// 心跳频率  根据负载来调整，如果PV <10W: 1秒, <100w 2秒, <600w 3秒, 600w+, 5秒
	var g_newpm_delay = <?php echo isset($pm_delay) ? $pm_delay : '';?>;
	
	function newpm() {
		var _this = this;
		_this.delay = g_newpm_delay;
		_this.t = null;
		_this.stop = function() {
			if(_this.t) clearTimeout(_this.t);
		};
		_this.run = function() {
			_this.stop();
			_this.t = setTimeout(function() {
				//print_r('http://www.xmulife.com/pm-new-ajax-1.htm');
				$.get('http://www.xmulife.com/pm-new-ajax-1.htm', function(s) {
					var json = json_decode(s);
					if(error = json_error(json)) {return false;}
					// alert(error);
					
					if(json.status == 1) {
						

						
						var userlist = json.message;
						g_newpm_userlist = userlist;
						var s = userlist_to_html(userlist);
						$('#pm a.pm').hide();
						$('#pm a.newpm').show().unbind('mouseover').mouseover(function() {
							$('#pm a.newpm').alert(s, {"width": 150, "pos": 7, "delay": 1000, "alerticon": 0});
						});
						_this.delay = g_newpm_delay;
						_this.run();
					} else if(json.status == 2) {
						g_newpm_userlist = null;
						_this.delay = _this.delay * 2;
						_this.run();
					} else if(json.status == -1) {
						// 退出登录，什么都不做
					} else {
						// 发生错误，不提示，否则太频繁，影响用户体验。可以在后台查看PHP错误日志
						// alert(json.message);
					}
				});
			}, _this.delay);
		};
		return this;
	}
	
	
	var newpm_instance = new newpm(); 
	newpm_instance.run();
	
	<?php if(DEBUG == 2) { ?>
	//newpm_instance.stop();
	<?php } ?>
	// ----------------> 短消息 end
	
	// 鼠标放在上面，显示最后联系的5个人。

<?php } ?>

</script>

<?php echo isset($conf['footer_js']) ? $conf['footer_js'] : '';?>

<?php if(isset($thread)) { ?>
<script>
$('#button_collect').click(function(){
	$.get('http://www.xmulife.com/my-addcollect-fid-<?php echo isset($thread['fid']) ? $thread['fid'] : '';?>-tid-<?php echo isset($thread['tid']) ? $thread['tid'] : '';?>-ajax-1.htm', function(s) {
			var json = json_decode(s);
			if(error = json_error(json)) {alert(error); return false;}
			if(json.status <= 0) {alert(json.message); return false;}
			json = json.message;
			//alert(json);
			$('#collect_notice').html(json);
	});	
})
</script>
<?php } ?>
<script type="text/javascript" src="<?php echo isset($conf['static_url']) ? $conf['static_url'] : '';?>plugin/UpMenuDown/UpMenuDown.js"></script>
<link href="<?php echo isset($conf['static_url']) ? $conf['static_url'] : '';?>plugin/UpMenuDown/updown.css" type="text/css" rel="stylesheet" />
<div class="TopBottomMenu" style="display: none;">
<ul>
		<li>
		<b><font size="2" color="red">欢迎光临厦大生活网，意见、建议、合作、加入我们请联系底部QQ</font></b>
		</li>
	</ul>
</div>
<script type="text/javascript">$(document).ready(function(){$(this).dwseeTopBottomMenu()})</script>


</body>
</html>