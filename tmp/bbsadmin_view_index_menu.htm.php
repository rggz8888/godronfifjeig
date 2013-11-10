<?php !defined('FRAMEWORK_PATH') && exit('Access Denied');?><!DOCTYPE html>
<head>   
	<title><?php if(!empty($_title)) { foreach($_title as &$title) {?><?php echo isset($title) ? $title : '';?><?php }} ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="MSSmartTagsPreventParsing" content="True" />
	<meta http-equiv="MSThemeCompatible" content="Yes" />
	<link href="<?php echo isset($bbsconf['static_url']) ? $bbsconf['static_url'] : '';?>view/common.css" type="text/css" rel="stylesheet" />
	<style>
		#body {margin: 0px;}
		/* accordion 仅后台使用 */
		#accordion h3, #accordion ul {padding:0px;margin:0px;}
		#accordion h3 {font-size:12px; color:#FFFFFF; line-height: 20px; height: 20px; text-indent: 4px; padding:0px; cursor:pointer; background:url('../view/image/page.gif') repeat-x;}
		#accordion h3 a {color:#FFFFFF;}
		#accordion ul {padding-bottom:2px; border-left:1px #CCCCCC solid; border-right:1px #CCCCCC solid;}
		#accordion li {font-size:12px; padding-left:10px; list-style-type:none; background-color:#FFFFFF; line-height:1.8;}
		.width {width: 800px; margin: auto; overflow: hidden;}
	</style>
	<script type="text/javascript">
	var cookie_pre = '<?php echo isset($conf['cookie_pre']) ? $conf['cookie_pre'] : '';?>';
	</script>
</head>
<body>
<div id="body">

<style>
#body {width: 100%; padding: 0px;}
#leftmenu {min-height: 1004px;}
#leftmenu ul{margin-top: 0px; padding-top: 16px;}
#leftmenu li{height: 24px; line-height: 24px;}
#leftmenu a.checked{font-weight: 800;}
</style>

<div id="leftmenu" class="bg4">
<?php if(empty($type) || $type == 'conf') { ?>
	<ul>
		<li><a href="http://www.xmulife.com/admin/index-main.htm" target="main" class="checked">站点信息</a></li>
		<li><a href="http://www.xmulife.com/admin/conf-base.htm" target="main">基本设置</a></li>
		<li><a href="http://www.xmulife.com/admin/conf-mail.htm" target="main">SMTP设置</a></li>
		<li><a href="http://www.xmulife.com/admin/conf-badword.htm" target="main">关键词过滤</a></li>
		
	</ul>
<?php } elseif($type == 'user') { ?>
	<ul>
		<li><a href="http://www.xmulife.com/admin/user-list.htm" target="main">会员管理</a></li>
		<li><a href="http://www.xmulife.com/admin/group-index.htm" target="main">用户组</a></li>
		
	</ul>
<?php } elseif($type == 'forum') { ?>
	<ul>
		<li><a href="http://www.xmulife.com/admin/forum-list.htm" target="main">版块管理</a></li>
		<li><a href="http://www.xmulife.com/admin/forum-merge.htm" target="main">合并版块</a></li>
		
	</ul>
<?php } elseif($type == 'post') { ?>
	<ul>
		<li><a href="http://www.xmulife.com/admin/thread-list.htm" target="main">帖子管理</a></li>
		
	</ul>
<?php } elseif($type == 'log') { ?>
	<ul>
		<li><a href="http://www.xmulife.com/admin/log-login.htm" target="main">登录错误</a></li>
		<li><a href="http://www.xmulife.com/admin/log-phperror.htm" target="main">PHP错误日志</a></li>
		<li><a href="http://www.xmulife.com/admin/log-cron.htm" target="main">计划任务日志</a></li>
		
	</ul>
<?php } elseif($type == 'other') { ?>
	<ul>
		<li><a href="http://www.xmulife.com/admin/stat-index.htm" target="main">统计信息</a></li>
		<li><a href="http://www.xmulife.com/admin/conf-cache.htm" target="main">更新缓存</a></li>
		<li><a href="http://www.xmulife.com/admin/banip.htm" target="main">禁止IP</a></li>
		<li><a href="http://www.xmulife.com/admin/thread-jubao.htm" target="main">举报管理</a></li>
	</ul>
<?php } elseif($type == 'mod') { ?>
	<ul>
		<li><a href="http://www.xmulife.com/admin/mod-setforum.htm" target="main">版块设置</a></li>
		<li><a href="http://www.xmulife.com/admin/mod-listlog.htm" target="main">操作日志</a></li>
		<li><a href="http://www.xmulife.com/admin/mod-ratelog.htm" target="main">评分日志</a></li>
		<?php if($_group['allowbanuser'] || $_group['allowdeleteuser']) { ?>
		<li><a href="http://www.xmulife.com/admin/mod-manageuser.htm" target="main">管理用户</a></li>
		<?php } ?>
		
	</ul>
<?php } elseif($type == 'plugin') { ?>
	<ul>
		<li><a href="http://www.xmulife.com/admin/plugin-index.htm" target="main">本地插件</a></li>
		<li><a href="http://www.xmulife.com/admin/plugin-list.htm" target="main">线上插件</a></li>
		<li><a href="http://www.xmulife.com/admin/friendlink-list.htm" target="main">友情链接</a></li>
	</ul>
<?php } ?>



</div>

<script type="text/javascript" src="<?php echo isset($bbsconf['static_url']) ? $bbsconf['static_url'] : '';?>view/js/jquery-1.4.min.js"></script>
<script>
$('#leftmenu a').click(function() {
	$('#leftmenu a').removeClass('checked');
	$(this).addClass('checked');
});

// 第一个菜单为选中状态
$('#leftmenu li:first a').addClass('checked');
parent.main.location = $('#leftmenu li:first a').attr('href');
</script>

</body>
</html>